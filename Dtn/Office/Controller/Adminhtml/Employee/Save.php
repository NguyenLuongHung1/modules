<?php

namespace Dtn\Office\Controller\Adminhtml\Employee;

use Magento\Framework\App\Action\HttpPostActionInterface;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    protected $employeeFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Dtn\Office\Model\EmployeeFactory $employeeFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->employeeFactory = $employeeFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();

        $id = $data['entity_id'];

        $employee = $this->employeeFactory->create();;

        if ($id) {
            $employee->load($id);

            if (!$employee) {
                $this->messageManager->addErrorMessage(__('This Employee no longer exists'));
                $resultRedirect->setPath('*/*/');
            }
            $this->messageManager->addSuccessMessage(__('Employee updated!'));
        } else {
            $this->messageManager->addSuccessMessage(__('New Employee Created!'));
        }
        
        // $employee->setData([
        //     'department_id' => $data['department_id'],
        //     'email' => $data['email'],
        //     'firstname' => $data['firstname'],
        //     'lastname' => $data['lastname'],
        //     'working_years' => $data['working_years'],
        //     'dob' => $data['dob'],
        //     'note' => $data['note'],
        //     'salary' => $data['salary'],
        // ]);

        $employee->setDepartmentId($data['department_id']);
        $employee->setEmail($data['email']);
        $employee->setFirstname($data['firstname']);
        $employee->setLastname($data['lastname']);
        $employee->setWorkingYears($data['working_years']);
        $employee->setDob($data['dob']);
        $employee->setNote($data['note']);
        $employee->setSalary($data['salary']);
      
        $employee->save();

        // var_dump($employee);
        // die();


        if (isset($data['back'])) {
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $employee->getId()]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
