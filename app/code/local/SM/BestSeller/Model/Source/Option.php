<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 14/10/14
 * Time: 14:15
 */

class SM_FeaturedProduct_Model_Source_Option extends Mage_Eav_Model_Entity_Attribute_Source_Table
{

    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = array(

                array(
                    'value' => '1',
                    'label' => 'Yes',
                ),
                array(
                    'value' => '0',
                    'label' => 'No',
                )
            );
        }
        return $this->_options;
    }
}