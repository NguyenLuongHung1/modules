<?php

namespace Dtn\Office\Setup;

use Magento\Eav\Setup\EavSetup;

class EmployeeSetup extends EavSetup
{
    public function getDefaultEntities()
    {
        $employeeEntity = \Dtn\Office\Model\Employee::ENTITY;

        $entities = [
            $employeeEntity => [
                'entity_model' => 'Dtn\Office\Model\ResourceModel\Employee',
                'table' => $employeeEntity . '_entity',
                'attributes' => [
                    'department_id' => [
                        'type' => 'static',
                    ],
                    'email' => [
                        'type' => 'static',
                    ],
                    'firstname' => [
                        'type' => 'static',
                    ],
                    'lastname' => [
                        'type' => 'static',
                    ],
                ],
            ],
        ];
        return $entities;
    }
}