<?php

namespace Iamport\RestClient\Request\Subscribe;

use Iamport\RestClient\Enum\Endpoint;
use Iamport\RestClient\Request\RequestBase;
use Iamport\RestClient\Request\RequestTrait;
use Iamport\RestClient\Response;
use InvalidArgumentException;

/**
 * Class SubscribeInquiry.
 *
 * @property string $merchant_uid
 * @property string $customer_uid
 * @property string $page
 * @property string $from
 * @property string $to
 * @property string $schedule_status
 */
class SubscribeInquiry extends RequestBase
{
    use RequestTrait;

    /**
     * @var string 결제예약에 사용된 가맹점 거래 고유번호
     */
    protected $merchant_uid;

    /**
     * @var array 결제예약에 사용된 가맹점 거래 고유번호
     */
    public $customer_uid;

    /**
     * @var int 페이지
     */
    protected $page = 1;

    /**
     * @var mixed 조회 시작시각
     */
    protected $from;

    /**
     * @var mixed 조회 시작시각
     */
    protected $to;

    /**
     * @var string 예약상태. 누락되면 모든 상태의 예약내역 조회
     */
    protected $schedule_status;

    /**
     * SubscribeCustomer constructor.
     */
    public function __construct()
    {
    }

    /**
     * 예약 거래주문번호(merchant_uid)로 결제예약정보를 조회.
     *
     * @param string $merchant_uid
     *
     * @return SubscribeInquiry
     */
    public static function withMerchantUid(string $merchant_uid)
    {
        $instance                = new self();
        $instance->merchant_uid  = $merchant_uid;
        $instance->responseClass = Response\Schedule::class;
        $instance->instanceType  = 'withMerchantUid';
        $instance->unsetArray([
            'customer_uid', 'page', 'from', 'to', 'schedule-status',
        ]);

        return $instance;
    }

    /**
     * customer_uid별 결제예약목록을 조회.
     * TODO: api docs에 내용과 응답 내역이 달라 확인 필요.
     *
     * @param string $customer_uid
     * @param string $from
     * @param string $to
     *
     * @return SubscribeInquiry
     */
    public static function withCustomerUid(string $customer_uid, string $from, string $to)
    {
        date_default_timezone_set('Asia/Seoul');
        $instance                 = new self();
        $instance->customer_uid   = $customer_uid;
        $instance->from           = strtotime(date($from));
        $instance->to             = strtotime(date($to));
        $instance->responseClass  = Response\Schedule::class;
        $instance->isCollection   = true;
        $instance->instanceType   = 'withCustomerUid';
        unset($instance->merchant_uid);

        return $instance;
    }

    /**
     * @param string $page
     */
    public function setPage(string $page): void
    {
        $this->page = $page;
    }

    /**
     * @param string $schedule_status
     */
    public function setScheduleStatus(string $schedule_status): void
    {
        if (!in_array($schedule_status, ['scheduled', 'executed', 'revoked'])) {
            throw new InvalidArgumentException(
                '허용되지 않는 schedule_status 값 입니다. [ 가능한 값은 scheduled, executed, revoked 입니다. ]'
            );
        }
        $this->schedule_status = $schedule_status;
    }

    /**
     * 예약 거래주문번호(merchant_uid)로 결제예약정보를 조회
     * [GET] /subscribe/payments/schedule/{merchant_uid}.
     *
     * customer_uid별 결제예약목록을 조회
     * [GET] /subscribe/payments/schedule/customers/{customer_uid}
     *
     * @return string
     */
    public function path(): string
    {
        switch ($this->instanceType) {
            case 'withMerchantUid':
                return Endpoint::SBCR_PAYMENTS_SCHEDULE . $this->merchant_uid;
                break;
            case 'withCustomerUid':
                return Endpoint::SBCR_PAYMENTS_SCHEDULE . 'customers/' . $this->customer_uid;
                break;
            default:
                return '';
        }
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        switch ($this->instanceType) {
            case 'withMerchantUid':
                return  [];
                break;
            case 'withCustomerUid':
                return [
                    'query' => [
                        'page'            => $this->page,
                        'from'            => $this->from,
                        'to'              => $this->to,
                        'schedule-status' => $this->schedule_status,
                    ],
                ];
                break;
            default:
                return [];
        }
    }

    /**
     * @return string
     */
    public function verb(): string
    {
        return 'GET';
    }
}
