<?php

/**
 * MenuManager menu item collection
 *
 * @package     sm_slider
 */
class SM_Slider_Model_Resource_Item_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('sm_slider/item');
    }

    /**
     * Add menu filter to item collection
     *
     * @param   int | SM_Slider_Model_Slider $slider
     * @return  SM_Slider_Model_Resource_Item_Collection
     */
    public function addSliderFilter($slider)
    {
        if ($slider instanceof SM_Slider_Model_Slider) {
            $slider = $slider->getId();
        }

        $this->addFilter('slider_id', $slider);

        return $this;
    }

    /**
     * Add status filter to item collection
     *
     * @return  sm_slider_Model_Resource_Item_Collection
     */
    public function addStatusFilter()
    {
        $this->addFilter('is_active', 1);

        return $this;
    }

    /**
     * Set order to item collection
     *
     * @return SM_Slider_Model_Resource_Item_Collection
     */
    public function setPositionOrder()
    {

        $this->setOrder('position', 'asc');

        return $this;
    }



}