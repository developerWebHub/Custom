<?php

/**
 * Best resource model
 *
 * @category    Weber
 * @package     Weber_Best
 * @author      Ultimate Module Creator
 */
class Weber_Best_Model_Resource_Best extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * constructor
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function _construct()
    {
        $this->_init('weber_best/best', 'entity_id');
    }
}
