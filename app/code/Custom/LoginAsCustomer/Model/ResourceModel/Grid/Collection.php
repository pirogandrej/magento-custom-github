<?php

namespace Custom\LoginAsCustomer\Model\ResourceModel\Grid;

use Custom\LoginAsCustomer\Ui\Component\DataProvider\Document;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;
use Custom\LoginAsCustomer\Model\ResourceModel\LoginAsCustomer\Collection as LoginAsCustomerCollection;

class Collection extends SearchResult
{
    protected $document = Document::class;

    public function __construct
    (
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'custom_login_as_customer',
        $resourceModel = LoginAsCustomerCollection::class
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }
}
