<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 15/10/14
 * Time: 04:21
 */

Class SM_Slider_Block_Widget extends Mage_Core_Block_Template
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

}