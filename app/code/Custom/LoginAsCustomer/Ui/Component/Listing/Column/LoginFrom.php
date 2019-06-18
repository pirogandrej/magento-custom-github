<?php

namespace Custom\LoginAsCustomer\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Custom\LoginAsCustomer\Helper\Data;

class LoginFrom extends Column
{
    protected $helper;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Data $helper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->helper = $helper;
    }

    public function prepareDataSource(array $dataSource)
    {
        /* This section for create login text using foreach loop*/
        if (isset($dataSource['data']['items'])) {
            $i = 0;
            /*Get all login from options array from helper class*/
            $loginFromData = $this->helper->loginOptionsForListing();
            foreach ($dataSource['data']['items'] as &$item) {
                $currentIndex = $item['login_from'];
                $item['login_from'] = $loginFromData[$currentIndex];
            }
        }
        return $dataSource;
    }

    protected function _getData($key)
    {
        if ($key == 'config') {
                $data = parent::_getData($key);
                $data['componentDisabled'] = false;
                return $data;
        }
        return parent::_getData($key);
    }
}
