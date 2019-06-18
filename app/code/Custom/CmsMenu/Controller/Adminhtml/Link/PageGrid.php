<?php

namespace Custom\CmsMenu\Controller\Adminhtml\Link;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory;

class PageGrid extends Action
{

    protected $_resultLayoutFactory;

    public function __construct(
        Context $context,
        LayoutFactory $resultLayoutFactory
    ) {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }

    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();

        $resultLayout->getLayout()->getBlock('adminhtml_link_edit_tab_page')->toHtml();

        return $resultLayout;
    }
}
