<?php


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'slider/slider_store'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('slider/slider_store'))
    ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
    ), 'Slide ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Store ID')
    ->addIndex($installer->getIdxName('slider/slider_store', array('store_id')),
        array('store_id'))
    ->addForeignKey($installer->getFkName('slider/slideshow_store', 'slide_id', 'slideshow/slideshow', 'slide_id'),
        'slide_id', $installer->getTable('slideshow/slideshow'), 'slide_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('slideshow/slideshow_store', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Slide To Store Linkage Table');
$installer->getConnection()->createTable($table);

/**
 * Assign 'all store views' to existing slides
 */
$installer->endSetup();