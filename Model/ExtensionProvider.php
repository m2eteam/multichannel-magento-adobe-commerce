<?php

declare(strict_types=1);

namespace M2E\Multichannel\Model;

class ExtensionProvider
{
    private const EXTENSION_TEMPLATES = [
        'Ess_M2ePro_Ebay' => 'M2E_Multichannel::dashboard/tabs/ebay_tab_content.phtml',
        'Ess_M2ePro_Amazon' => 'M2E_Multichannel::dashboard/tabs/amazon_tab_content.phtml',
        'Ess_M2ePro_Walmart' => 'M2E_Multichannel::dashboard/tabs/walmart_tab_content.phtml',
        'M2E_OnBuy_OnBuy' => 'M2E_Multichannel::dashboard/tabs/onbuy_tab_content.phtml',
        'M2E_TikTokShop_TikTokShop' => 'M2E_Multichannel::dashboard/tabs/tiktok_tab_content.phtml',
        'M2E_Kaufland_Kaufland' => 'M2E_Multichannel::dashboard/tabs/kaufland_tab_content.phtml',
        'M2E_Otto_Otto' => 'M2E_Multichannel::dashboard/tabs/otto_tab_content.phtml',
    ];

    private const EXTENSION_ICONS = [
        'Ess_M2ePro_Ebay' => 'M2E_Multichannel::images/logo-multi-channels.svg',
        'Ess_M2ePro_Amazon' => 'M2E_Multichannel::images/logo-multi-channels.svg',
        'Ess_M2ePro_Walmart' => 'M2E_Multichannel::images/logo-multi-channels.svg',
        'M2E_OnBuy_OnBuy' => 'M2E_Multichannel::images/logo-onbuy.svg',
        'M2E_TikTokShop_TikTokShop' => 'M2E_Multichannel::images/logo-tts.svg',
        'M2E_Kaufland_Kaufland' => 'M2E_Multichannel::images/logo-kaufland.svg',
        'M2E_Otto_Otto' => 'M2E_Multichannel::images/logo-otto.svg',
    ];

    private const EXTENSION_TEMPLATE_DEFAULT = 'M2E_Multichannel::dashboard/tabs/tab_content.phtml';

    /** @var \M2E\Multichannel\Model\Extension[] */
    private array $extensions;
    private \M2E\Multichannel\Model\Extension\SourceProvider $sourceProvider;
    private \Magento\Framework\Module\Manager $moduleManager;
    private \Magento\Framework\View\Asset\Repository $assetRepository;

    public function __construct(
        \M2E\Multichannel\Model\Extension\SourceProvider $sourceProvider,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Framework\View\Asset\Repository $assetRepository
    ) {
        $this->moduleManager = $moduleManager;
        $this->sourceProvider = $sourceProvider;
        $this->assetRepository = $assetRepository;
    }

    public function getAll(): array
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (!isset($this->extensions)) {
            $this->extensions = [];
            foreach ($this->sourceProvider->get() as $source) {
                $this->extensions[] = new \M2E\Multichannel\Model\Extension(
                    $source->getId(),
                    $source->getModuleName(),
                    $source->getModuleLabel(),
                    $source->getTitle(),
                    $this->moduleManager->isEnabled($source->getModuleName()),
                    self::EXTENSION_TEMPLATES[$source->getId()] ?? self::EXTENSION_TEMPLATE_DEFAULT,
                    $this->createMetadata($source->getMetadata()),
                    $source->getDescription(),
                    $this->getIcon($source)
                );
            }
        }

        return $this->extensions;
    }

    private function createMetadata(
        \M2E\Multichannel\Model\Extension\Source\Metadata $sourceMetadata
    ): ExtensionMetadata {
        return new ExtensionMetadata(
            $sourceMetadata->getDocsUrl(),
            $sourceMetadata->getSupportUrl(),
            $sourceMetadata->getMarketplaceUrl(),
            $sourceMetadata->getDocInstallUrl(),
        );
    }

    private function getIcon(Extension\Source $source): ?string
    {
        $icon = $source->getIcon();
        if (!$icon && isset(self::EXTENSION_ICONS[$source->getId()])) {
            $icon = $this->assetRepository->getUrl(self::EXTENSION_ICONS[$source->getId()]);
        }

        return $icon;
    }
}
