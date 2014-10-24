<?php
/*
* create by user: quynh.
* unit department: fresher 06.
*/
class SM_ProductLabel_Model_Source_Label_Type extends Mage_Core_Model_Abstract
{
//    public function toOptionArray(){
//        $collection = Mage::getSingleton('productlabel/productlabel')->getCollection()->getData();
//        $options    = array();
//        foreach($collection as $key => $value){
//            $options[] = array(
//                'value' => $value['label_id'],
//                'label' => $value['group_name'],
//            );
//        }
//        return $options;
//    }

      public function getTypeLabel(){

          $options = array(
              "sale_label" => Mage::helper('productlabel')->__('Sale Label'),
              "hot_label" => Mage::helper('productlabel')->__('Hot Label'),
              "featured_label" => Mage::helper('productlabel')->__('Featured Label'),
              "new_label" => Mage::helper('productlabel')->__('New Label'),

          );
          return $options;

      }
}