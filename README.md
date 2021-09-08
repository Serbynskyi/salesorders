# Magento 2 Sales orders api

The module implements the sales orders api.

## Endpoint:

GET /rest/V1/salesOrders/

## Parameters:

PARAMETER  | DEFAULT VALUE | DESCRIPTION
--- | --- | --- 
paymentMethod | --- | Payment method
page | 1 | Current page
pageSize | 20 | Page size

All parameters are not required. If parameter paymentMethod is not provided, response will include orders with all payment methods.
