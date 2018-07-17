<?php
namespace Magestore\Ex6Event\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\Cookie\PhpCookieManager;
class CustomerLogout implements ObserverInterface
{
    protected $session;
    private $cookieMetadataFactory;
    private $cookieMetadataManager;
    protected $redirect;
    protected $urlBuilder;
    protected $responseFactory;

    public function __construct(
        Session $customerSession,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\App\ResponseFactory $responseFactory
    ) {
        $this->session = $customerSession;
        $this->redirect = $redirect;
        $this->urlBuilder = $urlBuilder;
        $this->responseFactory = $responseFactory;
    }

    private function getCookieManager()
    {
        if (!$this->cookieMetadataManager) {
            $this->cookieMetadataManager = ObjectManager::getInstance()->get(PhpCookieManager::class);
        }
        return $this->cookieMetadataManager;
    }

    private function getCookieMetadataFactory()
    {
        if (!$this->cookieMetadataFactory) {
            $this->cookieMetadataFactory = ObjectManager::getInstance()->get(CookieMetadataFactory::class);
        }
        return $this->cookieMetadataFactory;
    }

    public function execute(Observer $observer)
    {
        $lastCustomerId = $this->session->getId();
        $this->session->logout()->setBeforeAuthUrl($this->redirect->getRefererUrl())
            ->setLastCustomerId($lastCustomerId);
        //delete cookie
        if ($this->getCookieManager()->getCookie('mage-cache-sessid')) {
            $metadata = $this->getCookieMetadataFactory()->createCookieMetadata();
            $metadata->setPath('/');
            $this->getCookieManager()->deleteCookie('mage-cache-sessid', $metadata);
        }
        // redirect to the homepage after logout
        $resultRedirect = $this->responseFactory->create();
        $resultRedirect->setRedirect($this->urlBuilder->getUrl('/'))->sendResponse('200');
        exit();
    }
}