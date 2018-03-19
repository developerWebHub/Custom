<?php
class Weber_Best_Model_Resource_Best_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected $_joinedFields = array();
    protected function _construct()
    {
        parent::_construct();
        $this->_init('weber_best/best');
    }

    protected function _toOptionArray($valueField='entity_id', $labelField='title', $additional=array())
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }

    protected function _toOptionHash($valueField='entity_id', $labelField='title')
    {
        return parent::_toOptionHash($valueField, $labelField);
    }

    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(Zend_Db_Select::GROUP);
        return $countSelect;
    }
}
