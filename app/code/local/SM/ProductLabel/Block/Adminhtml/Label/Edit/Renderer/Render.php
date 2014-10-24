<?php

/**
 * MenuManager menu item parent title renderer
 *
 * @package     sm_slider
 */
class SM_ProductLabel_Block_Adminhtml_Label_Edit_Renderer_Render
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
        public function render(Varien_Object $image){
             $link = $image->getData($this->getColumn()->getIndex());
             $urlImage = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).''.$link;

             $html = '<img src="'.$urlImage.' " width="100px" height="80px" />';

            return $html;
        }
}