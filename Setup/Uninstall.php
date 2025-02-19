<?php

declare(strict_types=1);

namespace M2E\Multichannel\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class Uninstall implements \Magento\Framework\Setup\UninstallInterface
{
    private \M2E\Multichannel\Model\VariablesDir $variablesDir;
    private MagentoCoreConfigSettings $magentoCoreConfigSettings;
    private InstallTablesListResolver $installTablesListResolver;
    private \M2E\Multichannel\Model\Config\Manager $configManager;
    private \M2E\Core\Model\Setup\UninstallFactory $uninstallFactory;

    public function __construct(
        InstallTablesListResolver $installTablesListResolver,
        MagentoCoreConfigSettings $magentoCoreConfigSettings,
        \M2E\Multichannel\Model\Config\Manager $configManager,
        \M2E\Multichannel\Model\VariablesDir $variablesDir,
        \M2E\Core\Model\Setup\UninstallFactory $uninstallFactory
    ) {
        $this->variablesDir = $variablesDir;
        $this->configManager = $configManager;
        $this->magentoCoreConfigSettings = $magentoCoreConfigSettings;
        $this->installTablesListResolver = $installTablesListResolver;
        $this->uninstallFactory = $uninstallFactory;
    }

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        $this->uninstallFactory
            ->create(
                \M2E\Multichannel\Helper\Module::IDENTIFIER,
                $this->installTablesListResolver,
                $this->configManager->getAdapter(),
                $this->variablesDir->getAdapter(),
                $this->magentoCoreConfigSettings,
                $setup,
            )
            ->process();
    }
}
