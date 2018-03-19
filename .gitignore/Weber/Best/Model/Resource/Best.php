<?php
class Weber_Best_Model_Resource_Best extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('weber_best/best', 'entity_id');
    }
}
