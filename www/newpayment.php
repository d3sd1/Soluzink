<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    try
    {
        $core->checkCSRFToken('POST');
    }
    catch(Exception $e)
    {
        echo 'CRASH_CSRF';
        die();
    }
    if(!USER_LOGGED_IN)
    {
        echo 'NOT_LOGGED';
        die();
    }
    if(!config('payments.enabled.global'))
    {
        echo 'PAYMENTS_DISABLED';
        die();
    }
    if(isset($_POST['ccn']) && isset($_POST['ownerName']) && isset($_POST['exp']) && isset($_POST['cvc']))
    {
        $psicoId = $core->decrypt($_POST['psicoCode']);
        $creditCard = str_replace(' ', '',$_POST['ccn']);
        $ownerName = $_POST['ownerName'];
        $expiry = $_POST['exp'];
        $cvc = $_POST['cvc'];
        if(!preg_match("/^[0-9]+$/", $creditCard) || $creditCard == null)
        {
            echo 'INVALID_CCN';
            die();
        }
        else if(preg_match("/^[0-9]+$/", $ownerName) || $ownerName == null)
        {
            echo 'INVALID_NAME';
            die();
        }
        else if(!preg_match("/^[0-9]+$/", str_replace(array('/',' '), '',$expiry)) || $expiry == null)
        {
            echo 'INVALID_EXP';
            die();
        }
        else if(!preg_match("/^[0-9]+$/", $cvc) || $cvc == null)
        {
            echo 'INVALID_CVC';
            die();
        }
        else if($_POST['psicoCode'] == null || $_POST['psicoCode'] == '' || $db->query('SELECT user_id FROM users_psicos WHERE user_id='.$psicoId)->num_rows == 0)
        {
            
            echo 'INVALID_PSICO';
            die();
        }
        else
        {
            try
            {
                require 'kernel/class/payments/Braintree.php';

                if(config('debug'))
                {
                        Braintree_Configuration::environment('sandbox');
                }
                else
                {
                        Braintree_Configuration::environment('production');
                }
                $userInfo = $db->query('SELECT u.id,u.name,u.surnames,u.email,u.phone,u.geoPostalCode,u.geoCity,u.geoCity,u.geoCountry,u.currency FROM users u WHERE id='.USER_ID)->fetch_array();
                switch($userInfo['currency'])
                {
                    case 'EUR':
                        $merchantId = config('braintree.merchantCurrency.EUR');
                    break;
                    case 'USD':
                        $merchantId = config('braintree.merchantCurrency.USD');
                    break;
                    case 'GBP':
                        $merchantId = config('braintree.merchantCurrency.GBP');
                    break;
                    default: 
                        $merchantId = config('braintree.merchantCurrency.EUR');
                }

                Braintree_Configuration::merchantId(config('braintree.merchantId'));
                Braintree_Configuration::publicKey(config('braintree.publicKey'));
                Braintree_Configuration::privateKey(config('braintree.privateKey'));
                $psicoInfo = $db->query('SELECT up.pph,up.pphCoin,u.name,u.surnames FROM users_psicos up JOIN users u ON u.id=up.user_id WHERE user_id='.$psicoId)->fetch_array();
                if($psicoInfo['pphCoin'] != $userInfo['currency'])
                {
                    $finalAmount = $core->convertCurrency($psicoInfo['pph'],$psicoInfo['pphCoin'],$userInfo['currency']);
                }
                else
                {
                    $finalAmount = $psicoInfo['pph'];
                }
                $saleInfo = array(
                'invoiceId' => microtime().$userInfo['id'],
                'userName' => $userInfo['name'],
                'userSurnames' => $userInfo['surnames'],
                'userEmail' => $userInfo['email'],
                'userPhone' => $userInfo['phone'],
                'userPostCode' => ($userInfo['geoPostalCode'] != '-' && $userInfo['geoPostalCode'] != null ? $userInfo['geoPostalCode']:''),
                'userRegion' => $userInfo['geoCity'],
                'userCountryCode' => ($core->validate('countryalpha2',$userInfo['geoCountry']) ? $userInfo['geoCountry']:''),
                'amount' => $finalAmount
                );

                        $exp_date = str_replace(' ','',explode("/",$expiry));
                        $result = Braintree_Customer::create(array(
                                'firstName' => $saleInfo['userName'],
                                'lastName'  => $saleInfo['userSurnames'],
                                'phone'     => $saleInfo['userPhone'],
                                'email'     => $saleInfo['userEmail'],
                                'creditCard' => array(
                                        'number'          => $creditCard,
                                        'cardholderName'  => $saleInfo['userName'].' '.$saleInfo['userSurnames'],
                                        'expirationMonth' => $exp_date[0],
                                        'expirationYear'  => $exp_date[1],
                                        'cvv'             => $cvc,
                                        'billingAddress' => array(
                                                'postalCode'        => $saleInfo['userPostCode'],
                                                'region'            => $saleInfo['userRegion'],
                                                'countryCodeAlpha2' => $saleInfo['userCountryCode']
                                        )
                                )
                        ));
                        if ($result->success) {
                                $braintree_cust_id = $result->customer->id; 
                        } else {
                            echo 'API_CRASHED_DATA_NOT_VALID';
                            error_log("NewPayment file, BrainTree API failed crashing page: ".$result->message);
                            die();
                        }
                        /* CHECK SESSION DATA */
                        try {
                            $timestamp = DateTime::createFromFormat('!d/m/Y H:i', $_POST['date'])->getTimestamp();
                        }
                        catch(Exception $e)
                        {
                            echo 'DATA_NOT_VALID';
                            die();
                        }
                        $calendarArray = $core->getCalendar($psicoId,true);
                        if($timestamp < time())
                        {
                            echo 'DATE_ALREADY_PASSED';
                            die();
                        }
                        foreach($calendarArray['dayscontrated'] as $restrictedTimestamp)
                        {
                            if($restrictedTimestamp == $timestamp)
                            {
                                echo 'DATE_ALREADY_PICKED';
                                die();
                            }
                        }
                        $finalPrice = null;
                        $sessionLength = null;
                        $weekDay = null;
                        $hour = null;
                        $minute = null;
                        if($calendarArray == 'NO_CALENDAR')
                        {
                            echo 'CALENDAR_NOT_ENABLED';
                            die();
                        }
                        else
                        {
                            $psicoCalendar = $db->query('SELECT * FROM users_psicos_calendar WHERE user_id='.$psicoId);
                            /* Check if the date is before the psico max date */
                            try {
                                $maxDateTimestamp = DateTime::createFromFormat('!Y-m-d', $calendarArray['maxdate'])->getTimestamp();
                            }
                            catch(Exception $e)
                            {
                                echo 'DATA_NOT_VALID';
                                die();
                            }
                            if($maxDateTimestamp < $timestamp)
                            {
                                echo 'DATA_NOT_VALID';
                                die();
                            }
                            else
                            {
                                /* Check if it's a valid citation */
                                $weekDay = date('w', $timestamp);
                                $hour = sprintf('%02d', date('H', $timestamp));
                                $minute = sprintf('%02d', date('i', $timestamp));
                                if(array_key_exists($weekDay,$calendarArray['days']))
                                {
                                    $timeIndex = -1;
                                    foreach($calendarArray['days'][$weekDay] as $forWeekday => $forTime)
                                    {
                                        $checkNumbersFormat = explode('.',explode('--',$forTime)[0]);
                                        $formattedNumber = null;
                                        if(strlen($checkNumbersFormat[0]) == 1)
                                        {
                                            $formattedNumber .= sprintf('%02d', $checkNumbersFormat[0]);
                                        }
                                        else
                                        {
                                            $formattedNumber .= $checkNumbersFormat[0];
                                        }
                                        $formattedNumber .= '.';
                                        if(strlen($checkNumbersFormat[1]) == 1)
                                        {
                                            $formattedNumber .= sprintf('%02d', $checkNumbersFormat[1]);
                                        }
                                        else
                                        {
                                            $formattedNumber .= $checkNumbersFormat[1];
                                        }
                                        if(stristr($formattedNumber,$hour.'.'.$minute) != false)
                                        {
                                            $timeIndex = $forWeekday;
                                        }
                                    }
                                    if($timeIndex == -1)
                                    {
                                        echo 'DATA_NOT_VALID';
                                        die();
                                    }
                                    else
                                    {
                                        $sessionLengthArray = explode('--',$calendarArray['days'][$weekDay][$timeIndex]);
                                        if(count($sessionLengthArray) > 1)
                                        {
                                            $sessionLength = $sessionLengthArray[1];
                                        }
                                        else
                                        {
                                            $sessionLength = config('session.defaultlenghtmins');
                                        }
                                        $finalPrice = $saleInfo['amount']*($sessionLength/60);
                                    }
                                }
                                else
                                {
                                    echo 'DATA_NOT_VALID';
                                    die();
                                }
                            }
                        }
                        if(isset($_GET['alerted']) && $_GET['alerted'] == 0)
                        {
                            $getUserSessions = $db->query('SELECT timestamp,sessionlengthmins FROM users_psicos_sessions WHERE timestamp > '.time().' AND user_id='.$userInfo['id']);
                            while($row = $getUserSessions->fetch_row())
                            {
                                if(($row[0] > $timestamp && $row[0] < $timestamp + $sessionLength*60) || ($timestamp > $row[0] && $timestamp < $row[0] + $row[1]*60))
                                {
                                    echo 'ALERT_ANOTHER_SESSION';
                                    die();
                                }
                            }
                        }
                        
                        $sale = array(
                            'customerId' => $braintree_cust_id,
                            'amount'   => $finalPrice,
                            'orderId'  => $saleInfo['invoiceId'],
                            'options' => array('submitForSettlement'   => true),
                            'merchantAccountId' => $merchantId
                        );
                        
                        $result = Braintree_Transaction::sale($sale);

                        if ($result->success)
                        {
                            echo 'TRANSACTION_SUCCESS|||'.$finalPrice.'|||'.$core->getCurrency($userInfo['currency'],'symbol').'|||'.date('d/m/Y',$timestamp).' '.str_replace(array('{{hour}}','{{minute}}'),array($hour,$minute),$lang['home']['modal']['buySessions']['success']['date']).'|||'.str_replace('{{lenght}}',$sessionLength,$lang['home']['modal']['buySessions']['success']['length']).'|||'.$psicoInfo['name'].' '.$psicoInfo['surnames'].'|||'.$result->transaction->id;
                            if($db->query('SELECT user_id FROM users_creditcards WHERE user_id='.USER_ID.' AND ccnumber="'.$core->crypt($creditCard).'"')->num_rows == 0 && @$_POST['saveCCToProfile'])
                            {
                                $db->query('INSERT INTO users_creditcards (user_id,owner,ccnumber,cvc,expiry,cctype) VALUES ('.USER_ID.',"'.$ownerName.'","'.$core->crypt($creditCard).'",'.$cvc.',"'.$expiry.'","'.$_POST['cardType'].'")');
                            }
                            $db->query('INSERT INTO users_invoices (user_id,psico_id,timestamp,payment_type,success,apiTransactionId,apiBaseId,currency,amount) VALUES ('.USER_ID.','.$psicoId.','.time().',"CREDIT_CARD",'.(int) $result->success.',"'.$result->transaction->orderId.'","'.$result->transaction->id.'","'.$result->transaction->currencyIsoCode.'","'.$result->transaction->amount.'")') or die($db->error);
                            $db->query('INSERT INTO users_psicos_sessions (user_id,psico_id,timestamp,patid,satisfacted,sessionlengthmins) VALUES ('.$userInfo['id'].','.$psicoId.','.$timestamp.','.$db->query('SELECT specpatid FROM users_psicos WHERE user_id='.$psicoId)->fetch_row()[0].',1,'.$sessionLength.')');
                            die();
                        }
                        else
                        {
                            $db->query('INSERT INTO users_invoices (user_id,psico_id,timestamp,payment_type,success,apiTransactionId,apiBaseId,currency,amount) VALUES ('.USER_ID.','.$psicoId.','.time().',"CREDIT_CARD",'.(int) $result->success.',"'.$result->transaction->orderId.'","'.$result->transaction->id.'","'.$result->transaction->currencyIsoCode.'","'.$result->transaction->amount.'")') or die($db->error);
                            echo 'TRANSACTION_ERROR';
                            error_log('Error : '.$result->_attributes['message']);
                            die();
                        }
                }
                catch(Exception $e)
                {
                    echo 'API_ERROR';
                    error_log('BRAINTREE API ERROR -> '.$e);
                    die();
                }
        }
    }
    else
    {
        echo 'DATA_NOT_COMPLETED';
        die();
    }
}