<?php
	include_once('MoneyApi.php');

	$moneyApi = new MoneyApi();
	$postedString = file_get_contents("php://input");
	$paymentMethodId = "0876404567";
	$urlTypeId = "1558787058870";

	if ($postedString != null) 
	{
		$moneyApi->transactionLog($postedString);

		$jsonPostedString = json_decode($postedString, true);
		$transactionType = $jsonPostedString['TransactionType'];
		$transactionId = $jsonPostedString['TransID'];
		$transactionTime = $jsonPostedString['TransTime'];
		$totalAmount = $jsonPostedString['TransAmount'];
		$businessShortCode = $jsonPostedString['BusinessShortCode'];
		$accountNumber = $jsonPostedString['BillRefNumber'];
		$invoiceNumber = $jsonPostedString['InvoiceNumber'];
		$orgAccountBalance = $jsonPostedString['OrgAccountBalance'];
		$thirdPartyTransID = $jsonPostedString['ThirdPartyTransID'];
		$transactionAccount = $jsonPostedString['MSISDN'];
		$firstName = $jsonPostedString['FirstName'];
		$middleName = $jsonPostedString['MiddleName'];
		$lastName = $jsonPostedString['LastName'];
		$transactionStatus = "success";
		$description = "Confirming from M-Pesa paybill ".$businessShortCode." payment ".$totalAmount;

		if ($transactionId != null & $accountNumber != null)
		{
				print_r($moneyApi->transactionUpdate($totalAmount, substr($transactionAccount, -9), $transactionId));
		}
		else
		{

		}
	} 
	else
	{
		$arr = array('code' => '404', 'state' => 'failed', 'error'=> 'Nothing to collect from mobile money server.', 'info' => 'Contact Roodito at app@roodito.com or call 0727380799');
        print_r(json_encode($arr));
	}
	// {"Body":
	// 	{"stkCallback":
	// 		{"MerchantRequestID":"10607-21903-1",
	// 			"CheckoutRequestID":"ws_CO_DMZ_405337850_10102019015647903",
	// 			"ResultCode":0,
	// 			"ResultDesc":"The service request is processed successfully.",
	// 			"CallbackMetadata":
	// 			{"Item":
	// 				[{"Name":"Amount","Value":1.00},
	// 				 {"Name":"MpesaReceiptNumber","Value":"NJA75RRIRD"},
	// 				 {"Name":"Balance"},
	// 				 {"Name":"TransactionDate","Value":20191010015651},
	// 				 {"Name":"PhoneNumber","Value":254745610062}
	// 				]
	// 			}
	// 		}
	// 	}
	// }
?>
