<?php

declare(strict_types=1);

namespace M2E\Multichannel\Block\Adminhtml;

class Menu extends \Magento\Backend\Block\Template
{
    protected $_template = 'M2E_Multichannel::menu.phtml';

    private \M2E\Multichannel\Model\ExtensionProvider $extensionProvider;
    /** @var string[] */
    private $menuIds = [];
    private \M2E\Multichannel\Model\Settings $settings;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \M2E\Multichannel\Model\ExtensionProvider $extensionProvider,
        \M2E\Multichannel\Model\Settings $settings,
        array $data = []
    ) {
        $this->extensionProvider = $extensionProvider;
        $this->settings = $settings;

        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        foreach ($this->extensionProvider->getAll() as $extension) {
            $this->menuIds['#' . $extension->getMenuCssId()] = $this->getContainerSelector($extension->getId());
        }

        return parent::_prepareLayout();
    }

    public function isUnifyModeEnabled(): bool
    {
        return $this->settings->isUnifyModeEnabled();
    }

    public function getMenuIdsForHide(): string
    {
        $result = [];
        foreach (array_keys($this->menuIds) as $menuId) {
            $result[] = '#nav > ' . $menuId;
        }

        return implode(',', $result);
    }

    public function getJsonConfig(): string
    {
        $config = [];
        foreach ($this->menuIds as $id => $containerSelector) {
            $config[] = [
                'itemId' => $id,
                'containerSelector' => $containerSelector,
            ];
        }

        return json_encode($config);
    }

    private function getContainerSelector(string $id): string
    {
        return '.' . trim(preg_replace('/[^a-z0-9]+/', '-', strtolower('item-' . $id)), '-');
    }
}
