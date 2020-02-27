<?php

namespace Dtn\Office\Controller\Adminhtml\employee;

class Edit extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $employeeFactory;
    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dtn\Office\Model\EmployeeFactory $employeeFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->employeeFactory = $employeeFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    public function execute()
    {
       
        // Get employee ID and Model
        $id = $this->getRequest()->getParam('entity_id');
        $employee = $this->employeeFactory->create();

        if ($id) {

            $employee->load($id);
            // die($employee->getName());
            if (!$employee) {
                $this->messageManager->addErrorMessage(__('This employee no longer exists'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/');
            }
        }
   
        $this->_coreRegistry->register('office_employee', $employee);
 
        $resultPage = $this->resultPageFactory->create();
       
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Employee') : __('New Employee'));

        return $resultPage;
    }
}
