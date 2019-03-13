<?php

namespace Tutorial4dev\Easy\Setup;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    const CUSTOMER_VIP = 'customer_vip';

    protected $customerSetupFactory;
    protected $logger;

    public function __construct(CustomerSetupFactory $customerSetupFactory, \Psr\Log\LoggerInterface $loggerInterface)
    {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->logger = $loggerInterface;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        $this->logger->info('Install Data Script Running!');

        $setup->startSetup();

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, self::CUSTOMER_VIP, [
            'type' => 'int',
            'label' => 'Customer Vip',
            'input' => 'select',
            'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
            'default' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::VALUE_NO,
            'required' => false,
            'sort_order' => 1,
            'position' => 200,
            'system' => false,
            'visible' => true,
            'global' =>\Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'filterable' => false,
            'comparable' => false,
            'searchable' => true,

        ]);

        $customerVipAttr = $customerSetup
            ->getEavConfig()
            ->getAttribute(
                \Magento\Customer\Model\Customer::ENTITY,
                self:: CUSTOMER_VIP
            );

        $forms = [
            'adminhtml_customer',
            'checkout_register',
            'customer_account_create',
            'customer_account_edit',
            'adminhtml_checkout'
        ];

        $customerVipAttr->setData('used_in_forms', $forms);

        $customerVipAttr->save($customerVipAttr);

        $setup->endSetup();
    }
}
