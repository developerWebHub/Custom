<?php
class Weber_Best_Block_Adminhtml_Best extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller         = 'adminhtml_best';
        $this->_blockGroup         = 'weber_best';
        parent::__construct();
        $this->_headerText         = Mage::helper('weber_best')->__('Best');
        $this->_updateButton('add', 'label', Mage::helper('weber_best')->__('Add Best'));

    }
}
