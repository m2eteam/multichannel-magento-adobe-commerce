<?php

declare(strict_types=1);

namespace M2E\Multichannel\Setup\InstallHandler;

class CoreHandler implements \M2E\Core\Model\Setup\InstallHandlerInterface
{
    public function installSchema(\Magento\Framework\Setup\SetupInterface $setup): void
    {
        return;
    }

    public function installData(\Magento\Framework\Setup\SetupInterface $setup): void
    {
        return;
    }
}
