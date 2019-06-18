<?php

namespace Custom\LoginAsCustomer\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table_custom_login_as_customer = $setup->getConnection()->newTable(
            $setup->getTable(
                'custom_login_as_customer'
            )
        );

        $table_custom_login_as_customer->addColumn(
            'entity_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,],
            'Entity ID'
        );

        $table_custom_login_as_customer->addColumn(
            'customer_id',
            Table::TYPE_INTEGER,
            null,
            [],
            'customer_id'
        );

        $table_custom_login_as_customer->addColumn(
            'customer_email',
            Table::TYPE_TEXT,
            255,
            [],
            'customer_email'
        );

        $table_custom_login_as_customer->addColumn(
            'admin_username',
            Table::TYPE_TEXT,
            255,
            [],
            'admin_username'
        );

        $table_custom_login_as_customer->addColumn(
            'admin_id',
            Table::TYPE_INTEGER,
            null,
            [],
            'admin_id'
        );

        $table_custom_login_as_customer->addColumn(
            'admin_name',
            Table::TYPE_TEXT,
            255,
            [],
            'admin_name'
        );

        $table_custom_login_as_customer->addColumn(
            'login_from',
            Table::TYPE_SMALLINT,
            null,
            [],
            'login_from'
        );

        $table_custom_login_as_customer->addColumn(
            'secret',
            Table::TYPE_TEXT,
            255,
            [],
            'secret'
        );

        $table_custom_login_as_customer->addColumn(
            'used',
            Table::TYPE_SMALLINT,
            null,
            ['default' => '0'],
            'used'
        );

        $table_custom_login_as_customer->addColumn(
            'ip',
            Table::TYPE_TEXT,
            255,
            [],
            'ip'
        );

        $table_custom_login_as_customer->addColumn(
            'logged_at',
            Table::TYPE_TIMESTAMP,
            null,
            [],
            'logged_at'
        );

        $table_custom_login_as_customer->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [],
            'updated_at'
        );

        $setup->getConnection()->createTable($table_custom_login_as_customer);

        $setup->endSetup();
    }
}
