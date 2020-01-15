$(document).ready(function(){
    $.ajax({ url: '/checklogin',
        context: document.body,
        success: function(response){
            if(configTranscription['loggedIn'] == 1 && response == 'NOT_CONNECTED')
            {
                window.location.replace(configTranscription.URL + '/logout');
            }
            if(response == 'INSECURE_SESSION')
            {
                window.location.replace(configTranscription.URL + '/logout?redirTo=#/LogoutLoggedSmw');
            }
            if(response == 'BANNED')
            {
                window.location.replace(configTranscription.URL + '/logout?redirTo=#/Logout');
            }
            else if(response == 'ACC_BLOCKED')
            {
                if(window.location.href.split('/').pop() != 'Recover')
                {
                    window.location = '/#/Recover';
                }
            }
            else if(response == 'CONNECTED')
            {
               configTranscription['loggedIn'] = 1;
            }
            else if(response == 'NOT_CONNECTED')
            {
               configTranscription['loggedIn'] = 0;
            }
    }});
});