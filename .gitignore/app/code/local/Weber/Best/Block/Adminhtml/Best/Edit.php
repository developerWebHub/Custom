<?php

/**
 * Best admin edit form
 *
 * @category    Weber
 * @package     Weber_Best
 * @author      Ultimate Module Creator
 */
class Weber_Best_Block_Adminhtml_Best_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
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
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('weber_best')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
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
