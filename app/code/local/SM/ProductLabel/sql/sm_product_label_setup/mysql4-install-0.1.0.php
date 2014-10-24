<?php
/*
* Create by PhpStorm.
* User: thinh_ld.
* Unit Department: Fresher06.
*/
$installer  = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('productlabel/productlabel'))
    ->addColumn('label_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Label Item ID')
    ->addColumn('label_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Label name')
    ->addColumn('label_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Item Title')
    ->addColumn('label_logo', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Label Picture')
    ->addColumn('label_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        'default'   => 'new_label',
    ), 'Label Type')
    ->addColumn('creation_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Label Creation Time')
    ->addColumn('update_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
    ), 'Label Modification Time')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
    ), 'Is Label Active')

    ->addIndex($installer->getIdxName('productlabel/productlabel', array('label_id')),
        array('label_id'))

    ->setComment('Label Product Table');
$installer->getConnection()->createTable($table);

 