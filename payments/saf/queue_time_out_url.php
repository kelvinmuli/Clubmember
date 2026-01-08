<?php
	include_once('MoneyApi.php');

	$moneyApi = new MoneyApi();
	$postedString = file_get_contents("php://input");
	$urlTypeId = "1558787952519";

	if ($postedString != null) 
	{
		$jsonPostedString = json_decode(trim($postedString), true);
		$result = $jsonPostedString['Result'];
		if ($result != null && $result['ResultType'] == 0 && $result['ResultCode'] == 0) //Withdraw
		{
			$paymentMethodId = "6894455401";//C-Wallet
			$transactionId = $result['TransactionID'];
			$resultParameters = $result['ResultParameters'];
			$resultParameter = $resultParameters['ResultParameter'];
			$totalAmount = '0.00'; $transactionAccount = ''; $fullLegalName = ''; 
			$totalAmountRevenue = '0.00'; $billAmount = '0.00'; $revenue = '0.00';
			foreach ($resultParameter as $key => $value) 
			{
				$rPKey = $value['Key'];
				$rPValue = $value['Value'];
				if ($rPKey == 'TransactionAmount')
				{
					$totalAmount = money_format('%.2n', $rPValue);
				}

				if ($rPKey == 'TransactionReceipt')
				{
					$transactionId = (($transactionId == $rPValue) ? $rPValue : $transactionId);
				}

				if ($rPKey == 'ReceiverPartyPublicName')
				{
					$numberOrName = explode("-", $rPValue);
					$transactionAccount = trim($numberOrName[0]);
					$fullLegalName = $numberOrName[1];
				}
			}

			if ($transactionId != null && $transactionAccount != null && $totalAmount != null)
			{
				$transactionStatus = "success";
				$description = "Confirming from M-Pesa paybill 998477 payment ".$totalAmount;	
				print_r($moneyApi->transactionUpdate($totalAmount, substr($transactionAccount, -9), $transactionId));
			}
			else
			{
				$transactionStatus = "failed";		
				$description = "Unconfirmed from M-Pesa paybill 998477 payment ".$totalAmount." to ".$transactionAccount;
			}
			$moneyApi->transactionLog($postedString);
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
			$fullLegalName = $firstName.' '.$middleName.' '.$lastName;
			$transactionStatus = "success";
			$description = "Confirming from M-Pesa paybill ".$businessShortCode." payment ".$totalAmount;

			if ($transactionId != null & $accountNumber != null)
			{
				// $moneyApi->updateMpesaAccount($orgAccountBalance);
				// $moneyApi->addPaymentTransaction($transactionAccount, $transactionId, $totalAmount, $accountNumber, $description, $paymentMethodId, $transactionStatus, $urlTypeId);
				// print_r($moneyApi->updatePaymentHistory($paymentMethodId, $transactionAccount, $transactionId, $totalAmount, $accountNumber, $fullLegalName));
			}
			else
			{
				// $moneyApi->addPaymentTransaction($transactionAccount, $transactionId, $totalAmount, $accountNumber, $description, $paymentMethodId, $transactionStatus, $urlTypeId);
				// print_r($moneyApi->updatePaymentHistoryStatus('543432223', $transactionAccount, $transactionId, $totalAmount, $accountNumber, true));
			}
		}

		$moneyApi->transactionLog($postedString);
	} 
	else
	{
		$arr = array('code' => '404', 'state' => 'failed', 'error'=> 'Nothing to collect from mobile money server.', 'info' => 'Contact Roodito at app@roodito.com or call 0727380799');
        print_r(json_encode($arr));
	}	
?>
