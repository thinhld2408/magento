<?php


/**
 * MenuManager admin index controller
 *
 * @category    Thinhld
 * @package     SM_Slider
 */
class SM_Slider_Adminhtml_SliderController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sm_slider/sm_slider')

            ->_addBreadcrumb(
                Mage::helper('sm_slider')->__('Slider Manager'),
                Mage::helper('sm_slider')->__('Slider Manager')
            );

        $this->_title($this->__('Slider Manager'));

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
        $id = $this->getRequest()->getParam('slider_id');
        $model = Mage::getModel('sm_slider/slider');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sm_slider')->__('This menu no longer exists.'));

                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Slider'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('slidermanager_slider', $model);

        $editSlider = Mage::helper('sm_slider')->__('Edit Slider');
        $newSlider = Mage::helper('sm_slider')->__('New Slider');

        $this->_initAction()->_addBreadcrumb(
            $id ? $editSlider : $newSlider,
            $id ? $editSlider : $newSlider
        );

        $this->renderLayout();
    }

    /**
     * Menu save action
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            /* @var $model SM_Slider_Model_Slider */
            $id = $this->getRequest()->getParam('slider_id');
            $model = Mage::getModel('sm_slider/slider')->load($id);

            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('sm_slider')->__('This slider no longer exists.'));

                $this->_redirect('*/*/');
                return;
            }

            $model->setData($data);

            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('sm_slider')->__('The slider has been saved.'));

                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('slider_id' => $model->getId(), '_current' => true));

                    return;
                }

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);

                $this->_redirect('*/*/edit', array('slider_id' => $id));
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
        if ($id = $this->getRequest()->getParam('slider_id')) {
            try {
                /* @var $model SM_Slider_Model_Slider */
                $model = Mage::getModel('sm_slider/slider')->load($id);
                $model->delete();

                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('sm_slider')->__('The slider has been deleted.'));

                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                $this->_redirect('*/*/edit', array('slider_id' => $id));
                return;
            }
        }

        Mage::getSingleton('adminhtml/session')
            ->addError(Mage::helper('sm_slider')->__('Unable to find a slider to delete.'));

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
        /* @var $model SM_Slider_Model_Item */
        $id = $this->getRequest()->getParam('item_id');
        $model = Mage::getModel('sm_slider/item');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('sm_slider')->__('This slider item does not exist.')
                );

                $this->_redirectToMenuPage();
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Slider'));
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('slidermanager_slider_item', $model);

        $editSliderItem = Mage::helper('sm_slider')->__('Edit slider Item');
        $newSliderItem = Mage::helper('sm_slider')->__('New slider Item');

        $this->_initAction()->_addBreadcrumb(
            $id ? $editSliderItem : $newSliderItem,
            $id ? $editSliderItem : $newSliderItem
        );

        $this->renderLayout();
    }

    /**
     * Menu item save action
     */
    public function getCorrectFileName($fileName)
    {
        $fileName = preg_replace('/[^a-z0-9_\\-\\.]+/i', '_', $fileName);
        $fileInfo = pathinfo($fileName);

        if (preg_match('/^_+$/', $fileInfo['filename'])) {
            $fileName = 'file.' . $fileInfo['extension'];
        }
        return $fileName;
    }

    public function save_itemAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            /* @var $model sm_slider_Model_Item */

            if(isset($_FILES['item_picture']['name']) and (file_exists($_FILES['item_picture']['tmp_name']))) {
                try {
                    $uploader = new Varien_File_Uploader('item_picture');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
                    $uploader->setAllowRenameFiles(false);
                    // setAllowRenameFiles(true) -> move your file in a folder the magento way
                    // setAllowRenameFiles(true) -> move your file directly in the $path folder
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('media') . DS . 'banner' . DS ;
                    $uploader->save($path, $_FILES['item_picture']['name']);
                    $imageName = $this->getCorrectFileName($_FILES['item_picture']['name']);;
                    $data['item_picture'] = 'banner'.'/'.$imageName;
                }catch(Exception $e) {
                    Mage::getSingleton('adminhtml/session')
                        ->addError(Mage::helper('sm_slider')->__('Unable upload image'));
                }
            }else {

                if(isset($data['item_picture']['delete']) && $data['item_picture']['delete'] == 1)
                    $data['image_main'] = '';
                else
                    unset($data['item_picture']);
            }

            $id = $this->getRequest()->getParam('item_id');
            $sliderId = $this->getRequest()->getParam('slider_id');
            $model = Mage::getModel('sm_slider/item')->load($id);



            if (!$model->getId() && $id) {
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('sm_slider')->__('This slider item no longer exists.'));

                $this->_redirectToMenuPage();
                return;
            }

            if (!$sliderId) {
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('sm_slider')->__('Parent slider could not be found.'));

                $this->_redirectToMenuPage();
                return;
            }

            $data['slider_id'] = $sliderId;
            $model->setData($data);

            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('sm_slider')->__('The slider item has been saved.'));

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
                /* @var $model sm_slider_Model_Item */
                $model = Mage::getModel('sm_slider/item')->load($id);
                $model->delete();

                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('sm_slider')->__('The slider item has been deleted.'));

                $this->_redirectToMenuPage();
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

                $this->_redirectToItemPage();
                return;
            }
        }

        Mage::getSingleton('adminhtml/session')
            ->addError(Mage::helper('sm_slider')->__('Unable to find a slider item to delete.'));

        $this->_redirectToMenuPage();
    }

    /**
     * Redirects to parent menu edit page
     */
    protected function _redirectToMenuPage()
    {
        $this->_redirect('*/*/edit', array(
            'slider_id' => $this->getRequest()->getParam('slider_id'),
            'active_tab' => 'slider_page_tabs_items_section',
        ));
    }

    /**
     * Redirects to item edit page
     */
    protected function _redirectToItemPage()
    {
        $this->_redirect('*/*/edit_item', array(
            'item_id' => $this->getRequest()->getParam('item_id'),
            'slider_id' => $this->getRequest()->getParam('slider_id'),
        ));
    }
}