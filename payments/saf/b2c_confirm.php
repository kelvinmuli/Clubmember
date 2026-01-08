<?php
	include_once('MyChama.php');

	$myChama = new MyChama();
   	$accountNumber = $_REQUEST['accountNumber'];	
	$postedString = file_get_contents("php://input");
	$urlTypeId = "1558787952519";

	if ($postedString != null) 
	{

		$jsonPostedString = json_decode($postedString, true);
		$result = $jsonPostedString['Result'];
		if ($result != null && $result['ResultType'] == 0 && $result['ResultCode'] == 0) //Withdraw
		{
			$paymentMethodId = "6894455401";//C-Wallet
			$transactionId = $result['TransactionID'];
			$resultParameters = $result['ResultParameters'];
			$resultParameter = $resultParameters['ResultParameter'];
			foreach ($resultParameter as $key => $value) 
			{
				$rPKey = $value['Key'];
				$rPValue = $value['Value'];
				if ($rPKey == 'TransactionAmount')
				{
					$totalAmount = money_format('%.2n', $rPValue);
				}
				elseif ($rPKey == 'ReceiverPartyPublicName')
				{
					$numberOrName = explode("-", $rPValue);
					$transactionAccount = trim($numberOrName[0]);
					$transactionName = $numberOrName[1];
				}
			}

			// if ($accountNumber == null)
			// {
			// 	$internalCreditPaymentHistory = $myChama->getInternalCreditPaymentHistory($paymentMethodId, $transactionAccount, $totalAmount);
			// 	$accountNumber = $internalCreditPaymentHistory['account_number'];
			// }
			// else
			// {
				
			// } 
			$internalCreditPaymentHistory = $myChama->getInternalPaymentHistory($accountNumber);
			$billAmount = money_format('%.2n', $internalCreditPaymentHistory['bill_amount']);
			$revenue = money_format('%.2n', $internalCreditPaymentHistory['revenue']);
			$totalAmountRevenue = money_format('%.2n', ($totalAmount + $revenue));
			if ($transactionId != null && $transactionAccount != null && $totalAmount != null)
			{
				$transactionStatus = "success";
				$description = "Confirming from M-Pesa paybill 998477 payment ".$totalAmount; 			
				print_r($myChama->updateCreditPaymentHistoryComplete($accountNumber, $transactionId, $billAmount, $totalAmountRevenue));
			}
			else
			{
				$transactionStatus = "failed";		
				$description = "Unconfirmed from M-Pesa paybill 998477 payment ".$totalAmount." to ".$transactionAccount;
			}
			$myChama->addPaymentTransaction($transactionAccount, $transactionId, $totalAmount, $accountNumber, $description, $paymentMethodId, $transactionStatus, $urlTypeId);
		}
		else //Deposit
		{
			$paymentMethodId = "0876404567";//Mpesa
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
				$myChama->updateMpesaAccount($orgAccountBalance);
				$myChama->addPaymentTransaction($transactionAccount, $transactionId, $totalAmount, $accountNumber, $description, $paymentMethodId, $transactionStatus, $urlTypeId);
				print_r($myChama->updatePaymentHistory($paymentMethodId, $transactionAccount, $transactionId, $totalAmount, $accountNumber));
			}
			else
			{
				$myChama->addPaymentTransaction($transactionAccount, $transactionId, $totalAmount, $accountNumber, $description, $paymentMethodId, $transactionStatus, $urlTypeId);
				print_r($myChama->updatePaymentHistoryStatus('543432223', $transactionAccount, $transactionId, $totalAmount, $accountNumber, true));
			}
		}

		$myChama->addPaymentLog($paymentMethodId, $urlTypeId, $postedString);
	} 
	else
	{
		$arr = array('code' => '404', 'state' => 'failed', 'error'=> 'Nothing to collect from mobile money server.', 'info' => 'Contact Chamacom at info@chamacom.co.ke / info@mychama.co.ke / 0727380799');
        print_r(json_encode($arr));
	}
	// {
	//       "TransactionType": "Pay Bill",
	//       "TransID": "NJ814O47L1",
	//       "TransTime": "20191008173157",
	//       "TransAmount": "5.00",
	//       "BusinessShortCode": "769712",
	//       "BillRefNumber": "OCD1321294862",
	//       "InvoiceNumber": "",
	//       "OrgAccountBalance": "7552.00",
	//       "ThirdPartyTransID": "",
	//       "MSISDN": "254727380799",
	//       "FirstName": "VICTOR",
	//       "MiddleName": "NGUGI",
	//       "LastName": ""
	// }

	// {
	//    	"fault": {
	//        "faultstring": "Error while accessing datastore;Please retry later",
	//        	"detail": {
	//            "errorcode": "datastore.ErrorWhileAccessingDataStore"
	//        	}
	//		}
	// }
	
	// {
	//    	"fault": {
 	//        	"faultstring": "Unable to identify proxy for host: api.safaricom.co.ke:443 and url: /mpesa/c2b/v1/registerurl",
 	//        	"detail": {
 	//            	"errorcode": "messaging.adaptors.http.flow.ApplicationNotFound"
 	//        	}
 	//    	}
	// }	
?>
