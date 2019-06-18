<?php

namespace Custom\HidePrice\Plugin\Block\Product;

use Magento\Framework\UrlInterface;
use Magento\CatalogWidget\Block\Product\ProductsList as ProductsListBlock;
use Magento\Catalog\Model\Product;
use Magento\Framework\Pricing\Render;
use Custom\HidePrice\Helper\Data as CustomHelper;

class ProductsList
{
    protected $_helper;

    protected $urlBuilder;

    public function __construct
    (
        CustomHelper $helper,
        UrlInterface $urlBuilder
    )
    {
        $this->_helper = $helper;
        $this->urlBuilder = $urlBuilder;
    }

    public function afterGetProductPriceHtml
    (
        ProductsListBlock $subject,
        $result,
        Product $product,
        $priceType = null,
        $renderZone = Render::ZONE_ITEM_LIST,
        array $arguments = []
    ) {
        if ($this->_helper->isHide()) {
            $urlLogin = $this->urlBuilder->getUrl('customer/account/login');
            $loginButton = '<a class="action tocart primary custom-category" href="' . $urlLogin . '">login to see price</a>';
            return $loginButton;
        }
        return $result;
    }
}
