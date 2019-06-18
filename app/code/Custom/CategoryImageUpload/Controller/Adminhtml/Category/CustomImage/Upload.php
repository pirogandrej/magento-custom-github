<?php

namespace Custom\CategoryImageUpload\Controller\Adminhtml\Category\CustomImage;

use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Controller\Adminhtml\Category\Image\Upload as ImageUpload;
use Custom\CategoryImageUpload\Helper\Data as CustomHelper;

class Upload extends ImageUpload
{
    public function execute()
    {
        try {
            $result = $this->imageUploader->saveFileToTmpDir(CustomHelper::CUSTOM_ATTRIBUTE);

            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
