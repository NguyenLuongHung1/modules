<?php

namespace Dtn\Office\Block;

class EmployeeIndex extends \Magento\Framework\View\Element\Template
{
    protected $employeeFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Dtn\Office\Model\EmployeeFactory $employeeFactory
    ) {
        $this->employeeFactory = $employeeFactory;
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Hello World');
    }

    public function getEmployees()
    {
        $employeeModel = $this->employeeFactory->create();
        $collection = $employeeModel->getCollection()
                ->addFieldToSelect('*');
                // ->addFieldToFilter('working_years', ['gt'=>'0'])
                // ->addFieldToFilter('salary', ['gt'=>'4000']);
        return $collection;
    }
}
