<?php
/**
 * Created by PhpStorm.
 * User: cita-group
 * Date: 10/24/14
 * Time: 10:20 AM
 */

Class SM_ProductLabel_Model_Source_Label_Featured {

    public function toOptionArray(){
        $options= array();
        $collection = Mage::getSingleton('productlabel/productlabel')->getCollection()
            ->addFieldToFilter('label_type', array('eq' => 'featured_label'))
            ->getData();
        foreach ($collection as $key => $value){
                $options[] = array(
                  'value' => $value['label_id'],
                  'label' => $value['label_name']
                );

        }
        return $options;


    }
}