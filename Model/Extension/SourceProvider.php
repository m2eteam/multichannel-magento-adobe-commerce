<?php

declare(strict_types=1);

namespace M2E\Multichannel\Model\Extension;

class SourceProvider
{
    private const FIELD_ID = 'id';
    private const FIELD_MODULE_NAME = 'module_name';
    private const FIELD_MODULE_LABEL = 'module_label';
    private const FIELD_TITLE = 'title';
    private const FIELD_DESCRIPTION = 'description';
    private const FIELD_ICON = 'icon';
    private const FIELD_URL = 'url';
    private const FIELD_URL_DOCS = 'docs';
    private const FIELD_URL_SUPPORT = 'support';
    private const FIELD_URL_MARKETPLACE = 'marketplace';
    private const FIELD_URL_DOC_INSTALL = 'docs_install';

    private const CACHE_KEY = 'multichannel_sources';
    private const CACHE_LIFETIME = 86400;

    /** @var Source[] */
    private array $sources;
    private \M2E\Multichannel\Model\Extension\SourceLoader $sourceLoader;
    private \M2E\Multichannel\Model\Cache $cache;

    public function __construct(
        SourceLoader $sourceLoader,
        \M2E\Multichannel\Model\Cache $cache
    ) {
        $this->sourceLoader = $sourceLoader;
        $this->cache = $cache;
    }

    /**
     * @return Source[]
     */
    public function get(): array
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (isset($this->sources)) {
            return $this->sources;
        }

        $rawData = $this->loadSource();
        $this->sources = [];
        foreach ($rawData as $rawExtension) {
            $this->sources[] = $this->createSource($rawExtension);
        }

        return $this->sources;
    }

    private function loadSource(): array
    {
        if ($this->cache->getValue(self::CACHE_KEY)) {
            return $this->cache->getValue(self::CACHE_KEY);
        }

        try {
            $sources = [];
            foreach ($this->sourceLoader->loadSource() as $data) {
                if (!$this->isValidRawData($data)) {
                    continue;
                }
                $sources[] = $this->normalizeRawData($data);
            }
        } catch (\Throwable $e) {
            return $this->getDefaultList();
        }

        $this->cache->setValue(self::CACHE_KEY, $sources, [], self::CACHE_LIFETIME);

        return $sources;
    }

    private function isValidRawData($data): bool
    {
        return isset($data[self::FIELD_ID])
            && isset($data[self::FIELD_MODULE_NAME])
            && isset($data[self::FIELD_MODULE_LABEL])
            && isset($data[self::FIELD_TITLE])
            && isset($data[self::FIELD_URL][self::FIELD_URL_DOCS])
            && isset($data[self::FIELD_URL][self::FIELD_URL_SUPPORT])
            && isset($data[self::FIELD_URL][self::FIELD_URL_MARKETPLACE])
            && isset($data[self::FIELD_URL][self::FIELD_URL_DOC_INSTALL]);
    }

    private function normalizeRawData(array $data): array
    {
        return [
            self::FIELD_ID => $data[self::FIELD_ID],
            self::FIELD_TITLE => $data[self::FIELD_TITLE],
            self::FIELD_MODULE_NAME => $data[self::FIELD_MODULE_NAME],
            self::FIELD_MODULE_LABEL => $data[self::FIELD_MODULE_LABEL],
            self::FIELD_DESCRIPTION => $data[self::FIELD_DESCRIPTION] ?? null,
            self::FIELD_ICON => $data[self::FIELD_ICON] ?? null,
            self::FIELD_URL => [
                self::FIELD_URL_DOCS => $data[self::FIELD_URL][self::FIELD_URL_DOCS],
                self::FIELD_URL_SUPPORT => $data[self::FIELD_URL][self::FIELD_URL_SUPPORT],
                self::FIELD_URL_MARKETPLACE => $data[self::FIELD_URL][self::FIELD_URL_MARKETPLACE],
                self::FIELD_URL_DOC_INSTALL => $data[self::FIELD_URL][self::FIELD_URL_DOC_INSTALL],
            ],
        ];
    }

    private function getDefaultList(): array
    {
        return $this->sourceLoader->loadDefaultSource();
    }

    private function createSource(array $rawExtension): \M2E\Multichannel\Model\Extension\Source
    {
        return new Source(
            $rawExtension[self::FIELD_ID],
            $rawExtension[self::FIELD_MODULE_NAME],
            $rawExtension[self::FIELD_MODULE_LABEL],
            $rawExtension[self::FIELD_TITLE],
            $this->createMetadata($rawExtension[self::FIELD_URL]),
            $rawExtension[self::FIELD_DESCRIPTION] ?? null,
            $rawExtension[self::FIELD_ICON] ?? null
        );
    }

    private function createMetadata(array $rawExtension): \M2E\Multichannel\Model\Extension\Source\Metadata
    {
        return new \M2E\Multichannel\Model\Extension\Source\Metadata(
            $rawExtension[self::FIELD_URL_DOCS],
            $rawExtension[self::FIELD_URL_SUPPORT],
            $rawExtension[self::FIELD_URL_MARKETPLACE],
            $rawExtension[self::FIELD_URL_DOC_INSTALL]
        );
    }
}
