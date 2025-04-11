<?php

declare(strict_types=1);

namespace M2E\Multichannel\Block\Adminhtml\Dashboard;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected $_template = 'M2E_Multichannel::dashboard/tabs.phtml';

    private \M2E\Multichannel\Model\ExtensionProvider $extensionProvider;
    private \Magento\Framework\App\RequestInterface $request;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Backend\Model\Auth\Session $authSession,
        \M2E\Multichannel\Model\ExtensionProvider $extensionProvider,
        \Magento\Framework\App\RequestInterface $request,
        array $data = []
    ) {
        $this->extensionProvider = $extensionProvider;
        $this->request = $request;

        parent::__construct($context, $jsonEncoder, $authSession, $data);
    }

    protected function _construct()
    {
        parent::_construct();

        $this->setId('m2e_multichannel_tab_container');
        $this->setDestElementId('m2e_multichannel_tabs_container');
        $this->setTitle(__('Extensions'));
    }

    protected function _prepareLayout()
    {
        /** @var \M2E\Multichannel\Model\Extension $extension */
        foreach ($this->extensionProvider->getAll() as $extension) {
            $this->addTab(
                $extension->getId(),
                $this->getTabParams($extension)
            );
        }
        if ($this->request->getParam('tab')) {
            $this->setActiveTab($this->request->getParam('tab'));
        }

        return parent::_prepareLayout();
    }

    private function getTabParams(\M2E\Multichannel\Model\Extension $extension): array
    {
        $cssClass = $extension->isEnabled() ? 'installed ' . $extension->getId() : $extension->getId();

        return [
            'label' => $extension->getModuleLabel(),
            'class' => $cssClass,
            'icon' => $extension->getIcon(),
            'content' => $this->createExtensionBlock($extension)
        ];
    }

    private function createExtensionBlock(\M2E\Multichannel\Model\Extension $extension): string
    {
        return $this->getLayout()
                    ->createBlock(
                        \M2E\Multichannel\Block\Adminhtml\Dashboard\Tabs\TabContent::class,
                        '',
                        ['extension' => $extension, 'template' => $extension->getTemplate()]
                    )
                    ->toHtml();
    }
}
