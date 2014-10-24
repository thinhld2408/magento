<?php
/*
* create by user: thinhld.
* unit department: fresher 06.
*/

class SM_ProductLabel_Model_Source_Label extends Mage_Eav_Model_Entity_Attribute_Source_Table
{
//
//    public function getAllOptions(){
//
//        $label = $this->getTypeLabel();
//
//        $options    = array();
//
//        foreach($label as $key => $value){
//            $opt_label = $this->getOptions($key);
//            $preparingArray = array();
//            for($i=0; $i<count($opt_label); $i++){
//                $preparingArray[] = array(
//                    'value'=>  $opt_label[$i]['value'],
//                    'label'=>  $opt_label[$i]['label']
//                );
//            }
//            if($opt_label != null){
//                $options[] = array('label' => $value,
//                    'value' => $preparingArray
//                );
//            }
//
//        }
//
//        return $options;
//    }
//    public function getOptions($keyLabel)
//    {
//        $options= array();
//        $collection = Mage::getSingleton('productlabel/productlabel')->getCollection()
//            ->addFieldToFilter('label_type', array('eq' => $keyLabel))
//            ->getData();
//        foreach ($collection as $key => $value){
//                $options[] = array(
//                    'value' => $value['label_id'],
//                    'label' => $value['label_name']
//                );
//        }
//        return $options;
//    }
////

    public function getAllOptions(){
        $label = $this->getTypeLabel();
        $options=array();
        foreach($label as $key => $value){
            $options[] = array(
                'value' => $key,
                'label' => $value
            );
        }
        return $options;
    }


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