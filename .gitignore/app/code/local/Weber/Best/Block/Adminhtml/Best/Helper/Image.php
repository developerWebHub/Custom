<?php

/**
 * Best image field renderer helper
 *
 * @category    Weber
 * @package     Weber_Best
 * @author      Ultimate Module Creator
 */
class Weber_Best_Block_Adminhtml_Best_Helper_Image extends Varien_Data_Form_Element_Image
{
    /**
     * get the url of the image
     *
     * @access protected
     * @return string
     * @author Ultimate Module Creator
     */
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
