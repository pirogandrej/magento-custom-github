<?php

namespace Custom\CategoryImageUpload\Block;

use Magento\Catalog\Block\Category\View;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Registry;
use Magento\Catalog\Helper\Category;
use Custom\CategoryImageUpload\Helper\Data as CustomHelper;

class Image extends View
{
    protected $_coreRegistry = null;

    protected $_catalogLayer;

    protected $_categoryHelper;

    protected $_helper;

    public function __construct(
        CustomHelper $helper,
        Context $context,
        Resolver $layerResolver,
        Registry $registry,
        Category $categoryHelper,
        array $data = []
    ) {
        $this->_helper = $helper;
        $this->_categoryHelper = $categoryHelper;
        $this->_catalogLayer = $layerResolver->get();
        $this->_coreRegistry = $registry;
        parent::__construct($context, $layerResolver, $registry, $categoryHelper, $data);
    }

    public function getImageUrl()
    {
        $imageCode = $this->hasImageCode() ? $this->getImageCode() : 'image';

        $imageName = $this->getCurrentCategory()->getData($imageCode);

        $url = $this->_helper->getImageUrl($imageName);

        return $url;
    }

    public function getCategoryName()
    {
        $categoryName = $this->getCurrentCategory()->getName();

        return $categoryName;
    }
}
