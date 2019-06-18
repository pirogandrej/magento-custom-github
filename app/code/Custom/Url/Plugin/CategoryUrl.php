<?php

namespace Custom\Url\Plugin;

use Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator;

class CategoryUrl
{
    const CATALOG = 'shop/category/';

    public function afterGetUrlPath(CategoryUrlPathGenerator $subject, $result, $category)
    {
        if (!empty($result)) {
            if ( strpos($result,self::CATALOG) === false) {
                $result = self::CATALOG . $result;
            }
        }
        return $result;
    }
}


