<?php

namespace Dtn\Office\Model\Employee;

use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param array $meta
     * @param array $data
     */
    protected $loadedData;
    protected $_coreRegistry;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        array $meta = [],
        array $data = [],
        \Magento\Framework\Registry $registry
    ) {
        
        $this->collection = $contactCollectionFactory->create();
        $this->_coreRegistry = $registry;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $department = $this->_coreRegistry->registry('office_employee');

        if ($department) {
            $this->loadedData[$department->getId()] = $department->getData();
        }

        return $this->loadedData;

    }
}

