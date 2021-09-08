<?php

declare(strict_types=1);

namespace Perspective\SalesOrders\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\InputException;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterfaceFactory as SearchResultFactory;
use Perspective\SalesOrders\Api\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    private const DEFAULT_PAGE = 1;

    private const DEFAULT_PAGE_SIZE = 20;

    private const PAYMENT_METHOD_FIELD_NAME = 'method';

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SearchResultFactory
     */
    private $searchResultFactory;

    /**
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SearchResultFactory $searchResultFactory
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SearchResultFactory $searchResultFactory

    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        int $page = null,
        int $pageSize = null,
        string $paymentMethod = null) : OrderSearchResultInterface
    {
        $this->validateParameters($page, $pageSize);

        /** @var SearchCriteriaInterface $searchCriteria */
        $searchCriteria = $this->getSearchCriteria($page, $pageSize, $paymentMethod);

        /** @var OrderSearchResultInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();

        $this->collectionProcessor->process($searchCriteria, $searchResult);

        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;

    }

    /**
     * @param int|null $page
     * @param int|null $pageSize
     * @throws InputException
     */
    private function validateParameters(int &$page = null, int &$pageSize = null)
    {
        $page ? : $page = self::DEFAULT_PAGE;
        if ($page < 1) {
            throw new InputException(__('page value must be greater than 0.'));
        }
        $pageSize ? : $pageSize = self::DEFAULT_PAGE_SIZE;
        if ($pageSize < 1) {
            throw new InputException(__('pageSize value must be greater than 0.'));
        }
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @param string|null $paymentMethod
     * @return SearchCriteriaInterface
     */
    private function getSearchCriteria(int $page, int $pageSize, string $paymentMethod = null)
    {
        $this->searchCriteriaBuilder->setCurrentPage($page);
        $this->searchCriteriaBuilder->setPageSize($pageSize);
        if ($paymentMethod) {
            $this->searchCriteriaBuilder->addFilter(self::PAYMENT_METHOD_FIELD_NAME, $paymentMethod);
        }
        return $this->searchCriteriaBuilder->create();
    }

}
