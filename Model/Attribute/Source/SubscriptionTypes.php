<?php

namespace Subscription\Subscription\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class SubscriptionTypes
 *
 * @package Subscription\Subscription\Model\Attribute\Source
 */
class SubscriptionTypes extends AbstractSource
{
    const TYPE1 = 'type1';
    const TYPE2 = 'type2';
    const TYPE3 = 'type3';

    /**
     * Get All Options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                    ['label' => __('TYPE1'), 'value' => self::TYPE1],
                    ['label' => __('TYPE2'), 'value' => self::TYPE2],
                    ['label' => __('TYPE3'), 'value' => self::TYPE3],
            ];
        }
        return $this->_options;
    }
}
