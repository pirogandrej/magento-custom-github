<?php

namespace Custom\LoginAsCustomer\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Store\Model\StoreManagerInterface;
use Custom\LoginAsCustomer\Api\LoginAsCustomerRepositoryInterface;
use Custom\LoginAsCustomer\Api\Data\LoginAsCustomerInterfaceFactory;
use Custom\LoginAsCustomer\Api\Data\LoginAsCustomerSearchResultsInterfaceFactory;
use Custom\LoginAsCustomer\Api\Data\LoginAsCustomerInterface;
use Custom\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer as ResourceLoginAsCustomer;
use Custom\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer\CollectionFactory as LoginAsCustomerCollectionFactory;

class LoginAsCustomerRepository implements LoginAsCustomerRepositoryInterface
{
    protected $dataObjectProcessor;

    protected $dataObjectHelper;

    protected $loginAsCustomerCollectionFactory;

    protected $dataLoginAsCustomerFactory;

    protected $searchResultsFactory;

    protected $loginAsCustomerFactory;

    protected $resource;

    private $storeManager;

    public function __construct(
        ResourceLoginAsCustomer $resource,
        LoginAsCustomerFactory $loginAsCustomerFactory,
        LoginAsCustomerInterfaceFactory $dataLoginAsCustomerFactory,
        LoginAsCustomerCollectionFactory $loginAsCustomerCollectionFactory,
        LoginAsCustomerSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->loginAsCustomerFactory = $loginAsCustomerFactory;
        $this->loginAsCustomerCollectionFactory = $loginAsCustomerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataLoginAsCustomerFactory = $dataLoginAsCustomerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    public function save(
        LoginAsCustomerInterface $loginAsCustomer
    ) {
        try {
            $loginAsCustomer->getResource()->save($loginAsCustomer);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the loginAsCustomer: %1',
                $exception->getMessage()
            ));
        }
        return $loginAsCustomer;
    }

    public function getById($loginAsCustomerId)
    {
        $loginAsCustomer = $this->loginAsCustomerFactory->create();
        $loginAsCustomer->getResource()->load($loginAsCustomer, $loginAsCustomerId);
        if (!$loginAsCustomer->getId()) {
            throw new NoSuchEntityException(__('loginAsCustomer with id "%1" does not exist.', $loginAsCustomerId));
        }
        return $loginAsCustomer;
    }

    public function getList(
        SearchCriteriaInterface $criteria
    ) {
        $collection = $this->loginAsCustomerCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    public function delete(
        LoginAsCustomerInterface $loginAsCustomer
    ) {
        try {
            $loginAsCustomer->getResource()->delete($loginAsCustomer);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the loginAsCustomer: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById($loginAsCustomerId)
    {
        return $this->delete($this->getById($loginAsCustomerId));
    }
}
