<?php

namespace Dtn\Office\Controller\Department;

class Update extends \Magento\Framework\App\Action\Action
{
    protected $departmentFactory;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Dtn\Office\Model\DepartmentFactory $departmentFactory)
    {
        $this->departmentFactory = $departmentFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $department = $this->departmentFactory->create();
        $data = $this->getRequest()->getParams();
        $id = $data['id'];
        $name = $data['name'];
        $department->load($id);
        if(empty($department->toArray())){
            var_dump('Department doesnt exist');
        } else {
            $department->setName($name);
            $department->save();
            var_dump($department->toArray());
        };
    }
}