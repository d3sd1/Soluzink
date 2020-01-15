<?php
require('kernel/core.php');
require('kernel/class/opentok/opentok.phar');
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;
if($core->safeAjaxCall() && USER_LOGGED_IN)
{
    if($_GET['type'] != 'psico' && $_GET['type'] != 'coach' && $_GET['type'] != 'client')
    {
        $_GET['type'] = 'client';
    }
    if($_GET['type'] != 'psico' && $_GET['type'] != 'coach')
    {
        $typeClient = true;
    }
    else
    {
        $typeClient = false;
    }
    if($typeClient)
    {
        $sessionInfo = $db->query('SELECT sessionlengthmins,timestamp,patid,psico_id,sessionId FROM users_psicos_sessions WHERE user_id='.USER_ID.' AND timestamp+sessionlengthmins*60>'.time().' ORDER BY timestamp ASC LIMIT 1');
        if($sessionInfo->num_rows == 0)
        {
            echo 'NO_SESSIONS';
            die();
        }
        else
        {
            $sessionData = $sessionInfo->fetch_row();
            $otherInfo = $db->query('SELECT name,surnames,photo FROM users WHERE id='.$sessionData[3])->fetch_row();
        }
    }
    else
    {
        $sessionInfo = $db->query('SELECT sessionlengthmins,timestamp,patid,user_id,sessionId FROM users_psicos_sessions WHERE psico_id='.USER_ID.' AND timestamp+sessionlengthmins*60>'.time().' ORDER BY timestamp ASC LIMIT 1');
        if($sessionInfo->num_rows == 0)
        {
            echo 'NO_SESSIONS';
            die();
        }
        else
        {
            $sessionData = $sessionInfo->fetch_row();
            $otherInfo = $db->query('SELECT name,surnames,photo FROM users WHERE id='.$sessionData[3])->fetch_row();
        }
    }
    $sessionEndTimestamp = $sessionData[0]*60+$sessionData[1];
    $sessionStartTimestamp = $sessionData[1];
    if($sessionEndTimestamp >= time() && $sessionStartTimestamp <= time())
    {
        $opentok = new OpenTok(config('opentok.apikey'), config('opentok.secretkey'));
        
        if($sessionData[4] == '' || $sessionData[4] == null)
        {
            $session = $opentok->createSession();
            $session = $opentok->createSession(array('mediaMode' => MediaMode::ROUTED));
            $session = $opentok->createSession(array('location' => USER_IP));
            $sessionOptions = array(
                'archiveMode' => ArchiveMode::ALWAYS,
                'mediaMode' => MediaMode::ROUTED
            );
            $session = $opentok->createSession($sessionOptions);
            $sessionId = $session->getSessionId();
            if($typeClient)
            {
                $db->query('UPDATE users_psicos_sessions SET sessionId="'.$sessionId.'" WHERE user_id='.USER_ID.' AND timestamp+sessionlengthmins*60>'.time());
            }
            else
            {
                $db->query('UPDATE users_psicos_sessions SET sessionId="'.$sessionId.'" WHERE psico_id='.USER_ID.' AND timestamp+sessionlengthmins*60>'.time());
            }
        }
        else
        {
            $sessionId = $sessionData[4];
        }
        $token = $opentok->generateToken($sessionId,array(
            'role'       => (!$typeClient ? Role::MODERATOR:Role::PUBLISHER),
            'expireTime' => $sessionEndTimestamp,
            'data'       => 'name='.USER_NAME.' '.USER_SURNAMES
        ));
        echo 'SESSION_ACTIVE|||'.config('opentok.apikey').'|||'.$sessionId.'|||'.$token.'|||'.$otherInfo[0].'|||'.$otherInfo[1].'|||'.str_replace(array('{PROFILE_IMAGE_DEFAULT}','{URL}'),array(PROFILE_IMAGE_DEFAULT,URL),$otherInfo[2]).'|||'.$core->crypt(USER_ID).'|||'.$sessionEndTimestamp;
        die();
    }
    else if($sessionStartTimestamp >= time())
    {
        echo 'WAIT_FOR_IT|||'.date('m/d/Y H:i:s',$sessionStartTimestamp);
        die();
    }
    else
    {
        echo 'NO_SESSIONS';
        die();
    }
}
else
{
    echo 'BAD_GATEWAY';
    die();
}