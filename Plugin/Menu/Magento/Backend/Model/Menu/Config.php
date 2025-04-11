<?php

declare(strict_types=1);

namespace M2E\Multichannel\Plugin\Menu\Magento\Backend\Model\Menu;

class Config
{
    private \Magento\Backend\Model\Menu\Item\Factory $itemFactory;
    private bool $isProcessed = false;
    private \M2E\Multichannel\Model\ExtensionProvider $extensionProvider;

    public function __construct(
        \M2E\Multichannel\Model\ExtensionProvider $extensionProvider,
        \Magento\Backend\Model\Menu\Item\Factory $itemFactory
    ) {
        $this->itemFactory = $itemFactory;
        $this->extensionProvider = $extensionProvider;
    }

    public function afterGetMenu(\Magento\Backend\Model\Menu\Config $interceptor, \Magento\Backend\Model\Menu $result)
    {
        if ($this->isProcessed) {
            return $result;
        }

        $this->isProcessed = true;

        /** @var \M2E\Multichannel\Model\Extension $item */
        foreach ($this->extensionProvider->getAll() as $item) {
            $menuItem = $this->itemFactory->create([
                'id' => \M2E\Multichannel\Helper\Module::IDENTIFIER . '::' . $item->getId(),
                'module' => \M2E\Multichannel\Helper\Module::IDENTIFIER,
                'title' => $item->getModuleLabel(),
                'parent_id' => 'M2E_Multichannel::integrations',
                'resource' => 'M2E_Multichannel::integrations',
                'action' => 'm2e_multichannel/dashboard/index/tab/' . $item->getId(),
            ]);

            $result->add($menuItem, 'M2E_Multichannel::integrations');
        }

        return $result;
    }
}
