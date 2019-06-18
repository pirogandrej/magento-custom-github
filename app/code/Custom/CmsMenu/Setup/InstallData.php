<?php

namespace Custom\CmsMenu\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Custom\CmsMenu\Model\ResourceModel\Link as LinkResource;

class InstallData implements InstallDataInterface
{
    protected $date;
 
    public function __construct
    (
        DateTime $date
    )
    {
        $this->date = $date;
    }
    
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = [
            [
                'name' => 'blog',
                'path' => 'blog.html',
                'position' => 2,
                'status' => 1,
                'updated_at' => $this->date->date(),
                'created_at' => $this->date->date()
            ],
            [
                'name' => 'home',
                'path' => 'home',
                'position' => 3,
                'status' => 1,
                'updated_at' => $this->date->date(),
                'created_at' => $this->date->date()
            ]
        ];
        
        foreach($data as $item) {
            $setup->getConnection()->insert($setup->getTable(LinkResource::TBL_LINK), $item);
        }
    }
}

