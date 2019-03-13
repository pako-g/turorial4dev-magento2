<?php

namespace Tutorial4dev\Easy\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    protected $logger;

    public function __construct(\Psr\Log\LoggerInterface $loggerInterface)
    {
        $this->logger = $loggerInterface;
    }

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->info('Install Scheme Script Running!');

        $setup->startSetup();

        $table = $setup->getConnection()
            ->newTable($setup->getTable('tutorial4dev_easy_ticket'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity Id'
            )
            ->addColumn(
                'severity_level',
                \Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
                24,
                ['nullable' => false],
                'Severity Level'
            )
            ->addColumn(
                'note',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Note'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' =>false],
                'Created At'
            )
            ->setComment('Tutorial4Dev Easy Ticket Table');

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
