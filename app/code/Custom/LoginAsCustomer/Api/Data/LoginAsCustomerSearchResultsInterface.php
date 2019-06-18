<?php

namespace Custom\LoginAsCustomer\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface LoginAsCustomerSearchResultsInterface extends SearchResultsInterface
{
    public function getItems();

    public function setItems(array $items);
}
