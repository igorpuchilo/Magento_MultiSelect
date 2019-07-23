<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Task\Shipment\Model\Attribute\Source;

use Magento\Store\Model\StoreManagerInterface;


class Shipment extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
//    /**
//     * Options array
//     *
//     * @var array
//     */
    private $options;
//    /**
//     * Store manager
//     *
//     * @var StoreManagerInterface
//     */
    private $storeManager;
//    /**
//     * @param StoreManagerInterface $storeManager Store Manager
//     */
    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }
//    /**
//     * Get all options
//     *
//     * @return array
//     */
    public function getAllOptions()
    {
        $storeId = $this->getAttribute()->getStoreId();
        if ($storeId === null) {
            $storeId = $this->storeManager->getStore()->getId();
        }
        if (!is_array($this->_options)) {
            $this->_options = [];
        }
        if (!isset($this->_options[$storeId])) {
            $this->_options[$storeId] = [
                ['label' => 'United Kingdom of Great Britain and Northern Ireland', 'value' => 'UK'],
                ['label' => 'United States of America', 'value' => 'USA'],
                ['label' => 'Republic of Belarus', 'value' => 'BLR'],
                ['label' => 'Russian Federation', 'value' => 'RU'],
                ['label' => 'Asia', 'value' => 'Asia'],
                ['label' => 'Australia', 'value' => 'AU'],
            ];
        }
        return $this->_options[$storeId];
    }
    /**
     * Get a text for option value
     *
     * @param  string|int $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        $isMultiple = false;
        if (strpos($value, ',') !== false) {
            $isMultiple = true;
            $value = explode(',', $value);
        }
        if (!is_array($value)) {
            $value = [$value];
        }
        $options = array_intersect_key(
            $this->getAllOptions(),
            array_flip($value)
        );
        if ($isMultiple) {
            $values = [];
            foreach ($options as $item) {
                if (in_array($item['value'], $value)) {
                    $values[] = $item['label'];
                }
            }
            return $values;
        }
        foreach ($options as $item) {
            if ($item['value'] == $value) {
                return $item['label'];
            }
        }
        return false;
    }
}
