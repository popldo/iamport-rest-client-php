<?php

namespace Iamport\RestClient\Enum;

/**
 * Class Endpoint.
 */
class Endpoint extends Enum
{
    public const API_BASE_URL                = 'https://api.iamport.kr';
    public const TOKEN                       = '/users/getToken';
    public const PAYMENTS                    = '/payments/';
    public const PAYMENTS_PREPARE            = '/payments/prepare';
    public const PAYMENTS_STATUS             = '/payments/status/';
    public const PAYMENTS_FIND               = '/payments/find/';
    public const PAYMENTS_FIND_ALL           = '/payments/findAll/';
    public const PAYMENTS_CANCEL             = '/payments/cancel/';
    public const CERTIFICATIONS              = '/certifications/';
    public const CARDS                       = '/cards';
    public const BANKS                       = '/banks';
    public const ESCROW                      = '/escrows/logis/';
    public const KAKAO                       = '/kakao/payment/orders';
    public const PAYCO                       = '/payco/orders/status/';
    public const SBCR_PAYMENTS_ONETIME       = '/subscribe/payments/onetime/';
    public const SBCR_PAYMENTS_AGAIN         = '/subscribe/payments/again/';
    public const SBCR_PAYMENTS_SCHEDULE      = '/subscribe/payments/schedule/';
    public const SBCR_PAYMENTS_UNSCHEDULE    = '/subscribe/payments/unschedule/';
    public const SBCR_CUSTOMERS              = '/subscribe/customers/';
    public const RECEIPT                     = '/receipts/';
    public const RECEIPT_EXTERNAL            = '/receipts/external/';
    public const VBANKS                      = '/vbanks/';
    public const VBANKS_HOLDER               = '/vbanks/holder';
    public const NAVER_PRODUCT_ORDERS        = '/naver/product-orders';
    public const NAVER_CASH_AMOUNT           = '/naver/cash-amount';
    public const NAVER_REVIEWS               = '/naver/reviews';
}
