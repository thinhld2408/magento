<?php
/*
* create by user: quynh.
* unit department: fresher 06.
*/
class SM_ProductLabel_Adminhtml_LabelController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('sm/productlabel')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Label Manager'), Mage::helper('adminhtml')->__('Label Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
            ->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }


    public function editAction()
    {

        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('productlabel/productlabel')->load($id);
        if ($id) {

            if ($model->getId()) {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data) {
                    $model->setData($data)->setId($id);
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('productlabel')->__('Example does not exist'));
                $this->_redirect('*/*/');
            }
        }
        Mage::register('productlabel_data', $model);

        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }
    public function postAction()
    {
        $post = $this->getRequest()->getPost();
        try {
            if (empty($post)) {
                Mage::throwException($this->__('Invalid form data.'));
            }

            /* here's your form processing */

            $message = $this->__('Your form has been submitted successfully.');
            Mage::getSingleton('adminhtml/session')->addSuccess($message);
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        $this->_redirect('*/*');
    }
    public function getCorrectFileName($fileName)
    {
        $fileName = preg_replace('/[^a-z0-9_\\-\\.]+/i', '_', $fileName);
        $fileInfo = pathinfo($fileName);

        if (preg_match('/^_+$/', $fileInfo['filename'])) {
            $fileName = 'file.' . $fileInfo['extension'];
        }
        return $fileName;
    }
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $modelGroup = Mage::getModel('productlabel/productlabel');

            if(isset($_FILES['label_logo']['name']) and (file_exists($_FILES['label_logo']['tmp_name']))) {
                try {
                    $uploader = new Varien_File_Uploader('label_logo');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
                    $uploader->setAllowRenameFiles(false);
                    // setAllowRenameFiles(true) -> move your file in a folder the magento way
                    // setAllowRenameFiles(true) -> move your file directly in the $path folder
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('media') . DS . 'label' . DS ;
                    $uploader->save($path, $_FILES['image']['label_logo']);
                    $imageName = $this->getCorrectFileName($_FILES['label_logo']['name']);;
                    $data['label_logo'] = 'label'.'/'.$imageName;
                }catch(Exception $e) {
                    Mage::getSingleton('adminhtml/session')
                        ->addError(Mage::helper('productlabel')->__($e));
                }
            }else {

                if(isset($data['label_logo']['delete']) && $data['label_logo']['delete'] == 1)
                    $data['image_main'] = '';
                else
                    unset($data['label_logo']);
            }
         $modelGroup->setData($data)
                ->setId($this->getRequest()->getParam('id'))

             ;

            try {
                if ($modelGroup->getCreatedTime == NULL || $modelGroup->getUpdateTime() == NULL)
                {
                    $modelGroup->setCreatedTime(now())
                        ->setUpdateTime(now());
                }
                else
                {
                    $modelGroup->setUpdateTime(now());
                }
                $modelGroup->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productlabel')->__('Item was successfully saved'.$data['image_main'].''));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $modelGroup->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        //Mage::getSingleton('adminhtml/session')->addError(Mage::helper('megamenu')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('productlabel/productlabel');

                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $webIds = $this->getRequest()->getParam('productlabel');
        if(!is_array($webIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($webIds as $webId) {
                    $web = Mage::getModel('productlabel/productlabel')->load($webId);
                    $web->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($webIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction()
    {
        $webIds = $this->getRequest()->getParam('productlabel');
        if(!is_array($webIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($webIds as $webId) {
                    $web = Mage::getSingleton('productlabel/productlabel')
                        ->load($webId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($webIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}