<?php

namespace Custom\CategoryImageUpload\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\UrlInterface;
use Magento\Framework\Exception\LocalizedException;

class Data extends AbstractHelper
{
    const CUSTOM_ATTRIBUTE = 'custom_image';

    public function getAdditionalImageTypes()
    {
        return array(self::CUSTOM_ATTRIBUTE);
    }

    public function getImageUrl($imageName)
    {
        $url = false;
        if ($imageName) {
            if (is_string($imageName)) {
                $url = $this->_urlBuilder->getBaseUrl(
                        ['_type' => UrlInterface::URL_TYPE_MEDIA]
                    ) . 'catalog/category/' . $imageName;
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
}