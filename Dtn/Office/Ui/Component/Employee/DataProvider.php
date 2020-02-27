<?php

namespace Dtn\Office\Ui\Component\Employee;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $CollectionFactory
     * @param array $meta
     * @param array $data
     */

    protected $loadedData;
    protected $departmentFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Dtn\Office\Model\ResourceModel\Employee\CollectionFactory $collectionFactory,
        \Dtn\Office\Model\DepartmentFactory $departmentFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->collection->addAttributeToSelect('*');
        $this->departmentFactory = $departmentFactory;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $department = $this->departmentFactory->create();

        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $items = $this->getCollection()->toArray();

        foreach($items as $key=>$item) {
            $id = $item['department_id'];
            $item['department_id'] = $department->load($id)->getName();
            $items[$key] = $item;
        }

        $data = [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_values($items),
        ];
  
        return $data;
    }
}
