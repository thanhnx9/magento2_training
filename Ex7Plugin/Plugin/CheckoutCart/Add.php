<?php
namespace Magestore\Ex7Plugin\Plugin\CheckoutCart;
class Add extends \Magento\Checkout\Controller\Cart\Add
{

    protected $_url;
    protected $request;

    public function __construct(
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\Request\Http $request
    )
    {
        $this->_url = $url;
        $this->request = $request;
    }

    public function aroundExecute(\Magento\Checkout\Controller\Cart\Add $subject, \Closure $proceed)
    {
        $returnValue = $proceed();
        // We need to check, does the request send from Ajax
        if (!$this->request->isAjax()) {
            // get the url of the checkout page
            $checkoutUrl = $this->_url->getUrl('checkout/index/index');
            // set the url for redirecting
            $returnValue->setUrl($checkoutUrl);
        }
        return $returnValue;
    }
}