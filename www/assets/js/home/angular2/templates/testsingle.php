<?php require('../../../../../kernel/core.php');
if(USER_IS_BLOCKED) {die();}
?><div class="container-fluid pg-header tests-bg">
            <div class="pg-header-content">
               <h1 class="pg-title"></h1>
            </div>
            <div class="pg-header-icon fa fa-search"></div>
         </div>
         <div class="container-fluid blog single-block single-option-2">
            <div class="row">
               <div class="col-md-8 col-md-offset-2 text-center">
                   <div id="currentProgressTest">
                    <div id="currentProgressTestBar">0%</div>
                  </div>
                   <h1 id="questionTxt"></h1>
                <div class="testcontainter">
                  <ul id="responsesPicker" data-question="0"></ul>
                  <a class="margin-top-20 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect bg-green fonin-top-20t-white float-right bottom-20" id="nextQuestionTrigger" onclick="responseQuestion()"></a>
                </div>
               </div>
            </div>
         </div>