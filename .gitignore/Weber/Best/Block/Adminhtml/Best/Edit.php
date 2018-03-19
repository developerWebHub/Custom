<?php
class Weber_Best_Block_Adminhtml_Best_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'weber_best';
        $this->_controller = 'adminhtml_best';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('weber_best')->__('Save Best')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('weber_best')->__('Delete Best')
        );
        
    }

    
    public function getHeaderText()
    {
        if (Mage::registry('current_best') && Mage::registry('current_best')->getId()) {
            return Mage::helper('weber_best')->__(
                "Edit Best '%s'",
                $this->escapeHtml(Mage::registry('current_best')->getTitle())
            );
        } else {
            return Mage::helper('weber_best')->__('Add Best');
        }
    }
}
