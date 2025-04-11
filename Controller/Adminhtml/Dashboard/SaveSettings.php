<?php

declare(strict_types=1);

namespace M2E\Multichannel\Controller\Adminhtml\Dashboard;

class SaveSettings extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    private \M2E\Multichannel\Model\Settings $settings;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \M2E\Multichannel\Model\Settings $settings
    ) {
        $this->settings = $settings;

        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $unifyMode = $this->getRequest()->getParam('unify_mode') ? 1 : 0;
            $this->settings->setUnifyMode($unifyMode);
            $this->messageManager->addSuccessMessage($this->getSuccessMessage($unifyMode));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('An error occurred while updating the feature.'));
        }

        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('M2E_Multichannel::config');
    }

    private function getSuccessMessage(int $unifyMode): \Magento\Framework\Phrase
    {
        return $unifyMode ?
            __(
                'Unify Integrations has been enabled. You installed M2E ' .
                'module integrations can now be accessed from a single M2E Multichannel Connect menu section.'
            )
            : __('Unify Integrations has been disabled');
    }
}
