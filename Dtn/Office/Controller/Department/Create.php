<?php

namespace Dtn\Office\Controller\Department;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Create extends Action
{
    protected $departmentFactory;

    public function __construct(Context $context, \Dtn\Office\Model\DepartmentFactory $departmentFactory)
    {
        $this->departmentFactory = $departmentFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $name = $this->getRequest()->getParam('name');
        $department = $this->departmentFactory->create();
        $department->setName($name)
            ->save();
    }
}
