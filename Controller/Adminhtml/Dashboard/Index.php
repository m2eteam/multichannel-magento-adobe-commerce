<?php

declare(strict_types=1);

namespace M2E\Multichannel\Controller\Adminhtml\Dashboard;

class Index extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    private \Magento\Framework\View\Result\PageFactory $resultPageFactory;

    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $result = $this->resultPageFactory->create();
        $result->getConfig()
               ->getTitle()
               ->set(__('Dashboard'));

        return $result;
    }
}
