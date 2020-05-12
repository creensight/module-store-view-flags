<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\StoreViewFlags\Model\Helper;

use CreenSight\Core\Model\Helper\ConfigProvider as CoreConfigProvider;

/**
 * Class ConfigProvider
 * @package CreenSight\StoreViewFlags\Model\Helper
 */
class ConfigProvider
{
    /**
     * @var string
     */
    const XML_PATH_GENERAL_ENABLED = 'store_view_flags/general/enabled';
    const XML_PATH_GENERAL_HIDE_STORE_NAME = 'store_view_flags/general/hide_store_name';

    /**
     * @var string
     */
    const XML_PATH_FLAG_IMAGE = 'store_view_flags/flag/image';
    const XML_PATH_FLAG_WIDTH = 'store_view_flags/flag/width';
    const XML_PATH_FLAG_HEIGHT = 'store_view_flags/flag/height';

    /**
     * @var CoreConfigProvider
     */
    protected $configProvider;

    /**
     * ConfigProvider constructor.
     *
     * @param CoreConfigProvider $configProvider
     */
    public function __construct(
        CoreConfigProvider $configProvider
    ) {
        $this->configProvider = $configProvider;
    }

    /**
     * @param string $path
     * @param number $storeId
     * @return mixed
     */
    public function execute($path, $storeId = null)
    {
        return $this->configProvider->execute($path, $storeId);
    }
}
