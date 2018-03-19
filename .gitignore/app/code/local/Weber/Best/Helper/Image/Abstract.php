<?php

/**
 * abstract image helper
 *
 * @category    Weber
 * @package     Weber_Best
 * @author      Ultimate Module Creator
 */
abstract class Weber_Best_Helper_Image_Abstract extends Mage_Core_Helper_Data
{
    /**
     * path to image placeholder
     * override in child
     * @var string
     */
    protected $_placeholder     = '';

    /**
     * subdirectory to save imaves
     * override in child
     * @var string
     */
    protected $_subdir          = '';

    /**
     * image processor
     * @var null|Varien_Image_Adapter_Gd2
     */
    protected $_imageProcessor     = null;

    /**
     * image to process
     * @var unknown_type
     */
    protected $_image             = null;

    /**
     * error message
     * @var string
     */
    protected $_openError         = "";

    /**
     * keep image frame
     * @var bool
     */
    protected $_keepFrame       = false;

    /**
     * keep image aspect ratio
     * @var bool
     */
    protected $_keepAspectRatio = true;

    /**
     * constrain image
     * @var bool
     */
    protected $_constrainOnly   = true;

    /**
     * addaptive resize - crop
     * https://github.com/wearefarm/magento-adaptive-resize/blob/master/README.md
     * @var bool
     */
    protected $_adaptiveResize  = 'center'; // false|center|top|bottom

    /**
     * image width
     * @var mixed(null|int)
     */
    protected $_width           = null;

    /**
     * image height
     * @var mixed(null|int)
     */
    protected $_height          = null;

    /**
     * image resize needed
     * @var mixed (null|array)
     */
    protected $_scheduledResize = null;

    /**
     * image is resized
     * @var bool
     */
    protected $_resized         = false;

    /**
     * addaptive resize positions
     * https://github.com/wearefarm/magento-adaptive-resize/blob/master/README.md
     * @var array
     */
    protected $_adaptiveResizePositions = array(
        'center' => array(0.5,0.5),
        'top'    => array(1,0),
        'bottom' => array(0,1)
    );

    /**
     * resized image folder name
     * @var string
     */
    protected $_resizeFolderName = 'cache';

    /**
     * get the image base dir
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getImageBaseDir()
    {
        return Mage::getBaseDir('media').DS.$this->_subdir.DS.'image';
    }

    /**
     * get the image url for object
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getImageBaseUrl()
    {
        return Mage::getBaseUrl('media').$this->_subdir.'/'.'image';
    }

    /**
     * init image
     *
     * @access public
     * @param Varien_Object $object
     * @param string $imageField
     * @return Weber_Best_Helper_Image_Abstract
     * @author Ultimate Module Creator
     */
    public function init(Varien_Object $object, $imageField = 'image')
    {
        $this->_imageProcessor = null;
        $this->_image = $object->getDataUsingMethod($imageField);
        if (!$this->_image) {
            $this->_image = '/'.$this->_placeholder;
        }
        $this->_width = null;
        $this->_height = null;
        $this->_scheduledResize = false;
        $this->_resized = false;
        $this->_adaptiveResize = 'center';

        try {
            $this->_getImageProcessor()->open($this->getImageBaseDir().$this->_image);
        } catch (Exception $e) {
            $this->_openError = $e->getMessage();
            try {
                $this->_getImageProcessor()->open(Mage::getDesign()->getSkinUrl($this->_placeholder));
                $this->_image = '/'.$this->_placeholder;
            } catch(Exception $e) {
                $this->_openError .= "\n".$e->getMessage();
                $this->_image = null;
            }
        }
        return $this;
    }

    /**
     * get the image processor
     *
     * @access protected
     * @return Varien_Image_Adapter_Gd2
     * @author Ultimate Module Creator
     */
    protected function _getImageProcessor()
    {
        if (is_null($this->_imageProcessor)) {
            $this->_imageProcessor = Varien_Image_Adapter::factory('GD2');
            $this->_imageProcessor->keepFrame($this->_keepFrame);
            $this->_imageProcessor->keepAspectRatio($this->_keepAspectRatio);
            $this->_imageProcessor->constrainOnly($this->_constrainOnly);
        }
        return $this->_imageProcessor;
    }

    /**
     * Get/set keepAspectRatio
     *
     * @access public
     * @param bool $value
     * @return mixed(bool|Weber_Best_Helper_Image_Abstract)
     * @author Ultimate Module Creator
     */
    public function keepAspectRatio($value = null)
    {
        if (null !== $value) {
            $this->_getImageProcessor()->keepAspectRatio($value);
            return $this;
        } else {
            return $this->_getImageProcessor()->keepAspectRatio();
        }
    }

    /**
     * Get/set keepFrame
     *
     * @access public
     * @param bool $value
     * @return mixed(bool|Weber_Best_Helper_Image_Abstract)
     * @author Ultimate Module Creator
     */
    public function keepFrame($value = null)
    {
        if (null !== $value) {
            $this->_getImageProcessor()->keepFrame($value);
            return $this;
        } else {
            return $this->_getImageProcessor()->keepFrame();
        }
    }

    /**
     * Get/set keepTransparency
     *
     * @access public
     * @param bool $value
     * @return mixed(bool|Weber_Best_Helper_Image_Abstract)
     * @author Ultimate Module Creator
     */
    public function keepTransparency($value = null)
    {
        if (null !== $value) {
            $this->_getImageProcessor()->keepTransparency($value);
            return $this;
        } else {
            return $this->_getImageProcessor()->keepTransparency();
        }
    }

    /**
     * Get/set adaptiveResize
     *
     * @access public
     * @param bool|string $value
     * @return mixed(bool|Weber_Best_Helper_Image_Abstract)
     * https://github.com/wearefarm/magento-adaptive-resize/blob/master/README.md
     * @author Ultimate Module Creator
     */
    public function adaptiveResize($value = null)
    {
        if (null !== $value) {
            $this->_adaptiveResize = $value;
            if ($value) {
                $this->keepFrame(false);
            }
            return $this;
        } else {
            return $this->_adaptiveResize;
        }
    }

    /**
     * Get/set constrainOnly
     *
     * @access public
     * @param bool $value
     * @return mixed(bool|Weber_Best_Helper_Image_Abstract)
     * @author Ultimate Module Creator
     */
    public function constrainOnly($value = null)
    {
       if (null !== $value) {
            $this->_getImageProcessor()->constrainOnly($value);
            return $this;
       } else {
            return $this->_getImageProcessor()->constrainOnly();
       }
    }

    /**
     * Get/set quality, values in percentage from 0 to 100
     *
     * @access public
     * @param int $value
     * @return mixed(bool|Weber_Best_Helper_Image_Abstract)
     * @author Ultimate Module Creator
     */
    public function quality($value = null)
    {
        if (null !== $value) {
            $this->_getImageProcessor()->quality($value);
            return $this;
        } else {
            return $this->_getImageProcessor()->quality();
        }
    }

    /**
     * Get/set keepBackgroundColor
     *
     * @access public
     * @param array $value
     * @return mixed(bool|Weber_Best_Helper_Image_Abstract)
     * @author Ultimate Module Creator
     */
    public function backgroundColor($value = null)
    {
        if (null !== $value) {
            $this->_getImageProcessor()-> backgroundColor($value);
            return $this;
        } else {
            return $this->_getImageProcessor()-> backgroundColor();
        }
    }

    /**
     * resize image
     *
     * @access public
     * @param int $width - defaults to null
     * @param int $height - defaults to null
     * @return Weber_Best_Helper_Image_Abstract
     * @author Ultimate Module Creator
     */
    public function resize($width = null, $height = null)
    {
        $this->_scheduledResize = true;
        $this->_width  = $width;
        $this->_height = $height;
        return $this;
    }

    /**
     * get destination image prefix
     *
     * @access protected
     * @return Weber_Best_Helper_Image_Abstract
     * @author Ultimate Module Creator
     */
    protected function _getDestinationImagePrefix()
    {
        if (!$this->_image) {
            return $this;
        }
        $imageRealPath = "";
        if ($this->_scheduledResize) {
            $width  = $this->_width;
            $height = $this->_height;
            $adaptive   = $this->adaptiveResize();
            $keepFrame  = $this->keepFrame();
            $keepAspectRatio= $this->keepAspectRatio();
            $constrainOnly  = $this->constrainOnly();
            $imageRealPath = $width.'x'.$height;
            $options = "";

            if (!$keepAspectRatio) {
                $imageRealPath .= '-exact';
            } else {
                if (!$keepFrame && $width && $height && ($adaptive !== false)) {
                    $adaptive = strtolower(trim($adaptive));
                    if (isset($this->_adaptiveResizePositions[$adaptive])) {
                        $imageRealPath .= '-'.$adaptive;
                    }
                }
            }
            if ($keepFrame) {
                $imageRealPath .= '-frame';
                $_backgroundColor = $this->backgroundColor();
                if ($_backgroundColor) {
                    $imageRealPath .= '-'.implode('-', $_backgroundColor);
                }
            }
            if (!$constrainOnly) {
                $imageRealPath .= '-zoom';
            }
        }
        return $imageRealPath;
    }

    /**
     * get image destination path
     *
     * @access protected
     * @return string
     * @author Ultimate Module Creator
     */
    protected function _getDestinationPath()
    {
        if (!$this->_image) {
            return $this;
        }
        if ($this->_scheduledResize) {
            return $this->getImageBaseDir().DS.$this->_resizeFolderName.DS.$this->_getDestinationImagePrefix().DS.$this->_image;
        } else {
            return $this->getImageBaseDir().DS.$this->_image;
        }
    }

    /**
     * get image url
     *
     * @access protected
     * @return mixed (string|bool)
     * @author Ultimate Module Creator
     */
    protected function _getImageUrl()
    {
        if (!$this->_image) {
            return false;
        }
        if ($this->_scheduledResize) {
            return  $this->getImageBaseUrl().'/'.$this->_resizeFolderName.'/'.$this->_getDestinationImagePrefix().$this->_image;
        } else {
           return  $this->getImageBaseUrl().$this->_image;
        }
    }

    /**
     * resize image
     *
     * @access protected
     * @return Weber_Best_Helper_Image_Abstract
     * @author Ultimate Module Creator
     */
    protected function _doResize()
    {
        if (!$this->_image || !$this->_scheduledResize || $this->_resized) {
            return $this;
        }
        $this->_resized = true; //mark as resized
        $width = $this->_width;
        $height = $this->_height;
        $adaptive = $width && $height &&
                    $this->keepAspectRatio() && !$this->keepFrame() &&
                    ($this->adaptiveResize() !== false);
        $adaptivePosition = false;
        if ($adaptive) {
            $adaptive = strtolower(trim($this->adaptiveResize()));
            if (isset($this->_adaptiveResizePositions[$adaptive])) {
                $adaptivePosition = $this->_adaptiveResizePositions[$adaptive];
            }
        }
        $processor = $this->_getImageProcessor();

        if (!$adaptivePosition) {
            $processor->resize($width, $height);
            return $this;
        }
        //make adaptive resize
        //https://github.com/wearefarm/magento-adaptive-resize/blob/master/README.md
        $currentRatio = $processor->getOriginalWidth() / $processor->getOriginalHeight();
        $targetRatio  = $width / $height;
        if ($targetRatio > $currentRatio) {
            $processor->resize($width, null);
        } else {
            $processor->resize(null, $height);
        }
        $diffWidth  = $processor->getOriginalWidth() - $width;
        $diffHeight = $processor->getOriginalHeight() - $height;
        if ($diffWidth || $diffHeight) {
            $processor->crop(
                floor($diffHeight * $adaptivePosition[0]), //top rate
                floor($diffWidth / 2),
                ceil($diffWidth / 2),
                ceil($diffHeight *  $adaptivePosition[1]) //bottom rate
            );
        }
        return $this;
    }

    /**
     * to string - no need for cache expire because the image names will be different
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function __toString()
    {
        try {
            if (!$this->_image) {
                throw new Exception($this->_openError);
            }
            $imageRealPath = $this->_getDestinationPath();
            if (!file_exists($imageRealPath)) {
                $this->_doResize();
                $this->_getImageProcessor()->save($imageRealPath);
            }
            return $this->_getImageUrl();
        } catch (Exception $e) {
            Mage::logException($e);
            return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAAnFBMVEUAAAAAAAAAAAAAAAC0tLS4uLi0tLT6+vrx8fHo6Ojj4OC+mpq7UE2wXlqzOTGtHwza2dnGaWeiJxDV0dGNJhari4uqeHi/W1edTkevSkWWNCOLEQiXEgbExMXbiorTgH+NT0a4RD+XIxTPFwm7BQHYAwHJAwDLd3aWcXDKV03JODOjNyunLCS6JQ6nCQO/q6viqKjFREOYQTrQIiHNANNfAAAAB3RSTlMCPiYZ3uvFTohbPwAAAURJREFUOMuVk9dygzAQRW3jeGUhikQvDtUl7uX//y0b4bGMCDPJAV64Z+5Ko9HkLxizEYynMCW/A9OXsETI8xkRSPeNNpDnOyZo5dChCe8pAUJ04Qd65bzYXilIaSiYrPhEisoEiS5YvOCVbdt8G1kDATGjbWV5QC7HiDNzKFCb2/J3wqKIVcuBEDImi60vxo5JEvYEQCFmB0/mt5sdHhNLF+CQHGS+3+Ok2k8HQprVAPf944E51JkuAMRZdrk7m7WDuZfncV9Awiz3uxzlcx5qAgHq5067kXkgzj7VBCSoz63YYX/stCKAQQNAKdrmJITTbERJJErojMA/Net1c/IDPBxK6cJ424WE7so0LXcuoauV585nk5fQh5AVgDvvBqgGBRaA+yFztcheAfWoytUIJbhd/3iDykcWuZhpl3eqYUz+wTdj6SFVkjRnJQAAAABJRU5ErkJggg==';
        }
    }
}