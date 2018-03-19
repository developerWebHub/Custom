<?php 
class Weber_Best_Block_Adminhtml_Best_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{ 
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('best_');
        $form->setFieldNameSuffix('best');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'best_form',
            array('legend' => Mage::helper('weber_best')->__('Best'))
        );
        $fieldset->addType(
            'image',
            Mage::getConfig()->getBlockClassName('weber_best/adminhtml_best_helper_image')
        );

        $fieldset->addField(
            'title',
            'text',
            array(
                'label' => Mage::helper('weber_best')->__('Title'),
                'name'  => 'title',

           )
        );

        $fieldset->addField(
            'image',
            'image',
            array(
                'label' => Mage::helper('weber_best')->__('Image'),
                'name'  => 'image',

           )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('weber_best')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('weber_best')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('weber_best')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_best')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getBestData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getBestData());
            Mage::getSingleton('adminhtml/session')->setBestData(null);
        } elseif (Mage::registry('current_best')) {
            $formValues = array_merge($formValues, Mage::registry('current_best')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
