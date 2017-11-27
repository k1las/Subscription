<?php

namespace Subscription\Subscription\Plugin\Quote;

use Subscription\Subscription\Model\Attribute\Source\SubscriptionTypes as SubscriptionTypes;

/**
 * Class GetItemsCollection
 *
 * @package Subscription\Subscription\Plugin\Quote
 */
class GetItemsCollection
{
    /**
     * If Product Subscription Type = type3, Quote Item Product Tax Class Id Will Be Changed To 0
     * @param $subject
     * @param $collection
     * @return mixed
     */
    public function afterGetItemsCollection($subject, $collection)
    {
        foreach ($collection as $item) {
            $product = $item->getProduct();
            if ($product->getSubscriptionType() === SubscriptionTypes::TYPE3) {
                $product->setTaxClassId('0');
            }
        }

        return $collection;
    }
}

