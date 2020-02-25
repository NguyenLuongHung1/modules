<?php

namespace Dtn\Office\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $departmentFactory;
    protected $employeeFactory;

    public function __construct(
        \Dtn\Office\Model\DepartmentFactory $departmentFactory,
        \Dtn\Office\Model\EmployeeFactory $employeeFactory
    ) {
        $this->departmentFactory = $departmentFactory;
        $this->employeeFactory =  $employeeFactory;
    }

    public function upgrade(\Magento\Framework\Setup\ModuleDataSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $setup->startSetup();

        $devDepartment = $this->departmentFactory->create();
        $devDepartment->setName('Developer')
            ->save();

        $biddEmployee = $this->employeeFactory->create();
        $biddEmployee->setDepartmentId($devDepartment->getId())
            ->setEmail('hungnl@dtn.vn')
            ->setFirstname('BiDD')
            ->setLastname('Nguyen')
            ->setDob('1998-03-26')
            ->setSalary('4000.0')
            ->setWorking_years('1')
            ->setNote('A dedicated worker')
            ->save();

        $biddEmployee = $this->employeeFactory->create();
        $biddEmployee->setDepartmentId($devDepartment->getId())
            ->setEmail('hungnl@dtn.vn')
            ->setFirstname('BiDD2')
            ->setLastname('Nguyen')
            ->setDob('1995-06-29')
            ->setSalary('8000.0')
            ->setWorking_years('2')
            ->setNote('A dedicated worker')
            ->save();

        $biddEmployee = $this->employeeFactory->create();
        $biddEmployee->setDepartmentId($devDepartment->getId())
            ->setEmail('hungnl@dtn.vn')
            ->setFirstname('BiDD3')
            ->setLastname('Nguyen')
            ->setDob('1992-02-14')
            ->setSalary('12000.0')
            ->setWorking_years('3')
            ->setNote('A dedicated worker')
            ->save();

        $steveEmployee = $this->employeeFactory->create();
        $steveEmployee->setDepartmentId(3)
            ->setEmail('stevenl@dtn.vn')
            ->setFirstname('Steve')
            ->setLastname('Nguyen')
            ->setSalary('3000.0')
            ->setNote('Good worker')
            ->save();

        $steveEmployee = $this->employeeFactory->create();
        $steveEmployee->setDepartmentId(4)
            ->setEmail('stevenl@dtn.vn')
            ->setFirstname('Steve')
            ->setLastname('Nguyen')
            ->setSalary('3000.0')
            ->setNote('Good worker')
            ->save();

        $steveEmployee = $this->employeeFactory->create();
        $steveEmployee->setDepartmentId(4)
            ->setEmail('stevenl@dtn.vn')
            ->setFirstname('Steve')
            ->setLastname('Nguyen')
            ->setSalary('3000.0')
            ->setNote('Good worker')
            ->save();

        $steveEmployee = $this->employeeFactory->create();
        $steveEmployee->setDepartmentId(5)
            ->setEmail('stevenl@dtn.vn')
            ->setFirstname('Steve')
            ->setLastname('Nguyen')
            ->setSalary('3000.0')
            ->setNote('Good worker')
            ->save();


        $setup->endSetup();
    }
}
