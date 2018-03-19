<?php
class Weber_Best_Model_Best extends Mage_Core_Model_Abstract
{
    const ENTITY    = 'weber_best_best';
    const CACHE_TAG = 'weber_best_best';
    protected $_eventPrefix = 'weber_best_best';
    protected $_eventObject = 'best';

    public function _construct()
    {
        parent::_construct();
        $this->_init('weber_best/best');
    }

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

    protected function _afterSave()
    {
        return parent::_afterSave();
    }

    public function getDefaultValues()
    {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
    
}
