<?php

namespace Custom\CmsMenu\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;
use Custom\CmsMenu\Model\ResourceModel\Link as LinkResource;

class InstallSchema implements InstallSchemaInterface
{
    public function install
    (
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $installer = $setup;
        $installer->startSetup();

        $tableName = $installer->getTable(LinkResource::TBL_LINK);

        if ($installer->getConnection()->isTableExists($tableName) != true) {

            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'link_id',
                    Table::TYPE_SMALLINT,
                    6,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => false,
                        'default' => ''
                    ],
                    'Name'
                )
                ->addColumn(
                    'path',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => false,
                        'default' => ''
                    ],
                    'Path'
                )
                ->addColumn(
                    'position',
                    Table::TYPE_INTEGER,
                    10,
                    [
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Position'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_BOOLEAN,
                    null,
                    [
                        'nullable' => false,
                        'default' => '1'
                    ],
                    'Status'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_DATETIME,
                    null,
                    [
                        'nullable' => false
                    ],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable' => false
                    ],
                    'Updated At'
                )
                ->setComment('CmsMenu Table')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists(LinkResource::TBL_LINK_PAGE)) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable(LinkResource::TBL_LINK_PAGE))
                ->addColumn(
                    'link_id',
                    Table::TYPE_SMALLINT,
                    6,
                    [
                        'nullable' => false,
                    ]
                )
                ->addColumn(
                    'page_id',
                    Table::TYPE_SMALLINT,
                    6,
                    [
                        'nullable' => false,
                    ],
                    'Magento Page Id'
                )
                ->addForeignKey(
                    $installer->getFkName(
                        LinkResource::TBL_LINK_PAGE,
                        'page_id',
                        LinkResource::TBL_PAGE,
                        'page_id'
                    ),
                    'page_id',
                    $installer->getTable(LinkResource::TBL_PAGE),
                    'page_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        LinkResource::TBL_LINK_PAGE,
                        'link_id',
                        LinkResource::TBL_LINK,
                        'link_id'
                    ),
                    'link_id',
                    $installer->getTable(LinkResource::TBL_LINK),
                    'link_id',
                    Table::ACTION_CASCADE
                )

                ->setComment('Link Page Attachment relation table');

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}

