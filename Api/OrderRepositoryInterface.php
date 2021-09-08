<?php

declare(strict_types=1);

namespace Perspective\SalesOrders\Api;

use Magento\Sales\Api\Data\OrderSearchResultInterface;

interface OrderRepositoryInterface
{
    /**
     * @param int|null $page
     * @param int|null $pageSize
     * @param string|null $paymentMethod
     * @return OrderSearchResultInterface Order search result interface.
     */
    public function getList(
        int $page = null,
        int $pageSize = null,
        string $paymentMethod = null) : OrderSearchResultInterface;
}
