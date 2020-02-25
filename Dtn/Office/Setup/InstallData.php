<?php

namespace Dtn\Office\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var
     */
    protected $employeeSetupFactory;

    public function __construct(\Dtn\Office\Setup\EmployeeSetupFactory $employeeSetupFactory)
    {
        $this->employeeSetupFactory = $employeeSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        
        $employeeEntity = \Dtn\Office\Model\Employee::ENTITY;

        $employeeSetup = $this->employeeSetupFactory->create(['setup' => $setup]);

        $employeeSetup->installEntities();

        $employeeSetup->addAttribute(
            $employeeEntity, 'working_years', ['type' => 'int']
        );

        $employeeSetup->addAttribute(
            $employeeEntity, 'dob', ['type' => 'datetime']
        );

        $employeeSetup->addAttribute(
            $employeeEntity, 'salary', ['type' => 'decimal']
        );

        $employeeSetup->addAttribute(
            $employeeEntity, 'note', ['type' => 'text']
        );

        $setup->endSetup();
    }
}