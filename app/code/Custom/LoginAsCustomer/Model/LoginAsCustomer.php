<?php

namespace Custom\LoginAsCustomer\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Stdlib\DateTime as DT;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Math\Random;
use Magento\Checkout\Model\Cart;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Custom\LoginAsCustomer\Api\Data\LoginAsCustomerInterface;

class LoginAsCustomer extends AbstractModel implements LoginAsCustomerInterface
{

    const TIME_FRAME = 30;

    protected $eventPrefix = 'custom_loginascustomer';

    protected $eventObject = 'loginascustomer_login';

    protected $customerFactory;

    protected $customerSession;

    protected $customer;

    protected $dateTime;

    protected $random;

    protected $cart;

    private $dt;

    public function __construct(
        Context $context,
        Registry $registry,
        CustomerFactory $customerFactory,
        Session $customerSession,
        DT $dt,
        DateTime $dateTime,
        Random $random,
        Cart $cart,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
        $this->dateTime = $dateTime;
        $this->random = $random;
        $this->cart = $cart;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->dt = $dt;
    }
    protected function _construct()
    {
        $this->_init('Custom\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer');
    }

    public function getLoginAsCustomerId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function setLoginAsCustomerId($loginAsCustomerId)
    {
        return $this->setData(self::ENTITY_ID, $loginAsCustomerId);
    }

    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function getCustomerEmail()
    {
        return $this->getData(self::CUSTOMER_EMAIL);
    }

    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }

    public function getAdminUsername()
    {
        return $this->getData(self::ADMIN_USERNAME);
    }

    public function setAdminUsername($adminUsername)
    {
        return $this->setData(self::ADMIN_USERNAME, $adminUsername);
    }

    public function getAdminId()
    {
        return $this->getData(self::ADMIN_ID);
    }

    public function setAdminId($adminId)
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    public function getAdminName()
    {
        return $this->getData(self::ADMIN_NAME);
    }

    public function setAdminName($adminName)
    {
        return $this->setData(self::ADMIN_NAME, $adminName);
    }

    public function getLoginFrom()
    {
        return $this->getData(self::LOGIN_FROM);
    }

    public function setLoginFrom($loginFrom)
    {
        return $this->setData(self::LOGIN_FROM, $loginFrom);
    }

    public function getSecret()
    {
        return $this->getData(self::SECRET);
    }

    public function setSecret($secret)
    {
        return $this->setData(self::SECRET, $secret);
    }

    public function getUsed()
    {
        return $this->getData(self::USED);
    }

    public function setUsed($used)
    {
        return $this->setData(self::USED, $used);
    }

    public function getIp()
    {
        return $this->getData(self::IP);
    }

    public function setIp($ip)
    {
        return $this->setData(self::IP, $ip);
    }

    public function getLoggedAt()
    {
        return $this->getData(self::LOGGED_AT);
    }

    public function setLoggedAt($loggedAt)
    {
        return $this->setData(self::LOGGED_AT, $loggedAt);
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function loadNotUsed($secret)
    {
        return $this->getCollection()
            ->addFieldToFilter('secret', $secret)
            ->addFieldToFilter('used', 0)
            ->addFieldToFilter('logged_at', ['gt' => $this->getDateTimePoint()])
            ->setPageSize(1)
            ->getFirstItem();
    }

    public function deleteNotUsed()
    {
        $resource = $this->getResource();
        $resource->getConnection()->delete(
            $resource->getTable('custom_login_as_customer'),
            [
                'logged_at < ?' => $this->getDateTimePoint(),
                'used = ?' => 0,
            ]
        );
    }

    protected function getDateTimePoint()
    {
        // return the difference between current time and -5 second and return the compare time
        $diff = $this->dateTime->gmtTimestamp() - self::TIME_FRAME;
        $date = $this->dt->formatDate($diff);
        return $date;
    }

    public function getCustomer()
    {
        if ($this->customer === null) {
            $this->customer = $this->customerFactory->create()
                ->load($this->getCustomerId());
        }
        return $this->customer;
    }

    public function authenticateCustomer()
    {
        if ($this->customerSession->getId()) {
            /* Logout if logged in */
            $this->customerSession->logout();
        } else {
            /* Remove items from guest cart */
            foreach ($this->cart->getQuote()->getAllVisibleItems() as $item) {
                $this->cart->removeItem($item->getId());
            }
            $this->cart->save();
        }

        $customer = $this->getCustomer();
        if (!$customer->getId()) {
            throw new NoSuchEntityException(__("Customer are no longer exist."), 1);
        }
        if ($this->customerSession->loginById($customer->getId())) {
            $this->customerSession->regenerateId();
            $this->customerSession->setLoggedAsCustomerAdmindId(
                $this->getAdminId()
            );
        }

        /* Save quote */
        $this->cart->getQuote()->getBillingAddress();
        $this->cart->getQuote()->getShippingAddress();
        $this->cart
            ->getQuote()
            ->setCustomer($this->customerSession->getCustomerDataObject())
            ->setCustomerGroupId($customer->getGroupId())
            ->setTotalsCollectedFlag(false)
            ->collectTotals();
        $this->cart->getQuote()->save();
        $cur_time = $this->dateTime->gmtTimestamp();
        $this->setUpdated_at($cur_time)->save();
        $this->setUsed(1)->save();
        return $customer;
    }

    public function generate($adminId, $adminName, $adminUsername, $loginFrom, $customerEmail, $ip)
    {
        return $this->setData([
            'customer_id' => $this->getCustomerId(),
            'admin_id' => $adminId,
            'customer_email' => $customerEmail,
            'admin_username' => $adminUsername,
            'admin_name' => $adminName,
            'login_from' => $loginFrom,
            'ip' => $ip,
            'updated_at' => $this->dateTime->gmtTimestamp(),
            'secret' => $this->random->getRandomString(64),
            'used' => 0,
            'logged_at' => $this->dateTime->gmtTimestamp(),
        ])->save();
    }
}
