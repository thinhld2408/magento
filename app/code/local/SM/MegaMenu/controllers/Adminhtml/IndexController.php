<?php


/**
 * MenuManager admin index controller
 *
 * @category    Thinhld
 * @package     sm_megamenu
 */
class SM_MegaMenu_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sm_megamenu/sm_megamenu')

            ->_addBreadcrumb(
                Mage::helper('sm_megamenu')->__('MegaMenu Manager'),
                Mage::helper('sm_megamenu')->__('MegaMenu Manager')
            );

        $this->_title($this->__('MegaMenu Manager'));

        return $this;
    }


    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();

    }


    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Menu edit action
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('menu_id');
        $model = Mage::getModel('sm_megamenu/menu');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sm_megamenu')->__('This menu no longer exists.'));

                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Menu'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('menumanager_menu', $model);

        $editMenu = Mage::helper('sm_megamenu')->__('Edit Menu');
        $newMenu = Mage::helper('sm_megamenu')->__('New Menu');

        $this->_initAction()->_addBreadcrumb(
            $id ? $editMenu : $newMenu,
            $id ? $editMenu : $newMenu
        );

        $this->renderLayout();
    }

    /**
     * Menu save action
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            /* @var $model sm_megamenu_Model_Menu */
            $id = $this->getRequest()->getParam('menu_id');
            $model = Mage::getModel('sm_megamenu/menu')->load($id);

            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('sm_megamenu')->__('This menu no longer exists.'));

                $this->_redirect('*/*/');
                return;
            }

            $model->setData($data);

            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('sm_megamenu')->__('The menu has been saved.'));

                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('menu_id' => $model->getId(), '_current' => true));

                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);

                $this->_redirect('*/*/edit', array('menu_id' => $id));
                return;
            }
        }

        $this->_redirect('*/*/');
    }

    /**
     * Menu delete action
     */
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('menu_id')) {
            try {
                /* @var $model sm_megamenu_Model_Menu */
                $model = Mage::getModel('sm_megamenu/menu')->load($id);
                $model->delete();

                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('sm_megamenu')->__('The menu has been deleted.'));

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                $this->_redirect('*/*/edit', array('menu_id' => $id));
                return;
            }
        }

        Mage::getSingleton('adminhtml/session')
            ->addError(Mage::helper('sm_megamenu')->__('Unable to find a menu to delete.'));

        $this->_redirect('*/*/');
    }

    /**
     * Create new menu item
     */
    public function new_itemAction()
    {
        $this->_forward('edit_item');
    }

    /**
     * Menu item edit action
     */
    public function edit_itemAction()
    {
        /* @var $model sm_megamenu_Model_Item */
        $id = $this->getRequest()->getParam('item_id');
        $model = Mage::getModel('sm_megamenu/item');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sm_megamenu')->__('This menu item does not exist.')
                );

                $this->_redirectToMenuPage();
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Menu'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('menumanager_menu_item', $model);

        $editMenuItem = Mage::helper('sm_megamenu')->__('Edit Menu Item');
        $newMenuItem = Mage::helper('sm_megamenu')->__('New Menu Item');

        $this->_initAction()->_addBreadcrumb(
            $id ? $editMenuItem : $newMenuItem,
            $id ? $editMenuItem : $newMenuItem
        );

        $this->renderLayout();
    }

    /**
     * Menu item save action
     */
    public function save_itemAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            /* @var $model sm_megamenu_Model_Item */
            $id = $this->getRequest()->getParam('item_id');
            $menuId = $this->getRequest()->getParam('menu_id');
            $model = Mage::getModel('sm_megamenu/item')->load($id);

            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('sm_megamenu')->__('This menu item no longer exists.'));

                $this->_redirectToMenuPage();
                return;
            }

            if (!$menuId) {
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('sm_megamenu')->__('Parent menu could not be found.'));

                $this->_redirectToMenuPage();
                return;
            }

            $data['menu_id'] = $menuId;
            $model->setData($data);

            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('sm_megamenu')->__('The menu item has been saved.'));

                Mage::getSingleton('adminhtml/session')->setFormData(false);

                $this->_redirectToMenuPage();
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);

                $this->_redirectToItemPage();
                return;
            }
        }

        $this->_redirect('*/*/');
    }

    /**
     * Menu item delete action
     */
    public function delete_itemAction()
    {
        if ($id = $this->getRequest()->getParam('item_id')) {
            try {
                /* @var $model sm_megamenu_Model_Item */
                $model = Mage::getModel('sm_megamenu/item')->load($id);
                $model->delete();

                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('sm_megamenu')->__('The menu item has been deleted.'));

                $this->_redirectToMenuPage();
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                $this->_redirectToItemPage();
                return;
            }
        }

        Mage::getSingleton('adminhtml/session')
            ->addError(Mage::helper('sm_megamenu')->__('Unable to find a menu item to delete.'));

        $this->_redirectToMenuPage();
    }

    /**
     * Redirects to parent menu edit page
     */
    protected function _redirectToMenuPage()
    {
        $this->_redirect('*/*/edit', array(
            'menu_id' => $this->getRequest()->getParam('menu_id'),
            'active_tab' => 'menu_page_tabs_items_section',
        ));
    }

    /**
     * Redirects to item edit page
     */
    protected function _redirectToItemPage()
    {
        $this->_redirect('*/*/edit_item', array(
            'item_id' => $this->getRequest()->getParam('item_id'),
            'menu_id' => $this->getRequest()->getParam('menu_id'),
        ));
    }
}