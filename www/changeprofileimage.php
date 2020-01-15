<?php
require('kernel/core.php');
require('kernel/class/facedetector/FaceDetector.php');
ini_set('post_max_size', config('php.profile.maximagesize'));
ini_set('upload_max_filesize', config('php.profile.maximagesize'));
if($core->safeAjaxCall() && isset($_POST['slim']) && array_key_exists(0,$_POST['slim']))
{
    $imageData = json_decode($_POST['slim'][0],true);
    if(USER_LOGGED_IN)
    {
        if($imageData['input']['size'] > $core->getUploadFileSizeBytes(config('php.profile.maximagesize')))
        {
            echo 'ERROR_PIC_SIZE';
            die();
        }
        else
        {
            $imageBase64 = $imageData['output']['image']; //data:image/jpeg;base64,
            $imageMimeStr = $core->get_string_between($imageBase64, 'data:', ';base64,');

            $imageResource = imagecreatefromstring(base64_decode(str_replace('data:'.$imageMimeStr.';base64,',null,$imageBase64)));
            $imageMime = explode('/',$imageMimeStr);
            $imageExtension = $imageMime[count($imageMime)-1];

            if(!(($imageExtension != 'gif') && ($imageExtension !== 'jpg') && ($imageExtension !== 'jpeg') && ($imageExtension !== 'png')))
            {
                $detector = new svay\FaceDetector();
                if($detector->picHasFace($imageResource))
                {
                    if(imagesx($imageResource) != config('profile.photos.pxsize') && imagesy($imageResource) != config('profile.photos.pxsize'))
                    {
                        echo 'ERROR_PIC_WIDTH_HEIGHT';
                        die();
                    }
                    else
                    {
                        try
                        {
                           imagejpeg($imageResource, __DIR__.'/assets/images/profile/uploads/'.USER_ID.'.'.$imageExtension, 70);
                           $db->query('UPDATE users SET photo="{URL}/assets/images/profile/uploads/'.USER_ID.'.'.$imageExtension.'" WHERE id='.USER_ID) or die($db->error);
                           echo 'SUCCESS|||'.URL.'/assets/images/profile/uploads/'.USER_ID.'.'.$imageExtension;
                           die();
                        }
                        catch(Exception $e)
                        {
                            echo 'ERROR';
                            error_log('Error while trying to upload profile image. User id: '.USER_ID.', ERROR: '.$e);
                            die();
                        }
                    }
                }
                else
                {
                    echo 'NO_FACE_DETECTED';
                    die();
                }
            }
            else
            {
                echo 'ERROR_IMG_TYPE';
                die();
            }
        }
    }
    else
    {
        echo 'ERROR';
        die();
    }
}
else
{
    echo 'ERROR';
    die();
}
?>
