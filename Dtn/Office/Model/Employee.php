<?php

namespace Dtn\Office\Model;

use Magento\Framework\Model\AbstractModel;

class Employee extends AbstractModel
{
    const ENTITY = 'dtn_office_employee';

    public function _construct()
    {
        $this->_init('Dtn\Office\Model\ResourceModel\Employee');
    }
}