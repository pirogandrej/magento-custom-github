<?php

namespace Custom\LoginAsCustomer\Ui\Component\DataProvider;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document as DataProviderDocument;
use Custom\LoginAsCustomer\Helper\Data;

class Document extends DataProviderDocument
{
    private static $loginFromAttributeCode = 'login_from';

    private $helper;

    public function __construct(
        AttributeValueFactory $attributeValueFactory,
        Data $data
    ) {
        parent::__construct($attributeValueFactory);
        $this->helper = $data;
    }

    public function getCustomAttribute($attributeCode)
    {
        switch ($attributeCode) {
            case self::$loginFromAttributeCode:
                $this->setLoginFromValue();
                break;
        }
        return parent::getCustomAttribute($attributeCode);
    }

    private function setLoginFromValue()
    {
        $value = $this->getData(self::$loginFromAttributeCode);

        if (!$value) {
            $this->setCustomAttribute(self::$loginFromAttributeCode, '');
            return;
        }

        try {
            $valueText = $this->helper->loginOptionsForListing()[$value];
            $this->setCustomAttribute(self::$loginFromAttributeCode, $valueText);
        } catch (NoSuchEntityException $e) {
            $this->setCustomAttribute(self::$loginFromAttributeCode, '');
        }
    }
}
