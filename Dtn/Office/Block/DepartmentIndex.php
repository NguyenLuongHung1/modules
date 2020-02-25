<?php

namespace Dtn\Office\Block;

class DepartmentIndex extends \Magento\Framework\View\Element\Template
{
    protected $departmentFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Dtn\Office\Model\DepartmentFactory $departmentFactory
    ) {
        $this->departmentFactory = $departmentFactory;
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Hello World');
    }

    public function getDepartments()
    {
        $departmentModel = $this->departmentFactory->create();
        $collection = $departmentModel->getCollection();
        $collection->addFieldToFilter(
            'name',
            ['like' => 'A%']
        )
        ->addFieldToFilter('entity_id', ['gt'=> '3']);
        return $collection;
    }
}
