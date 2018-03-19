<?php
class Weber_Best_Block_Adminhtml_Best_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('bestGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('weber_best/best')
            ->getCollection();     
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            array(
                'header' => Mage::helper('weber_best')->__('Id'),
                'index'  => 'entity_id',
                'type'   => 'number'
            )
        );
        $this->addColumn(
            'title',
            array(
                'header'    => Mage::helper('weber_best')->__('Title'),
                'align'     => 'left',
                'index'     => 'title',
            )
        );
        
        $this->addColumn(
            'status',
            array(
                'header'  => Mage::helper('weber_best')->__('Status'),
                'index'   => 'status',
                'type'    => 'options',
                'options' => array(
                    '1' => Mage::helper('weber_best')->__('Enabled'),
                    '0' => Mage::helper('weber_best')->__('Disabled'),
                )
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'  =>  Mage::helper('weber_best')->__('Action'),
                'width'   => '100',
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('weber_best')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'is_system' => true,
                'sortable'  => false,
            )
        );
 
        return parent::_prepareColumns();
    }

      
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}
