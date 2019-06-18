<?php

namespace Custom\Url\Plugin;

use Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator;

class ProductUrl
{
    const PRODUCT = 'shop/';

    public function afterGetUrlPath(ProductUrlPathGenerator $subject, $result, $product, $category = null)
    {
        $productUrl = $result;
        if (!empty($productUrl)) {
            if ( strpos($productUrl,self::PRODUCT) === false) {
                $productUrl = self::PRODUCT . $productUrl;
            }
        }
        return $productUrl;
    }
}


