<?php

declare(strict_types=1);

namespace M2E\Multichannel\Model;

class Settings
{
    public const CONFIG_GROUP = '/module/configuration/';
    public const CONFIG_KEY_UNIFY_MODE = 'unify_mode';

    private \M2E\Multichannel\Model\Config\Manager $config;

    public function __construct(\M2E\Multichannel\Model\Config\Manager $config)
    {
        $this->config = $config;
    }

    public function setUnifyMode(int $mode): void
    {
        $this->config->set(self::CONFIG_GROUP, self::CONFIG_KEY_UNIFY_MODE, $mode);
    }

    public function isUnifyModeEnabled(): bool
    {
        return (bool)$this->config->get(self::CONFIG_GROUP, self::CONFIG_KEY_UNIFY_MODE);
    }
}
