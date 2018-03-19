<?php
abstract class Weber_Best_Helper_Image_Abstract extends Mage_Core_Helper_Data
{
    protected $_subdir          = '';
    protected $_imageProcessor     = null;
    protected $_image             = null; 
    protected $_width           = null;
    protected $_height          = null;
 
    public function getImageBaseDir()
    {
        return Mage::getBaseDir('media').DS.$this->_subdir.DS.'image';
    }

    public function getImageBaseUrl()
    {
        return Mage::getBaseUrl('media').$this->_subdir.'/'.'image';
    }

    public function init(Varien_Object $object, $imageField = 'image')
    {
        $this->_imageProcessor = null;
        $this->_image = $object->getDataUsingMethod($imageField);
        if (!$this->_image) {
            $this->_image = null;
        }
        $this->_width = null;
        $this->_height = null; 

        try {
            $this->_getImageProcessor()->open($this->getImageBaseDir().$this->_image);
        } catch (Exception $e) { 
           $this->_image = null;
        }
        return $this;
    }
    
    protected function _getImageProcessor()
    {
        if (is_null($this->_imageProcessor)) {
            $this->_imageProcessor = Varien_Image_Adapter::factory('GD2');
            
        }
        return $this->_imageProcessor;
    }
  
    protected function _getDestinationPath()
    {
        if (!$this->_image) {
            return $this;
        }
        if ($this->_scheduledResize) {
            return $this->getImageBaseDir().DS.$this->_image;
        } else {
            return $this->getImageBaseDir().DS.$this->_image;
        }
    }    
}
