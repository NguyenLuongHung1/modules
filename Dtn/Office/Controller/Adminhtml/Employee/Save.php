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

        // var_dump($data);
        // die();

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

        $employee->setData($data);

        $employee->save();

        if (isset($data['back'])) {
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $employee->getId()]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
