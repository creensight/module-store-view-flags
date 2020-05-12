<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\StoreViewFlags\Plugin\Backend;

use Magento\Backend\Block\System\Store\Grid\Render\Store;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;
use CreenSight\StoreViewFlags\Model\Helper\ConfigProvider;
use CreenSight\StoreViewFlags\Model\Helper\ConfigProvider\FlagImageUrl;

/**
 * Class ShowFlagOnGrid
 *
 * @package CreenSight\StoreviewFlag\Plugin
 */
class ShowFlagOnGrid
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
     * ShowFlagOnGrid constructor
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
     * AroundRender
     *
     * @param Store $subject
     * @param callable $proceed
     * @param DataObject $row
     * @return string|null
     * @throws NoSuchEntityException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundRender(Store $subject, callable $proceed, DataObject $row)
    {
        if (!$this->configProvider->execute(ConfigProvider::XML_PATH_GENERAL_ENABLED)) {
            return $proceed($row);
        }

        if (!$row->getData($subject->getColumn()->getIndex())) {
            return null;
        }

        $imageUrl = $this->flagImageUrl->execute($row->getStoreId());
        if (!$imageUrl) {
            return $proceed($row);
        }

        $imageUrl = '<img class="cs_flag" src="' . $imageUrl . '">';

        return $imageUrl .
            '<a title="' . __(
                'Edit Store View'
            ) . '"
            href="' .
            $subject->getUrl('adminhtml/*/editStore', ['store_id' => $row->getStoreId()]) .
            '">' .
            $subject->escapeHtml($row->getData($subject->getColumn()->getIndex())) .
            '</a><br />' .
            '(' . __('Code') . ': ' . $row->getStoreCode() . ')';
    }
}
