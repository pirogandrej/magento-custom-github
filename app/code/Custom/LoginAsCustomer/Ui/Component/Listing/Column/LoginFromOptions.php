<?php

namespace Custom\LoginAsCustomer\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;
use Custom\LoginAsCustomer\Helper\Data;

class LoginFromOptions implements OptionSourceInterface
{
    protected $helper;

    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    public function toOptionArray()
    {
        /*Get Login Option Array Using Helper */
        return $this->helper->loginOptionsForFilter();
    }
}
