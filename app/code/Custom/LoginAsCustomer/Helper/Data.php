<?php

namespace Custom\LoginAsCustomer\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function loginOptionsForFilter()
    {
        $finalArray = [
            ['value' => 1, 'label' => __('Customer Grid')],
            ['value' => 2, 'label' => __('Customer Edit')],
            ['value' => 3, 'label' => __('Order View')],
            ['value' => 4, 'label' => __('Order Grid')],
        ];
        return $finalArray;
    }

    public function loginOptionsForListing()
    {
        $returnArrayList = [
            "1" => "Customer Grid",
            "2" => "Customer Edit",
            "3" => "Order View",
            "4" => "Order Grid",
        ];
        return $returnArrayList;
    }
}
