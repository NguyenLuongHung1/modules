<?php

namespace Dtn\Office\Controller\Adminhtml\Department;

use Magento\Framework\App\Action\HttpPostActionInterface;

class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    protected $departmentFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Dtn\Office\Model\DepartmentFactory $departmentFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->departmentFactory = $departmentFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();

        $id = $data['entity_id'];

        $department = $this->departmentFactory->create();;

        if ($id) {
            $department->load($id);
            if (!$department) {
                $this->messageManager->addErrorMessage(__('This Department no longer exists'));
                $resultRedirect->setPath('*/*/');
            }
            $this->messageManager->addSuccessMessage(__('Department updated!'));
        }
        else {
            $this->messageManager->addSuccessMessage(__('New Department Created!'));
        }

        $department->setName($data['name']);

        $department->save();

        return $resultRedirect->setPath('*/*/');
    }
}
