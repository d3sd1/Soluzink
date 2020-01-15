<?php require('../../../../../kernel/core.php');
if(USER_IS_BLOCKED) {die();}?>
<div class="container-fluid practicians">
	<div class="row page-head">
		<a [routerLink]="['/Psicos']">
                    <div class="practician-type psico">
                            <div class="practician-type showdesc inactive-type">
                                    <i class="current-page-icon fa fa-mortar-board"></i> <?php echo $lang['home']['base']['header']['list']['psico'] ?>
                            </div>
                    </div>
                </a>
                <div class="practician-type coach">
                        <div class="practician-type showdesc active-type">
                                <i class="current-page-icon fa fa-thumbs-up"></i> <?php echo $lang['home']['base']['header']['list']['coach'] ?>
                        </div>
                </div>
	</div>
</div>
         <div class="container-fluid listing-block listing-block-margin" id="listingFilters">
            <div class="row listing-results">
               <div class="col-md-3">
                   <div class="dropdown" style="width: 100%">
                        <button class="btn buynow dropdown-toggle" style="width: 100%" type="button" data-toggle="dropdown"><?php echo $lang['home']['listing']['sorting']['speciality'] ?>
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu" style="text-align: center; width: 100%">
                          <?php 
                          $patologies = $db->query("SELECT langkey,id FROM patologies");
                          while($pat = $patologies->fetch_row())
                          {
                              echo '<li class="triggerFilter" style="cursor: pointer"><a data-type="patologies" data-infoid="'.$pat[1].'">'.$lang['DB']['treatments'][$pat[0]].'</a></li>';
                          }
                          ?>
                        </ul>
                    </div>
               </div>
               <div class="col-md-3">
                   <div class="dropdown" style="width: 100%">
                        <button class="btn buynow dropdown-toggle" style="width: 100%" type="button" data-toggle="dropdown"><?php echo $lang['home']['listing']['sorting']['disposability'] ?>
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu" style="text-align: center; width: 100%">
                          <li><li class="triggerFilter" style="cursor: pointer"><a data-type="timespace" data-infoid="morning"><?php echo $lang['home']['listing']['sorting']['disposabilitycontent']['morning'] ?></a></li>
                          <li><li class="triggerFilter" style="cursor: pointer"><a data-type="timespace" data-infoid="afternoon"><?php echo $lang['home']['listing']['sorting']['disposabilitycontent']['noon'] ?></a></li>
                          <li><li class="triggerFilter" style="cursor: pointer"><a data-type="timespace" data-infoid="night"><?php echo $lang['home']['listing']['sorting']['disposabilitycontent']['night'] ?></a></li>
                        </ul>
                    </div>
               </div>
                <div class="col-md-3">
                   <div class="dropdown" style="width: 100%">
                        <button class="btn buynow dropdown-toggle" style="width: 100%" type="button" data-toggle="dropdown"><?php echo $lang['home']['listing']['sorting']['orderby'] ?>:
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu" style="text-align: center; width: 100%">
                          <li class="triggerOrderSwapper" style="cursor: pointer"><a data-ordertype="sessionnow"><?php echo $lang['home']['listing']['sorting']['orderbycontent']['sessionnow'] ?></a></li>
                          <li class="triggerOrderSwapper" style="cursor: pointer"><a data-ordertype="moreexpensive"><?php echo $lang['home']['listing']['sorting']['orderbycontent']['expensive'] ?></a></li>
                          <li class="triggerOrderSwapper" style="cursor: pointer"><a data-ordertype="morecheap"><?php echo $lang['home']['listing']['sorting']['orderbycontent']['cheap'] ?></a></li>
                        </ul>
                    </div>
               </div>  
                <div class="col-md-3">
                   <input type="text" id="moneyPicker" value="" />
                </div>  
            </div>
             <div class="col-md-12" style="margin-bottom: 20px">
                 <input type="text" value="" data-role="tagsinput" id="listingSearchTags" readonly="readonly"/>
             </div>
         </div>
         <div class="container-fluid listing-block" id="listingTree" data-type="psico">
            <div class="more-listing" id="loadMore"></div>
         </div>