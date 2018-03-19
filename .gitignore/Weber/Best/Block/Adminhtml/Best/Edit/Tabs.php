<?php
class Weber_Best_Block_Adminhtml_Best_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('best_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('weber_best')->__('Best'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_best',
            array(
                'label'   => Mage::helper('weber_best')->__('Best'),
                'title'   => Mage::helper('weber_best')->__('Best'),
                'content' => $this->getLayout()->createBlock(
                    'weber_best/adminhtml_best_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        return parent::_beforeToHtml();
    }

    public function getBest()
    {
        return Mage::registry('current_best');
    }
}
