<?php 

namespace Dtn\Office\Block\Adminhtml;

class Department extends \Magento\Backend\Block\Widget\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_department';
        $this->_blockGroup = 'Dtn_Office';
        $this->_headerText = __('Department');
        $this->addButtonLabel = __('Create New Post');
        parent::_construct();
    }
}