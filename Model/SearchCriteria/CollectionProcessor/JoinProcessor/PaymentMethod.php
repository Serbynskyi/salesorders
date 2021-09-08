<?php

declare(strict_types=1);

namespace Perspective\SalesOrders\Model\SearchCriteria\CollectionProcessor\JoinProcessor;

use Magento\Framework\Api\SearchCriteria\CollectionProcessor\JoinProcessor\CustomJoinInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection\AbstractDb;

class PaymentMethod implements CustomJoinInterface
{
    private const SALES_ORDER_PAYMENT_TABLE_NAME = 'sales_order_payment';

    /**
     * @var ResourceConnection
     */
    private $connection;

    /**
     * @param ResourceConnection $connection
     */
    public function __construct(ResourceConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function apply(AbstractDb $collection)
    {
        $collection->getSelect()->join(
            ['sop' => $this->connection->getTableName(self::SALES_ORDER_PAYMENT_TABLE_NAME)],
            'sop.parent_id = main_table.entity_id',
            ['method']
        );

        return true;
    }
}
