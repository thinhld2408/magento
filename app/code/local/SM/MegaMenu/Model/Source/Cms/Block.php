<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 09/10/14
 * Time: 04:07
 */
class SM_MegaMenu_Model_Source_Cms_Block
{
    protected $_options;

    public function getAllBlock()
    {
        if(!$this->_options){
            $this->_options = Mage::getResourceModel('cms/block_collection')
                ;
        }
        $option = array();
        foreach($this->_options as $value){
            $option[]=array(
                    'value' => $value->getIdentifier(),
                    'label' =>  $value->getTitle(),
            );
        }

        return $option;
    }
}
