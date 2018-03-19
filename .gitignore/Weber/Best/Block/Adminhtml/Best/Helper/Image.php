<?php
class Weber_Best_Block_Adminhtml_Best_Helper_Image extends Varien_Data_Form_Element_Image
{
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = Mage::helper('weber_best/best_image')->getImageBaseUrl().
                $this->getValue();
        }
        return $url;
    }
}
