<?php
/*
* Create by PhpStorm.
* User: quynh.
* Unit Department: Fresher06.
*/
class SM_ProductLabel_Block_Adminhtml_Label_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('label_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('productlabel/productlabel')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('label_id', array(
            'header'    => Mage::helper('productlabel')->__('ID'),
            'align'     => 'center',
            'width'     => '50px',
            'index'     => 'label_id',
        ));

        $this->addColumn('label_logo', array(
            'header'    => Mage::helper('productlabel')->__('Image'),
            'align'     => 'center',
            'width'     => '200px',
            'index'     => 'label_logo',
            'renderer'  => 'SM_ProductLabel_Block_Adminhtml_Label_Edit_Renderer_Render',
        ));

        $this->addColumn('label_name', array(
            'header'    => Mage::helper('productlabel')->__('Name'),
            'align'     => 'center',
            'index'     => 'label_name',
        ));

        $this->addColumn('label_type', array(
            'header'    => Mage::helper('productlabel')->__('Type'),
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'label_type',
        ));

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('productlabel')->__('Status'),
            'align'     => 'center',
            'width'     => '100px',
            'index'     => 'is_active',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassAction()
    {
        $this->setMassactionIdField('label_id');
        $this->getMassactionBlock()->setFormFieldName('productlabel');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('productlabel')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('productlabel')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('productlabel/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('productlabel')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('productlabel')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
 