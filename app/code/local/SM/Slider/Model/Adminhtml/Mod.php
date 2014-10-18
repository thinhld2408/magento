<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 13/10/14
 * Time: 16:29
 */
Class SM_Slider_Model_Adminhtml_Mod extends Mage_Core_Model_Abstract{

    public function toOptionArray(){

            $options[] = array(
                'value' => 'vertical',
                'label' => 'Vertical',
            );
        $options[] = array(
            'value' => 'horizontal',
                'label' => 'Horizontal',
            );

        return $options;
    }
}