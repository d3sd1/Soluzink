var questions, responsed = {}, lastQuestionIdx, singleQuestionProgress, lastOption = 'a', singleResponse = '<li><input id="{{option}}-option" type="radio"{{checked}} name="selector" value="{{responseid}}"><label for="{{option}}-option" id="{{responseid}}">{{text}}</label><div class="check"></div></li>';
$.ajax({
    url : "/gettestinfo?id=" + window.location.href.split("/").pop(),
    type : "get",
    async: true,
    success : function(data) {
        if(data[0] == 'NOT_VALID')
        {
            window.location = '/#/Error';
        }
        else
        {
            $('.pg-title').text(data['name']);
            $('#nextQuestionTrigger').text(langTranscription['TEST_BTN_NEXT']);
            questions = data.questions;
            singleQuestionProgress = Math.round(100/questions.length);
            setQuestion(0);
        }
    }
 });
function responseQuestion()
{
    responsed[$('#responsesPicker').attr('data-question')] = $('#responsesPicker input:checked').val();
    clearQuestions();
    setQuestion(lastQuestionIdx+1);
}
function setQuestion(idx)
{
    if(idx == questions.length-1)
    {
        $('#nextQuestionTrigger').text(langTranscription['TEST_BTN_SUBMIT']);
    }
    if(idx in questions)
    {
        $('#responsesPicker').attr('data-question',questions[idx]['id']);
        $('#questionTxt').text(questions[idx]['name']);
        setProgress();
        questions[idx]['responses'].forEach(setResponses);
        lastQuestionIdx = idx;
    }
    else
    {
        $.ajax({
            url : "/setdonetest",
            type : "post",
            data: responsed,
            async: true
         });
        $('#questionTxt').remove();
        $('#nextQuestionTrigger').remove();
        $('#responsesPicker').html('<h1>' + langTranscription['TEST_DONE'] + '</h1>');
    }
}
function setProgress()
{
    nextProgress = (parseInt($('#currentProgressTestBar').text())+singleQuestionProgress) + '%';
    $('#currentProgressTestBar').text(nextProgress).css('width',nextProgress);
}
function setResponses(index)
{
    if(lastOption == 'a')
    {
        checked = ' checked';
    }
    else
    {
        checked = '';
    }
    $('#responsesPicker').append(singleResponse.replace('{{text}}',index['name']).replace('{{responseid}}',index['id']).replace('{{option}}',lastOption).replace('{{option}}',lastOption).replace('{{checked}}',checked).replace('{{responseid}}',index['id']));
    lastOption = String.fromCharCode((lastOption.charCodeAt(0)+1));
}
function clearQuestions()
{
    $('#responsesPicker').html('');
    lastOption = 'a';
}