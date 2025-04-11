<?php

declare(strict_types=1);

namespace M2E\Multichannel\Helper\Module;

class Maintenance implements \M2E\Core\Model\Module\MaintenanceInterface
{
    public function enable(): void
    {
    }

    public function isEnabled(): bool
    {
        return false;
    }

    public function enableDueLowMagentoVersion(): void
    {
    }

    public function isEnabledDueLowMagentoVersion(): bool
    {
        return false;
    }

    public function disable(): void
    {
    }
}
