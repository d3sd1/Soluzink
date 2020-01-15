<?php
require('kernel/core.php');
header("Content-type:application/json");
if($core->safeAjaxCall() && isset($_GET['id']) && USER_LOGGED_IN)
{
    $testId = $core->decrypt($_GET['id']);
    if($testId != '')
    {
        $testData = $db->query('SELECT id,langkey FROM tests WHERE id='.$testId);
        if($testData->num_rows > 0)
        {
            $testDataDep = $testData->fetch_array();
            $testInfo = array('name' => $lang['test'][$testDataDep['langkey']], 'questions' => []);
            $testQuestions = $db->query('SELECT langkey,questid FROM tests_questions WHERE testid='.$testId.' ORDER BY orderid ASC');
            $orderid = 0;
            while($quest = $testQuestions->fetch_row())
            {
                $testInfo['questions'][$orderid] = array();
                $testInfo['questions'][$orderid]['name'] = $lang['test']['question'][$quest[0]];
                $testInfo['questions'][$orderid]['id'] = $quest[1];
                $testInfo['questions'][$orderid]['responses'] = array();
                $questionResponses = $db->query('SELECT langkey,responseid FROM tests_responses WHERE questid='.$quest[1].' ORDER BY responseid ASC');
                $respid = 0;
                while($response = $questionResponses->fetch_row())
                {
                    $testInfo['questions'][$orderid]['responses'][$respid]['name'] = $lang['test']['response'][$response[0]];
                    $testInfo['questions'][$orderid]['responses'][$respid]['id'] = $response[1];
                    $respid++;
                }
                $orderid++;
            }
            echo json_encode($testInfo);
        }
        else
        {
            echo json_encode(array('NOT_VALID'));
            die();
        }
    }
    else
    {
        echo json_encode(array('NOT_VALID'));
        die();
    }
}
else
{
    echo json_encode(array('NOT_VALID'));
    die();
}