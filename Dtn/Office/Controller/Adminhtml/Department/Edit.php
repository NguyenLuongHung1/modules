<?php

namespace Dtn\Office\Controller\Adminhtml\Department;

class Edit extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $departmentFactory;
    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dtn\Office\Model\DepartmentFactory $departmentFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->departmentFactory = $departmentFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    public function execute()
    {
        // Get Department ID and Model
        $id = $this->getRequest()->getParam('entity_id');
        $department = $this->departmentFactory->create();

        if ($id) {
            $department->load($id);
            // die($department->getName());
            if (!$department) {
                $this->messageManager->addErrorMessage(__('This department no longer exists'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('office_department', $department);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($department ? __('Edit Department') : __('New Department'));
        return $resultPage;
    }
}
