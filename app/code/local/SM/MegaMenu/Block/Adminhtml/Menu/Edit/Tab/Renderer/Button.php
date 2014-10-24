<?php
/**
 * Created by PhpStorm.
 * User: cita-group
 * Date: 10/17/14
 * Time: 8:19 PM
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Edit_Renderer_Button extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface {
    public function render(Varien_Data_Form_Element_Abstract $element) {
        //You can write html for your button here
        $html = '<button></button>';
        return $html;
    }
}