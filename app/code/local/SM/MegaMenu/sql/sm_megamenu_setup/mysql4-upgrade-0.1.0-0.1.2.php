<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 12/10/14
 * Time: 15:21
 */


$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer->startSetup();


$table = $installer->getConnection()
    ->newTable($installer->getTable('sm_megamenu/item'))
    ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Slider Item ID')
    ->addColumn('item_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Item name')
    ->addColumn('item_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Item Title')
    ->addColumn('item_picture', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Item Picture')
    ->addColumn('item_url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
    ), 'Item Url')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
    ), 'Item Position')
    ->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Item Creation Time')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Item Modification Time')
    ->addColumn('slider_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
    ), 'slider id')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
    ), 'Is Item Active')

    ->addIndex($installer->getIdxName('sm_slider/item', array('item_id')),
        array('item_id'))
    ->addForeignKey($installer->getFkName('sm_slider/item', 'slider_id', 'sm_slider/slider', 'slider_id'),
        'slider_id', $installer->getTable('sm_slider/slider'), 'slider_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Slider Items Table');
$installer->getConnection()->createTable($table);


?>