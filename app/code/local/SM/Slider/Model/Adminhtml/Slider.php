<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 13/10/14
 * Time: 16:29
 */
Class SM_Slider_Model_Adminhtml_Slider extends Mage_Core_Model_Abstract{

    public function toOptionArray(){
        $collection = Mage::getSingleton('sm_slider/slider')->getCollection()->getData();
           $options = array();
        foreach($collection as $key => $value){
            $options[] = array(
                'value' => $value['slider_id'],
                'label' => $value['name'],
            );
        }
        return $options;
    }
}