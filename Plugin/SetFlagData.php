<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\StoreViewFlags\Plugin;

use CreenSight\StoreViewFlags\Model\Helper\ConfigProvider;
use CreenSight\StoreViewFlags\Model\Helper\ConfigProvider\FlagImageUrl;

/**
 * Class SetFlagData
 *
 * @package CreenSight\StoreViewFlags\Plugin
 */
class SetFlagData
{
    /**
     * @var ConfigProvider
     */
    protected $configProvider;

    /**
     * @var FlagImageUrl
     */
    protected $flagImageUrl;

    /**
     * SetFlagData constructor.
     *
     * @param ConfigProvider $configProvider
     * @param FlagImageUrl $flagImageUrl
     */
    public function __construct(
        ConfigProvider $configProvider,
        FlagImageUrl $flagImageUrl
    ) {
        $this->configProvider = $configProvider;
        $this->flagImageUrl = $flagImageUrl;
    }

    /**
     * Plugin After
     *
     * @param \Magento\Store\Block\Switcher $subject
     * @param \Magento\Store\Block\Switcher $result
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetStores(\Magento\Store\Block\Switcher $subject, $result)
    {
        $data = [];

        if ($this->configProvider->execute(ConfigProvider::XML_PATH_GENERAL_ENABLED)) {
            $storeIds = array_keys($result);
            foreach ($storeIds as $storeId) {
                if ($imageUrl = $this->flagImageUrl->execute($storeId)) {
                    $data[$storeId] = [
                        'width'  => $this->configProvider->execute(ConfigProvider::XML_PATH_FLAG_WIDTH, $storeId),
                        'height' => $this->configProvider->execute(ConfigProvider::XML_PATH_FLAG_HEIGHT, $storeId),
                        'image'  => $imageUrl,
                        'hide_store_name' => $this->configProvider->execute(ConfigProvider::XML_PATH_GENERAL_HIDE_STORE_NAME, $storeId)
                    ];
                }
            }
        }

        $subject->setData('store_view_flag', $data);

        return $result;
    }
}
