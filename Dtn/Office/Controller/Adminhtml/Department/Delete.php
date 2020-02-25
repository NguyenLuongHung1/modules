<?php

namespace Dtn\Office\Controller\Adminhtml\Department;

use Magento\Framework\App\Action\HttpGetActionInterface;

class Delete extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $departmentFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dtn\Office\Model\DepartmentFactory $departmentFactory
    ) {
        $this->departmentFactory = $departmentFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');

        $resultRedirect = $this->resultRedirectFactory->create();

        $department = $this->departmentFactory->create();

        if ($id) {
           $department->load($id);
            
            if (!$department) {
                
                $this->messageManager->addError(__('This department no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            
            $department->delete();
            $this->messageManager->addSuccessMessage(__('Department deleted!'));
        }
        return $resultRedirect->setPath('*/*/');
    }
}
