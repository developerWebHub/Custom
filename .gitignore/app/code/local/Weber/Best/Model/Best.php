<?php

/**
 * Best model
 *
 * @category    Weber
 * @package     Weber_Best
 * @author      Ultimate Module Creator
 */
class Weber_Best_Model_Best extends Mage_Core_Model_Abstract
{
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'weber_best_best';
    const CACHE_TAG = 'weber_best_best';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'weber_best_best';

    /**
     * Parameter name in event
     *
     * @var string
     */
    protected $_eventObject = 'best';

    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('weber_best/best');
    }

    /**
     * before save best
     *
     * @access protected
     * @return Weber_Best_Model_Best
     * @author Ultimate Module Creator
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }

    /**
     * save best relation
     *
     * @access public
     * @return Weber_Best_Model_Best
     * @author Ultimate Module Creator
     */
    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    /**
     * get default values
     *
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
