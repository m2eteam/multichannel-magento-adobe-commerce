<?php

declare(strict_types=1);

namespace M2E\Multichannel\Model\Extension;

class SourceLoader
{
    private const DATA_FILE_PATH = '/Files/data.json';
    private const DATA_SERVER_URL = 'https://download.m2epro.com/multichannel/source/v1';

    private \Magento\Framework\Module\Dir $moduleDir;
    private \Magento\Framework\HTTP\Client\Curl $curlClient;

    public function __construct(
        \Magento\Framework\Module\Dir $moduleDir,
        \Magento\Framework\HTTP\Client\Curl $curlClient
    ) {
        $this->moduleDir = $moduleDir;
        $this->curlClient = $curlClient;
    }

    public function loadSource(): array
    {
        $source = $this->retrieveServerContent();

        return json_decode($source, true);
    }

    public function loadDefaultSource(): array
    {
        $source = $this->retrieveLocalContent();

        return (array)json_decode($source, true);
    }

    private function retrieveServerContent(): string
    {
        $this->curlClient->get(self::DATA_SERVER_URL);

        return $this->curlClient->getBody();
    }

    private function retrieveLocalContent(): string
    {
        $moduleDir = $this->moduleDir->getDir(\M2E\Multichannel\Helper\Module::IDENTIFIER);

        return file_get_contents($moduleDir . self::DATA_FILE_PATH);
    }
}
