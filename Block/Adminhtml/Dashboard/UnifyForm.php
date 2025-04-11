<?php

namespace M2E\Multichannel\Block\Adminhtml\Dashboard;

class UnifyForm extends \Magento\Backend\Block\Template
{
    private \M2E\Multichannel\Model\Settings $settings;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \M2E\Multichannel\Model\Settings $settings,
        array $data = []
    ) {
        $this->settings = $settings;

        parent::__construct($context, $data);
    }

    public function isUnifyModeEnabled(): bool
    {
        return $this->settings->isUnifyModeEnabled();
    }
}
