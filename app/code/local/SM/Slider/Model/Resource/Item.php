<?php



/**
 * MenuManager menu item model
 *
 * @category    Thinhld
 * @package     sm_slider
 */
class SM_Slider_Model_Resource_Item extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('sm_slider/item', 'item_id');
    }

    /**
     * Load an object using 'identifier' field
     *
     * @param   Mage_Core_Model_Abstract    $object
     * @param   mixed                       $value
     * @param   string                      $field
     * @return  SM_Slider_Model_Resource_Item
     */
    public function load(Mage_Core_Model_Abstract $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'item_id';
        }

        return parent::load($object, $value, $field);
    }


    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {

        Mage::app()->cleanCache(SM_Slider_Model_Slider::CACHE_TAG);

        return $this;
    }
}
