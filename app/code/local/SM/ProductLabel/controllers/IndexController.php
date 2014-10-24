<?php
/*
* create by user: quynh.
* unit department: fresher 06.
*/
class SM_ProductLabel_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        echo __METHOD__;
        $this->loadLayout();
        $this->renderLayout();
    }
}