<?php
namespace Vendor\Product\Observer;

use \Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Event\Observer as EventObserver;
use Vendor\Product\Ui\DataProvider\Product\Form\Modifier\CustomFieldset;

class ProductSaveAfter implements ObserverInterface
{

    /**
     * @param EventObserver $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getProduct();
        if (!$product) {
            return;
        }

        $exampleTextField = $product->getData(CustomFieldset::FIELD_NAME_TEXT);
        $exampleSelectField = $product->getData(CustomFieldset::FIELD_NAME_SELECT);
        $exampleMultiSelectField = $product->getData(CustomFieldset::FIELD_NAME_MULTISELECT);

        // Manipulate data here
    }
}
?>