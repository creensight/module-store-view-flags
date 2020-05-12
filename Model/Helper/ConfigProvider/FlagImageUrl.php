<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\StoreViewFlags\Model\Helper\ConfigProvider;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use CreenSight\StoreViewFlags\Model\Helper\ConfigProvider;

/**
 * Class FlagImageUrl
 * @package CreenSight\StoreViewFlags\Model\Helper
 */
class FlagImageUrl
{
    /**
     * @var string
     */
    const FLAG_DIRECTORY = 'store_view_flags';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ConfigProvider
     */
    protected $configProvider;

    /**
     * ConfigProvider constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ConfigProvider $configProvider
    ) {
        $this->storeManager = $storeManager;
        $this->configProvider = $configProvider;
    }

    /**
     * @param number $storeId
     * @return string
     * @throws NoSuchEntityException
     */
    public function execute($storeId = null)
    {
        $image = $this->configProvider->execute(ConfigProvider::XML_PATH_FLAG_IMAGE, $storeId);

        if ($image != '') {
            return $this->storeManager->getStore($storeId)
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . self::FLAG_DIRECTORY . '/' . $image;
        }

        return false;
    }
}
