<?php

namespace Custom\LoginAsCustomer\Api\Data;

interface LoginAsCustomerInterface
{

    const CUSTOMER_ID = 'customer_id';
    const ENTITY_ID = 'entity_id';
    const LOGGED_AT = 'logged_at';
    const ADMIN_NAME = 'admin_name';
    const IP = 'ip';
    const USED = 'used';
    const CUSTOMER_EMAIL = 'customer_email';
    const SECRET = 'secret';
    const ADMIN_USERNAME = 'admin_username';
    const LOGIN_FROM = 'login_from';
    const ADMIN_ID = 'admin_id';
    const UPDATED_AT = 'updated_at';

    public function getLoginAsCustomerId();

    public function setLoginAsCustomerId($loginAsCustomerId);

    public function getCustomerId();

    public function setCustomerId($customerId);

    public function getCustomerEmail();

    public function setCustomerEmail($customerEmail);

    public function getAdminUsername();

    public function setAdminUsername($adminUsername);

    public function getAdminId();

    public function setAdminId($adminId);

    public function getAdminName();

    public function setAdminName($adminName);

    public function getLoginFrom();

    public function setLoginFrom($loginFrom);

    public function getSecret();

    public function setSecret($secret);

    public function getUsed();

    public function setUsed($used);

    public function getIp();

    public function setIp($ip);

    public function getLoggedAt();

    public function setLoggedAt($loggedAt);

    public function getUpdatedAt();

    public function setUpdatedAt($updatedAt);
}
