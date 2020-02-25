<?php 

namespace Dtn\Office\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\DB\AbstractDb;

class Department extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('dtn_office_department', 'entity_id');
    }
}