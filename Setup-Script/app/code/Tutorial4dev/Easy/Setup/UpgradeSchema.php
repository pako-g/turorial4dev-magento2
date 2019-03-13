<?php
namespace Tutorial4dev\Easy\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    protected $logger;
    public function __construct(\Psr\Log\LoggerInterface $loggerInterface)
    {
        $this->logger = $loggerInterface;
    }

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->info('Upgrade Schema Script Running!');

        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $this->upgradeToVersionOneZeroOne($setup);
        }
        $setup->endSetup();
    }

    private function upgradeToVersionOneZeroOne(SchemaSetupInterface $setup)
    {
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('tutorial4dev_easy_ticket'),
                'name',
                [
                    'type' => \Magento\Framework\Db\Ddl\Table::TYPE_TEXT,
                    'length'=> null,
                    'nullable' => false,
                    'comment' => 'Name',
                    'after' => 'entity_id'
                ]
            );
    }
}
