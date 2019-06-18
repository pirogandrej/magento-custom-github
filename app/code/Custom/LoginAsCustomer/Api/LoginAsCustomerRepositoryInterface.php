<?php

namespace Custom\LoginAsCustomer\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Custom\LoginAsCustomer\Api\Data\LoginAsCustomerInterface;

interface LoginAsCustomerRepositoryInterface
{
    public function save(
        LoginAsCustomerInterface $loginAsCustomerId
    );

    public function getById($loginAsCustomerId);

    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    public function delete(
        LoginAsCustomerInterface $loginAsCustomerId
    );

    public function deleteById($loginAsCustomerId);
}
