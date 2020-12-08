<?php
namespace Iamport\Tests;

use PHPUnit\Framework\TestCase;
use Iamport\Iamport;
use Exception;

class IamportTest extends TestCase {

    public function testCancel() {
        $iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

        #3. 주문취소
        $result = $iamport->cancel(array(
            'imp_uid'		=> '거래 건의 imp_uid', 		//merchant_uid에 우선한다
            'merchant_uid'	=> '거래 건의 merchant_uid', 	//imp_uid 또는 merchant_uid가 지정되어야 함
            'amount' 		=> 1000,					//amount가 생략되거나 0이면 전액취소. 금액지정이면 부분취소(PG사 정책별, 결제수단별로 부분취소가 불가능한 경우도 있음)
            'reason'		=> '취소테스트',				//취소사유
            'refund_holder' => '환불될 가상계좌 예금주', 		//이용 중인 PG사에서 가상계좌 환불 기능을 제공하는 경우. 일반적으로 특약 계약이 필요
            'refund_bank'	=> '환불될 가상계좌 은행코드',
            'refund_account'=> '환불될 가상계좌 번호'
        ));

        if ( $result->success ) {
            /**
            *	IamportPayment 를 가리킵니다. __get을 통해 API의 Payment Model의 값들을 모두 property처럼 접근할 수 있습니다.
            *	참고 : https://api.iamport.kr/#!/payments/cancelPayment 의 Response Model
            */
            $payment_data = $result->data;
        
            echo '## 취소후 결제정보 출력 ##';
            echo '결제상태 : ' 		. $payment_data->status;
            echo '결제금액 : ' 		. $payment_data->amount;
            echo '취소금액 : ' 		. $payment_data->cancel_amount;
            echo '결제수단 : ' 		. $payment_data->pay_method;
            echo '결제된 카드사명 : ' 	. $payment_data->card_name;
            echo '결제(취소) 매출전표 링크 : '	. $payment_data->receipt_url;
            //등등 __get을 선언해 놓고 있어 API의 Payment Model의 값들을 모두 property처럼 접근할 수 있습니다.
        } else {
            error_log($result->error['code']);
            error_log($result->error['message']);
        }
    }

    public function testImportUid(){
        $iamport = new Iamport('YOUR_IMP_REST_API_KEY', 'YOUR_IMP_REST_API_SECRET');

        #1. imp_uid 로 주문정보 찾기(아임포트에서 생성된 거래고유번호)
        $result = $iamport->findByImpUID('your_imp_uid'); //IamportResult 를 반환(success, data, error)

        if ( $result->success ) {
            /**
            *	IamportPayment 를 가리킵니다. __get을 통해 API의 Payment Model의 값들을 모두 property처럼 접근할 수 있습니다.
            *	참고 : https://api.iamport.kr/#!/payments/getPaymentByImpUid 의 Response Model
            */
            $payment_data = $result->data;

            echo '## 결제정보 출력 ##';
            echo '가맹점 주문번호 : ' 	. $payment_data->merchant_uid;
            echo '결제상태 : ' 		. $payment_data->status;
            echo '결제금액 : ' 		. $payment_data->amount;
            echo '결제수단 : ' 		. $payment_data->pay_method;
            echo '결제된 카드사명 : ' 	. $payment_data->card_name;
            echo '결제 매출전표 링크 : '	. $payment_data->receipt_url;

            /**
            *	IMP.request_pay({
            *		custom_data : {my_key : value}
            *	});
            *	와 같이 custom_data를 결제 건에 대해서 지정하였을 때 정보를 추출할 수 있습니다.(서버에는 json encoded형태로 저장합니다)
            */
            echo 'Custom Data :'	. $payment_data->getCustomData('my_key');

            # 내부적으로 결제완료 처리하시기 위해서는 (1) 결제완료 여부 (2) 금액이 일치하는지 확인을 해주셔야 합니다.
            $amount_should_be_paid = 1004;
            if ( $payment_data->status === 'paid' && $payment_data->amount === $amount_should_be_paid ) {
                //TODO : 결제성공 처리
            }

        } else {
            error_log($result->error['code']);
            error_log($result->error['message']);
        }
    }
}