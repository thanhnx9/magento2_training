<?php
/**
 *  Copyright © 2016 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *
 */
namespace Magestore\Webpos\Model\WebposConfigProvider;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Locale\FormatInterface as LocaleFormat;
/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class DefaultConfigProvider implements ConfigProviderInterface
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;
    /**
     * @var LocaleFormat
     */
    protected $localeFormat;
    /**
     * @var
     */
    protected $_storeManager;


    public function __construct( CheckoutSession $checkoutSession,
                                 LocaleFormat $localeFormat,
                                 \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->checkoutSession=$checkoutSession;
        $this->localeFormat=$localeFormat;
        $this->_storeManager=$storeManager;
    }

    public function getConfig()
    {
        $output['priceFormat'] = $this->localeFormat->getPriceFormat(
            null,
            $this->checkoutSession->getQuote()->getQuoteCurrencyCode()
        );
        $output['storeCode'] = $this->_storeManager->getStore(true)->getCode();

        return $output;
    }
}