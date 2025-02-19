<?php

declare(strict_types=1);

namespace M2E\Multichannel\Block\Adminhtml\Dashboard\Tabs;

class TabContent extends \Magento\Backend\Block\Template
{
    private \M2E\Multichannel\Model\Extension $extension;
    private string $template;

    public function __construct(
        \M2E\Multichannel\Model\Extension $extension,
        string $template,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->extension = $extension;
        $this->template = $template;
        parent::__construct($context, $data);
    }

    protected function _construct(): void
    {
        parent::_construct();
        $this->setTemplate($this->template);
    }

    public function getExtension(): \M2E\Multichannel\Model\Extension
    {
        return $this->extension;
    }
}
