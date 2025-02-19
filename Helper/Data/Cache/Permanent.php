<?php

declare(strict_types=1);

namespace M2E\Multichannel\Helper\Data\Cache;

class Permanent
{
    private \M2E\Core\Model\Cache\AdapterFactory $adapterFactory;
    private \M2E\Core\Model\Cache\Adapter $adapter;

    public function __construct(
        \M2E\Core\Model\Cache\AdapterFactory $adapterFactory
    ) {
        $this->adapterFactory = $adapterFactory;
    }

    // ----------------------------------------

    public function getValue(string $key)
    {
        return $this->getAdapter()->get($key);
    }

    public function setValue(string $key, $value, array $tags = [], $lifetime = null): void
    {
        if ($lifetime === null) {
            $lifetime = 60 * 60;
        }

        $this->getAdapter()->set($key, $value, $lifetime, $tags);
    }

    // ----------------------------------------

    public function removeValue(string $key): void
    {
        $this->getAdapter()->remove($key);
    }

    public function removeTagValues(string $tag): void
    {
        $this->getAdapter()->removeByTag($tag);
    }

    public function removeAllValues(): void
    {
        $this->getAdapter()->removeAllValues();
    }

    public function getAdapter(): \M2E\Core\Model\Cache\Adapter
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (!isset($this->adapter)) {
            $this->adapter = $this->adapterFactory->create(
                \M2E\Multichannel\Helper\Module::IDENTIFIER
            );
        }

        return $this->adapter;
    }
}
