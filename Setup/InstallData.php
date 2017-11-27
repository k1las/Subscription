<?php

namespace Subscription\Subscription\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Subscription\Subscription\Model\Attribute\Source\SubscriptionTypes as Source;
use Magento\Eav\Api\Data\AttributeSetInterface;
use Magento\Eav\Api\AttributeSetManagementInterface;


/**
 * Class InstallData
 *
 * @package Subscription\Subscription\Setup
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * @var AttributeSetInterface
     */
    protected $attributeSet;

    /**
     * @var AttributeSetManagementInterface
     */
    protected $attributeSetManagement;

    /**
     * InstallData constructor.
     *
     * @param EavSetupFactory                 $eavSetupFactory
     * @param AttributeSetInterface           $attributeSet
     * @param AttributeSetManagementInterface $attributeSetManagement
     */
    public function __construct(EavSetupFactory $eavSetupFactory, AttributeSetInterface $attributeSet, AttributeSetManagementInterface $attributeSetManagement)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSet = $attributeSet;
        $this->attributeSetManagement = $attributeSetManagement;
    }

    /**
     * Install Data
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        /**
         * @var $eavSetup EavSetup
         */
        $eavSetup = $this->eavSetupFactory->create();
        $productEntityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetName = 'subscription';
        $attributeName = $attributeSetName . '_type';
        $defaultAttributeSetId = $eavSetup->getDefaultAttributeSetId($productEntityTypeId);

        $attributeSetModel = $this->attributeSet
                ->setAttributeSetId(null)
                ->setEntityTypeId($productEntityTypeId)
                ->setAttributeSetName($attributeSetName);

        $attributeSet = $this->attributeSetManagement->create($productEntityTypeId, $attributeSetModel, $defaultAttributeSetId)
                ->save();

        $eavSetup->addAttribute($productEntityTypeId,
                $attributeName,
                [
                        'type' => 'varchar',
                        'label' => 'Subscription Type',
                        'input' => 'select',
                        'source' => Source::class,
                        'required' => false,
                        'sort_order' => 50,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'is_used_in_grid' => false,
                        'is_visible_in_grid' => false,
                        'is_filtrable_in_grid' => false,
                        'visible' => true,
                        'visible_on_front' => true,
                        'user_defined' => true,
                ]
        );

        $eavSetup->addAttributeToSet(
                $productEntityTypeId,
                $attributeSet->getAttributeSetId(),
                $eavSetup->getDefaultAttributeGroupId($productEntityTypeId,
                        $attributeSet->getAttributeSetId()),
                $eavSetup->getAttributeId($productEntityTypeId, $attributeName), 10
        );
        $setup->endSetup();
    }
}
