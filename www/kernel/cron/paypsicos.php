<?php
/* Set Script to every MONDAY AT 00:00 */
define('CRON',true);
require(__DIR__ . '/../core.php');

$paymentsToDo = $db->query("SELECT DISTINCT ui.psico_id,u.currency,u.email FROM users_invoices ui JOIN users u ON u.id=ui.psico_id WHERE ui.paid_to_psico=0 AND ui.success=1");
while($getUser = $paymentsToDo->fetch_row())
{
    $userPayment = $db->query("SELECT amount,currency FROM users_invoices WHERE paid_to_psico=0 AND success=1 AND psico_id=".$getUser[0]);
    $totalUsdPayment = 0;
    while($usrData = $userPayment->fetch_row())
    {
        $totalUsdPayment += $core->convertCurrency($usrData[0],$usrData[1],'USD');
    }
    $paymentStatus = sendpayment($core->convertCurrency($totalUsdPayment,'USD',$getUser[1]),$getUser[1],$getUser[2]); //amount,currency,email
    if($paymentStatus)
    {
        $db->query('INSERT INTO payments_logs (success,psicoid,timestamp) VALUES (1,'.$getUser[0].','.time().')');   
        $db->query("UPDATE users_invoices SET paid_to_psico=1 WHERE psico_id=".$getUser[0]);
    }
    else
    {
        $db->query('INSERT INTO payments_logs (success,psicoid,timestamp) VALUES (0,'.$getUser[0].','.time().')');   
    }
}
function sendpayment($amount,$currency,$email)
{
    $payLoad=array();

    //prepare the receivers
    $receiverList=array();
    $counter=0;
    $receiverList["receiver"][$counter]["amount"]=$amount;
    $receiverList["receiver"][$counter]["email"]=$email;
    $receiverList["receiver"][$counter]["paymentType"]="SERVICE";//this could be SERVICE or PERSONAL (which makes it free!)

    //prepare the call
    $payLoad["actionType"]="PAY";
    $payLoad["cancelUrl"]="https://www.soluzink.com";//this is required even though it isnt used
    $payLoad["returnUrl"]="https://www.soluzink.com";//this is required even though it isnt used
    $payLoad["currencyCode"]=$currency;
    $payLoad["receiverList"]=$receiverList;
    $payLoad["feesPayer"]="EACHRECEIVER";//this could be SENDER or EACHRECEIVER
    $payLoad["sender"]["email"]="payments@soluzink.com";//the paypal email address of the where the money is coming from

    //run the call
    $API_Endpoint =  'https://svcs'.(config('debug') ? 'sandbox':'').'.paypal.com/AdaptivePayments/Pay';
    $payLoad["requestEnvelope"]=array("errorLanguage"=>urlencode("en_US"),"detailLevel"=>urlencode("ReturnAll"));//add some debugging info the payLoad and setup the requestEnvelope
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
        'X-PAYPAL-REQUEST-DATA-FORMAT: JSON',
        'X-PAYPAL-RESPONSE-DATA-FORMAT: JSON',
        'X-PAYPAL-SECURITY-USERID: '. config("paypal.security.userid"),
        'X-PAYPAL-SECURITY-PASSWORD: '. config("paypal.security.password"),
        'X-PAYPAL-SECURITY-SIGNATURE: '. config("paypal.security.signature"),
        'X-PAYPAL-APPLICATION-ID: '. config("paypal.security.appid")
    ));  
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payLoad));//
    $response = curl_exec($ch);
    $response = json_decode($response, 1);

    //analyse the output
    $payKey = $response["payKey"];
    $paymentExecStatus=$response["paymentExecStatus"];
    $correlationId=$response["responseEnvelope"]["correlationId"];
    $paymentInfoList = isset($response["paymentInfoList"]) ? $response["paymentInfoList"] : null;

    if ($paymentExecStatus<>"ERROR") {
        if(is_array($paymentInfoList["paymentInfo"]))
        {
    foreach($paymentInfoList["paymentInfo"] as $paymentInfo) {//they will only be in this array if they had a paypal account
    $receiverEmail = $paymentInfo["receiver"]["email"];
    $receiverAmount = $paymentInfo["receiver"]["amount"];
    $withdrawalID = $paymentInfo["receiver"]["invoiceId"];
    $transactionId = $paymentInfo["transactionId"];//what shows in their paypal account
    $senderTransactionId = $paymentInfo["senderTransactionId"];//what shows in our paypal account
    $senderTransactionStatus = $paymentInfo["senderTransactionStatus"];
    $pendingReason = isset($paymentInfo["pendingReason"]) ? $paymentInfo["pendingReason"] : null;
    }
        return true;
        }
        else
        {
            return false;
        }
    }else{
        return false;
    }
}