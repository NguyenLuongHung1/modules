<?php

namespace Dtn\Office\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /**
         * Create Department Table
         */
        $departmentTable = 'dtn_office_department';
        $table = $setup->getConnection()
            ->newTable($setup->getTable($departmentTable))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'primary' => true,
                    'nullable' => false,
                    'unsigned' => true,
                    'identity' => true,
                ],
                'Entity Id'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [
                    'nullable' => false,
                ],
                'Department Name'
            )
            ->setComment('DTN Office Department Table');
        $setup->getConnection()->createTable($table);

        /**
         * Create Employee Entity Table
         */
        $employeeTable = \Dtn\Office\Model\Employee::ENTITY . '_entity';
        $table = $setup->getConnection()
            ->newTable($setup->getTable($employeeTable))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'primary' => true,
                    'nullable' => false,
                    'unsigned' => true,
                    'identity' => true,
                ],
                'Entity Id'
            )
            ->addColumn(
                'department_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'unsigned' => true,
                ],
                'Department Id'
            )
            ->addColumn(
                'email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                64,
                [],
                'Email'
            )
            ->addColumn(
                'firstname',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                64,
                [],
                'First Name'
            )
            ->addColumn(
                'lastname',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                64,
                [],
                'Last Name'
            )
            ->addForeignKey(
                $setup->getFkName(
                    $employeeTable,
                    'department_id',
                    $departmentTable,
                    'entity_id'
                ),
                'department_id',
                $setup->getTable($departmentTable),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('DTN Office Employee Table');
        $setup->getConnection()->createTable($table);

        /**
         * EAV Attributes Table
         */
        $types = ['datetime', 'decimal', 'int', 'text'];

        $employeeTableAttr = '';

        foreach ($types as $type) {
            $employeeTableAttr = $employeeTable . '_' . $type;
            $columnType = '';
            $columnSize = '';
            switch ($type) {
                case 'datetime':
                    $columnType = \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME;
                    $columnSize = null;
                    break;
                case 'decimal':
                    $columnType = \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL;
                    $columnSize = '12,4';
                    break;
                case 'int':
                    $columnType = \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER;
                    $columnSize = null;
                    break;
                case 'text':
                    $columnType = \Magento\Framework\DB\Ddl\Table::TYPE_TEXT;
                    $columnSize = null;
                    break;
                default:
                    break;
            }

            $table = $setup->getConnection()
                ->newTable($setup->getTable($employeeTableAttr))
                ->addColumn(
                    'value_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'primary' => true,
                        'nullable' => false,
                        'unsigned' => true,
                        'identity' => true,
                    ],
                    'Value Id'
                )
                ->addColumn(
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0',
                    ],
                    'Attribute Id'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0',
                    ],
                    'Store Id'
                )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Entity Id'
                )
                ->addColumn(
                    'value',
                    $columnType,
                    $columnSize,
                    [],
                    'Value'
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeTableAttr,
                        ['store_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
                    ),
                    ['store_id']
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeTableAttr,
                        ['attribute_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
                    ),
                    ['attribute_id']
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeTableAttr,
                        ['entity_id', 'attribute_id', 'store_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['entity_id', 'attribute_id', 'store_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeTableAttr,
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $setup->getTable('eav_attribute'),
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeTableAttr,
                        'store_id',
                        'store',
                        'store_id'
                    ),
                    'store_id',
                    $setup->getTable('store'),
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeTableAttr,
                        'entity_id',
                        $employeeTable,
                        'entity_id'
                    ),
                    'entity_id',
                    $setup->getTable($employeeTable),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->setComment('DTN Office'. $type .' Employee Table');
            $setup->getConnection()->createTable($table);
        }
        $setup->endSetup();
    }
}
