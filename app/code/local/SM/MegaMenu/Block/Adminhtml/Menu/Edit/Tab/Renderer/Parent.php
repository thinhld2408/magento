<?php

/**
 * MenuManager menu item parent title renderer
 *
 * @package     sm_megamenu
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Edit_Tab_Renderer_Parent
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Returns item title by id or 'Root' if no parent specified
     *
     * @param Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        if ($value = $row->getData($this->getColumn()->getIndex())) {
            return Mage::getModel('sm_megamenu/item')->load($value)->getTitle();
        }

        return Mage::helper('sm_megamenu')->__('Root');
    }
}