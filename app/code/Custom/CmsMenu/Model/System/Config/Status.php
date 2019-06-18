<?php

namespace Custom\CmsMenu\Model\System\Config;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    const ENABLED  = 1;
    const DISABLED = 0;

    public function toOptionArray()
    {
        $options = [
            self::DISABLED => __('Disabled'),
            self::ENABLED => __('Enabled')
        ];

        return $options;
    }
}