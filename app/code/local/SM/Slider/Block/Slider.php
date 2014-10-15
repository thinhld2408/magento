<?php
class SM_Slider_Block_Slider extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{

    protected $_serializer = null;

    /**
     * Initialization
     */
    protected function _construct()
    {
        $this->_serializer = new Varien_Object();
        parent::_construct();
    }

    /**
     * Produce links list rendered as html
     *
     * @return string
     */
    protected function _toHtml()
    {
        return parent::_toHtml();
    }

    public function getSliderShow()
    {
        $data = array();
        if (Mage::getStoreConfig('slider/config/enabled') == 1) {
            $sliderId = Mage::getStoreConfig('slider/config/slider');
            $slider = $this->getSlider($sliderId);
            if ($slider != false) {
                $slideItem = $this->getSliderItem($sliderId);
                $data['slider'] = array(
                    'mode' => $slider['mode'],
                    'width' => $slider['width'],
                    'height' => $slider['height']
                );
                foreach ($slideItem as $value) {
                    $data['item'][] = array(
                        'name' => $value->getItem_name(),
                        'title' => $value->getItem_title(),
                        'image' => $value->getItem_picture()
                    );
                }
            }

        }
        return $data;
    }

    public function getSlider($id)
    {
        $slider = Mage::getModel('sm_slider/slider')->load($id)->getData();
        $isActive = $slider['status'];

        if ($isActive == 1) {
            return $slider;
        }
        return false;
    }

    public function getSliderItem($id)
    {
        $sliderItem = Mage::getModel('sm_slider/item')->getCollection()
            ->setPositionOrder()
            ->addFieldToFilter('slider_id', array('eq' => $id))
            ->addFieldToFilter('is_active', array('eq' => 1));
        return $sliderItem;
    }

}

?>