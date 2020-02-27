<?php

namespace Dtn\Office\Controller\Adminhtml\Employee;

use Magento\Framework\App\Action\HttpGetActionInterface;

class Delete extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $employeeFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dtn\Office\Model\EmployeeFactory $employeeFactory
    ) {
        $this->employeeFactory = $employeeFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        $resultRedirect = $this->resultRedirectFactory->create();

        $employee = $this->employeeFactory->create();

        if ($id) {
            $employee->load($id);

            if (!$employee) {

                $this->messageManager->addError(__('This employee no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $employee->delete();
            $this->messageManager->addSuccessMessage(__('Employee deleted!'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
