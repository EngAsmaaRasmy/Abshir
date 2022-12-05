<?php
namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    public function PaymentInquiry()
    {
         $ref_num = Request()->ref_num;

        // $data = '{"PaymentInquiryV4RequestMessage":{"RefNum": "333333" }}';
        $data = '{"PaymentInquiryV4RequestMessage":{"RefNum": "' . $ref_num . '" }}';

        $ch = curl_init('https://b2b.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V4/PaymentInquiry');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSLCERT, '/home/hmfhmf/certificate/crt.crt');
        curl_setopt($ch, CURLOPT_SSLKEY, '/home/hmfhmf/certificate/key.key');
        curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-ClientCode: 73386352107'
        ));

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $result = curl_exec($ch);

        if (curl_errno($ch))
        {
            $error_msg = curl_error($ch);
            echo $error_msg;
        }

        $result = json_decode($result, true);

        // return ($result);
        if (isset($result['PaymentInquiryResponseMessage']))
        {
            return response()->json(['status' => true,

            'message' => 'تم الدفع بنجاح']);
        }
        else
        {
            return response()
                ->json(['status' => false,

            'message' => 'يرجى التحقق من الدفع']);

        }

    }

    public function DirectPaymentAuthorize()
    {
        $user = Request()->user();
        $mobile = Request()->mobile;

        // $mobile = $user->mobile;
        $data = '{
                    "DirectPaymentAuthorizeV4RequestMessage": {
                        "BranchID": "1",
                        "TellerID": "1",
                        "DeviceID": "790",
                        "RefNum": "9843244287",
                        "BillNumber": "1000",
                        "MobileNo": "' . $mobile . '",
                        "Amount":"1.00",
                        "MerchantNote": "MUKAFAAT"
                    }
                }';

        $ch = curl_init('https://test.b2b.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V3/DirectPaymentAuthorize');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSLCERT, '/home/hmfhmf/certificate/crt.crt');
        curl_setopt($ch, CURLOPT_SSLKEY, '/home/hmfhmf/certificate/key.key');
        curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-ClientCode: 76107320878'
        ));

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $result = curl_exec($ch);

        if (curl_errno($ch))
        {
            $error_msg = curl_error($ch);
            return $error_msg;
        }

         ($result);
        $result = json_decode($result, true);
        
        return $result;



        if (isset($result['DirectPaymentAuthorizeV4ResponseMessage']['STCPayPmtReference']))
        {
            return response()->json(['status' => true, 'data' => ['ref_num' => $result['DirectPaymentAuthorizeV4ResponseMessage']['STCPayPmtReference']], 'message' => 'تم إنشاء الدفعه برجاء دفعها عن طريق STC']);
        }
        else
        {
            return response()->json(['status' => false,

            'message' => 'هذا الرقم غير مسجل لدى STC']);

        }

    }

    public function testapi()
    {
        // 	    $ref_num = Request()->ref_num ;
        // 	    $data = '{"PaymentInquiryV4RequestMessage":{"RefNum": "'.$ref_num.'" }}';
        // 				$ch = curl_init('https://b2b.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V4/PaymentInquiry');
        // 				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // 				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //                 curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        //                 curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        //                 curl_setopt($ch, CURLOPT_SSLCERT, '/home/hmfhmf/certificate/crt.crt');
        //                 curl_setopt($ch, CURLOPT_SSLKEY, '/home/hmfhmf/certificate/key.key');
        //                 curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // 				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //                     'Content-Type: application/json',
        //                     'X-ClientCode: 73386352107'
        //                     )
        // 				);
        // 				$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        

        // 				$result = curl_exec($ch);
        //                 if (curl_errno($ch)) {
        //                   $error_msg = curl_error($ch);
        //                   echo $error_msg;
        //                 }
        //                 $result = json_decode($result, true);
        

        // 	    if(isset($result['PaymentInquiryResponseMessage'])){
        // 	    return response()->json([
        //     'status' =>true,
        

        //     'message' => 'تم الدفع بنجاح'
        //     ]);
        // }else{
        //     	    return response()->json([
        //     'status' =>false,
        

        //     'message' => 'يرجى التحقق من الدفع'
        //     ]);
        // }
        

        $user = Request()->user();
        // $mobile =  '996'.substr($user->mobile, 1);
        $mobile = '00966551938225';
        $data = '{
                    "DirectPaymentAuthorizeV4RequestMessage": {
                        "BranchID": "1",
                        "TellerID": "1",
                        "DeviceID": "790",
                        "RefNum": "9843244287",
                        "BillNumber": "1000",
                        "MobileNo": "' . $mobile . '",
                        "Amount":"10.00",
                        "MerchantNote": "MUKAFAAT"
                }';

        $ch = curl_init('https://b2b.stcpay.com.sa/B2B.DirectPayment.WebApi/DirectPayment/V4/DirectPaymentAuthorize');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSLCERT, '/home/hmfhmf/certificate/crt.crt');
        curl_setopt($ch, CURLOPT_SSLKEY, '/home/hmfhmf/certificate/key.key');
        curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-ClientCode: 73386352107',

            'Content-Length: ' . strlen($data)
        ));

        $result = curl_exec($ch);

        if (curl_errno($ch))
        {
            $error_msg = curl_error($ch);
            echo $error_msg;
        }

        $result = json_decode($result, true);

        if (isset($result['DirectPaymentAuthorizeV4ResponseMessage']['STCPayPmtReference']))
        {
            return response()->json(['status' => true, 'data' => ['ref_num' => $result['DirectPaymentAuthorizeV4ResponseMessage']['STCPayPmtReference']], 'message' => 'Client has Completed Payment']);
        }
        else
        {
            return response()->json(['status' => false,

            'message' => 'Mobile is not registered as STC']);

        }

    }

}

