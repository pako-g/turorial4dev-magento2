<?php

namespace Tutorial4dev\Easy\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Sales\Setup\SalesSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    protected $logger;
    protected $salesSetupFactory;

    public function __construct(
        SalesSetupFactory $salesSetupFactory,
        \Psr\Log\LoggerInterface $loggerInterface
    ) {
        $this->salesSetupFactory = $salesSetupFactory;
        $this->logger = $loggerInterface;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->logger->info('Upgrade Data Script Running!');
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $this->upgradeToVersionOneZeroOne($setup);
        }

        $setup->endSetup();
    }

    private function upgradeToVersionOneZeroOne(ModuleDataSetupInterface $setup)
    {
        $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);
        $salesSetup->addAttribute('order', 'merchant_note', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'visible' => false,
            'required' => false
        ]);

    }
}
