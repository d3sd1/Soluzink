<?php
require('kernel/core.php');
if($core->safeAjaxCall())
{
    if(USER_LOGGED_IN && $db->query('SELECT user_id FROM users_creditcards WHERE user_id='.USER_ID)->num_rows > 0)
    {
        $creditCards = $db->query('SELECT * FROM users_creditcards WHERE user_id='.USER_ID.' ORDER BY cctype ASC');
        $output = '<select class="selectpicker">';
        $lastType = null;
        $row = 0;
        while($cc = $creditCards->fetch_array())
        {
            if($lastType != $cc['cctype'])
            {
                if($row != 0)
                {
                    $output .= '</optgroup>';
                }
                $output .= '<optgroup label="'.$cc['cctype'].'">';
                $lastType = $cc['cctype'];
            }
            $output .= '<option data-cctype="'.$cc['cctype'].'" data-ccn="'.$core->formatCC('getfromdb',$cc['ccnumber']).'" data-ccnpublic="'.$core->formatCC('getfromdbencoded',$cc['ccnumber']).'" data-owner="'.$cc['owner'].'" data-cvc="'.$cc['cvc'].'" data-expiry="'.$cc['expiry'].'">'.$core->formatCC('getfromdbencoded',$cc['ccnumber']).'</option>';
            $row++;
        }
        $output .= '</optgroup></select>';
        echo $output;
    }
}