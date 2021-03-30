<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DphInteg\CustomCheckoutFields\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Add the new column
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $this->addBarangayColumn($setup);

        $installer->endSetup();
    }

    /**
     * Add the column named delivery_date
     *
     * @param SchemaSetupInterface $setup
     *
     * @return void
     */
    private function addBarangayColumn(SchemaSetupInterface $setup)
    {
        $barangay = [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'default' => NULL,
            'nullable' => true,
            'comment' => 'Barangay'
        ];

        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order_address'),
            'barangay',
            $barangay
        );

        $setup->getConnection()->addColumn(
            $setup->getTable('quote_address'),
            'barangay',
            $barangay
        );
    }
}