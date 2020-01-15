<?php require('../../../../../kernel/core.php');
if(!USER_LOGGED_IN)
{
   die();
}
$token = $core->generateCSRFToken();
if(USER_IS_BLOCKED) {die();}
?>
<!DOCTYPE html>
		<!--Main Wrapper-->
		<div class="main-wrapper">
                    <?php
                    if(USER_TYPE == 'psico' || USER_TYPE == 'coach')
                    {
                        $numSessions = $db->query('SELECT psico_id FROM users_psicos_sessions WHERE timestamp<'.time().' AND psico_id='.USER_ID)->num_rows;
                        if($numSessions > 0)
                        {
                            echo '<div class="box shadow">
                            <h3>'.$numSessions.'</h3><h5> '.$lang['home']['profile']['content']['sessionsdone'].'</h5>
                          </div>';
                        }
                    }
                            $finalImage = 'bg-';
                            $bgType = rand(0,2);
                            switch($bgType)
                            {
                                case 0:
                                    $finalImage .= 'img';
                                break;
                                case 1:
                                    $finalImage .= 'pattern';
                                break;
                                case 2:
                                    $finalImage .= 'abstract';
                                break;
                            }
                            $finalImage .= '-'.rand(1,4);
                            echo '<div class="bg-struct '.$finalImage.'"></div>';
                            $incomingSessions = $db->query('SELECT p.langkey,ups.timestamp,u.name,u.surnames,ups.sessionlengthmins FROM users_psicos_sessions ups JOIN patologies p ON ups.patid=p.id JOIN users u ON u.id=ups.psico_id WHERE timestamp>'.time().' AND user_id='.USER_ID.' ORDER BY timestamp ASC');
                            $incomingSessionsToDo = $db->query('SELECT p.langkey,ups.timestamp,u.name,u.surnames,ups.sessionlengthmins FROM users_psicos_sessions ups JOIN patologies p ON ups.patid=p.id JOIN users u ON u.id=ups.user_id WHERE timestamp>'.time().' AND psico_id='.USER_ID.' ORDER BY timestamp ASC');
                        ?>
			
			<div class="mdl-js-layout mdl-layout--fixed-header">
				
				<!--Top Header-->
				<span class="mdl-layout__header">
					<div class="mdl-layout__header-row mdl-scroll-spy-1">
						<!-- Title -->
						<span class="mdl-layout-title"><?php echo USER_NAME ?></span>
						<div class="mdl-layout-spacer"></div>
						<ul class="nav mdl-navigation mdl-layout--large-screen-only">
                                                    <li><a class="mdl-navigation__link" data-scroll href="#editor"><?php echo $lang['home']['profile']['menu']['editor'] ?></a></li>
                                                    <?php if(USER_TYPE == 'psico' || USER_TYPE == 'coach') { echo '<li><a class="mdl-navigation__link" data-scroll href="#editorProf">'.$lang['home']['profile']['menu']['editorProf'].'</a></li>'; } ?>
                                                    <li><a class="mdl-navigation__link" data-scroll href="#status"><?php echo $lang['home']['profile']['menu']['status'] ?></a></li>
                                                    <li><a class="mdl-navigation__link" data-scroll href="#diagnosis"><?php echo $lang['home']['profile']['menu']['diagnosis'] ?></a></li>
                                                    <li><a class="mdl-navigation__link" data-scroll href="#sessions"><?php echo $lang['home']['profile']['menu']['sessions'] ?></a></li>
                                                    <?php if($incomingSessions->num_rows > 0 || $incomingSessionsToDo->num_rows > 0) { ?><li><a class="mdl-navigation__link" data-scroll href="#nextsessions"><?php echo $lang['home']['profile']['menu']['sessionsnext'] ?></a></li><?php } ?>
                                                    <li><a class="mdl-navigation__link" data-scroll href="#testimonials"><?php echo $lang['home']['profile']['menu']['testimonials'] ?></a></li>
						</ul>
					</div>
				</span>
				<!--/Top Header-->
				<!--Main Content-->
				<div class="main-content relative">
					<div class="container">
						
						<!--About Sec-->
						<section class="about-sec mt-180 mt-sm-120  mb-30" id="editor">
							<div class="row">
								<div class="col-lg-12">
									<div class="mdl-card mdl-shadow--2dp">
										<div class="row">
                                                                                            
											<div class="col-md-5 col-xs-12">
                                                                                            
												<div class="candidate-img mb-35" id="profileImageURL" onclick="openProfileImageModal();" style="background-image: url('<?php echo USER_PROFILEIMG ?>');"></div>
												
											</div>
											<div class="col-md-7 col-xs-12 text-right">
												<div class="info-wrap">
													<h1><?php echo USER_NAME.' '.USER_SURNAMES ?></h1>
                                                                                                        <a class="changeimage mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect  bg-green font-white mr-10" onclick="openImageUploader()"><?php echo $lang['home']['profile']['editor']['changeimage'] ?></a>
												</div>
											</div>
                                                                                    <form id="updateProfile">
                                                                                        <input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
                                                                                        <div class="row hideme" id="showFormError"><div class="col-md-12"><div class="alert alert-danger"><strong><?php echo $lang['home']['profile']['editorProf']['error']['title'] ?></strong> <?php echo $lang['home']['profile']['editorProf']['error']['desc'] ?></div></div></div>
                                                                                    <div class="col-md-12 col-xs-12">
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['email'] ?></span>
                                                                                            <input type="email" data-filtertype="email" onclick="setEditorMode(this)" onblur="validateInput(this)" class="form-control" name="prof_email" value="<?php echo USER_EMAIL ?>">
                                                                                            <span id="statusIcon" class=""></span>
                                                                                        </div>
                                                                                        
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['newsletter'] ?></span>
                                                                                            <select data-filtertype="newsletter" onclick="setEditorMode(this)" onblur="validateInput(this)" class="form-control" name="prof_newsletter">
                                                                                                <option value="1"<?php echo (USER_NEWSLETTER == 1 ? ' selected':''); ?>><?php echo $lang['home']['profile']['editor']['newsletteropt']['y'] ?></option>
                                                                                                <option value="0"<?php echo (USER_NEWSLETTER == 0 ? ' selected':''); ?>><?php echo $lang['home']['profile']['editor']['newsletteropt']['n'] ?></option>
                                                                                            </select>
                                                                                            <span id="statusIcon" class=""></span>
                                                                                        </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['weekstartday'] ?></span>
                                                                                            <select data-filtertype="weekstartday" onclick="setEditorMode(this)" onblur="validateInput(this)" class="form-control" name="prof_weekstartday">
                                                                                                <option value="S"<?php echo (USER_WEEKSTARTS == 'S' ? ' selected':''); ?>><?php echo $lang['home']['profile']['editor']['weekstartdayopt']['s'] ?></option>
                                                                                                <option value="M"<?php echo (USER_WEEKSTARTS == 'M' ? ' selected':''); ?>><?php echo $lang['home']['profile']['editor']['weekstartdayopt']['m'] ?></option>
                                                                                            </select>
                                                                                            <span id="statusIcon" class=""></span>
                                                                                        </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['currency'] ?></span>
                                                                                            <select data-filtertype="currency" onclick="setEditorMode(this)" onblur="validateInput(this)" class="form-control" name="prof_currency">
                                                                                                <option value="EUR"<?php echo (USER_CURRENCY == 'EUR' ? ' selected':''); ?>><?php echo $lang['CORE']['currency']['EUR']['text'].' ('.$lang['CORE']['currency']['EUR']['symbol'].')' ?></option>
                                                                                                <option value="USD"<?php echo (USER_CURRENCY == 'USD' ? ' selected':''); ?>><?php echo $lang['CORE']['currency']['USD']['text'].' ('.$lang['CORE']['currency']['USD']['symbol'].')' ?></option>
                                                                                                <option value="GBP"<?php echo (USER_CURRENCY == 'GBP' ? ' selected':''); ?>><?php echo $lang['CORE']['currency']['GBP']['text'].' ('.$lang['CORE']['currency']['GBP']['symbol'].')' ?></option>
                                                                                            </select>
                                                                                            <span id="statusIcon" class=""></span>
                                                                                        </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['checkpassword'] ?></span>
                                                                                            <input data-filtertype="password" onclick="setEditorMode(this)" onblur="validateInput(this)" type="password" class="form-control" name="prof_checkpassword" placeholder="********" name="prof_checkpassword">
                                                                                            <span id="statusIcon" class=""></span>
                                                                                        </div>
                                                                                    </div>
                                                                                        <a id="updatePasswordTrigger" class="margin-top-20 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect bg-blue font-white mr-10 float-left"><?php echo $lang['home']['profile']['editor']['changepass'] ?></a>
                                                                                        <a id="updateProfileTrigger" class="margin-top-20 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect bg-green fonin-top-20t-white float-right"><?php echo $lang['home']['profile']['editor']['send'] ?></a>
                                                                                    </form>
										</div>
									</div>
								</div>	
							</div>
						</section>
                                                <?php if(USER_TYPE == 'psico' || USER_TYPE == 'coach') { ?>
                                                    <section class="about-sec mt-sm-120  mb-30" id="editorProf">
							<div class="row">
								<div class="col-lg-12">
									<div class="mdl-card mdl-shadow--2dp">
										<div class="row">
                                                                                    <form id="editProfPsico">
                                                                                    <h1 class="text-center"><?php echo $lang['home']['profile']['editorProf']['title'] ?></h1>
                                                                                        <input type="hidden" name="inputCSRFProtecter" value="<?php echo $token; ?>">
                                                                                        <div class="row hideme" id="showFormErrorProf"><div class="col-md-12"><div class="alert alert-danger"><strong><?php echo $lang['home']['profile']['editorProf']['error']['title'] ?></strong> <?php echo $lang['home']['profile']['editorProf']['error']['desc'] ?></div></div></div>
                                                                                    
                                                                                    <div class="col-md-12 col-xs-12">
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editorProf']['currency'] ?></span>
                                                                                            <select style="z-index: 1;" onchange="updateCurrencies()" data-filtertype="currency" class="form-control" onclick="setEditorMode(this)" onblur="validateInput(this)" name="prof_psico_currency">
                                                                                                <option<?php echo (USER_PROF_CURRENCY == 'USD' ? ' selected':''); ?> value="USD"><?php echo $lang['CORE']['currency']['USD']['text'] ?></option>
                                                                                                <option<?php echo (USER_PROF_CURRENCY == 'EUR' ? ' selected':''); ?> value="EUR"><?php echo $lang['CORE']['currency']['EUR']['text'] ?></option>
                                                                                                <option<?php echo (USER_PROF_CURRENCY == 'GBP' ? ' selected':''); ?> value="GBP"><?php echo $lang['CORE']['currency']['GBP']['text'] ?></option>
                                                                                              </select>
                                                                                        </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo str_replace('{{currency}}',$lang['CORE']['currency'][USER_PROF_CURRENCY]['symbol'],$lang['home']['profile']['editorProf']['pph']) ?></span>
                                                                                            <input style="z-index: 1;" type="number" data-filtertype="profpph" onclick="setEditorMode(this)" onblur="validateInput(this)" class="form-control" name="prof_psico_pph" required value="<?php echo USER_PROF_PPH ?>" min="1" step="0.1">
                                                                                        </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editorProf']['paypalAccount'] ?></span>
                                                                                            <input style="z-index: 1;" type="email" data-filtertype="email" onclick="setEditorMode(this)" onblur="validateInput(this)" class="form-control" name="prof_psico_paypalacc" required value="<?php echo USER_PROF_PAYPALACC ?>">
                                                                                        </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editorProf']['description'] ?></span>
                                                                                            <textarea style="z-index: 1;" class="form-control" data-filtertype="profdesc" required rows="5" onclick="setEditorMode(this)" onblur="validateInput(this)" minlength="<?php echo config('profile.description.minlength') ?>" name="prof_psico_description"><?php echo USER_PROF_DESCRIPTION ?></textarea>
                                                                                          </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['proftype'] ?></span>
                                                                                            <select style="z-index: 1;" onchange="updatePsicoFields(this)" data-filtertype="proftype" class="form-control" name="prof_psico_type" onclick="setEditorMode(this)" onblur="validateInput(this)">
                                                                                                <option<?php echo (USER_TYPE == 'psico' ? ' selected':''); ?> value="psico"><?php echo $lang['home']['profile']['editor']['proftypes']['psico'] ?></option>
                                                                                                <option<?php echo (USER_TYPE == 'coach' ? ' selected':''); ?> value="coach"><?php echo $lang['home']['profile']['editor']['proftypes']['coach'] ?></option>
                                                                                             </select>
                                                                                        </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['speciality'] ?></span>
                                                                                            <select class="form-control" data-filtertype="specialization" onclick="setEditorMode(this)" onblur="validateInput(this)" data-style="form-control" id="selectPat" name="prof_psico_specpatid" data-live-search="true">
                                                                                                <?php
                                                                                                $patologies = $db->query('SELECT id,langkey FROM patologies WHERE active=1');
                                                                                                $patNumber = 0;
                                                                                                while($row = $patologies->fetch_array())
                                                                                                {
                                                                                                    echo '<option '.(($patNumber == 0 && USER_PROF_SPECPATID == 0) || USER_PROF_SPECPATID == $row['id'] ? 'selected':'').' value="'.$core->crypt($row['id']).'">'.$lang['DB']['treatments'][$row['langkey']].'</option>';
                                                                                                    $patNumber++;
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="input-group" id="showCollegeNumber" <?php if(USER_TYPE != 'psico') { echo 'style="display: none"'; } ?>>
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['collegenumber'] ?></span>
                                                                                            <input type="text" style="z-index: 1;" data-filtertype="collegenumber" onclick="setEditorMode(this)" onblur="validateInput(this)" class="form-control" name="prof_psico_collegenumber" required value="<?php echo USER_PROF_COLLEGENUMBER ?>">
                                                                                        </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['sessionow'] ?></span>
                                                                                            <select style="z-index: 1;" onchange="updatePsicoFields(this)" data-filtertype="sessionnow" class="form-control" name="prof_psico_sessionnow" onclick="setEditorMode(this)" onblur="validateInput(this)">
                                                                                                <option<?php echo (USER_PROF_SESSNOW == 1 ? ' selected':''); ?> value="1"><?php echo $lang['home']['profile']['editor']['sessnow']['enabled'] ?></option>
                                                                                                <option<?php echo (USER_PROF_SESSNOW == 0 ? ' selected':''); ?> value="0"><?php echo $lang['home']['profile']['editor']['sessnow']['disabled'] ?></option>
                                                                                             </select>
                                                                                        </div>
                                                                                        <div class="input-group">
                                                                                            <span class="input-group-addon"><?php echo $lang['home']['profile']['editor']['checkpassword'] ?></span>
                                                                                            <input data-filtertype="password" style="z-index: 1;" onclick="setEditorMode(this)" onblur="validateInput(this)" type="password" class="form-control" name="prof_checkpassword" placeholder="********">
                                                                                            <span id="statusIcon" class=""></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <a class="margin-top-20 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect bg-red fonin-top-20t-white float-right" onclick='$("#editProfPsico").submit();' id="updateProfPsicoTrigger"><?php echo $lang['home']['profile']['editor']['send'] ?></a>
                                                                                    </form>
										</div>
									</div>
								</div>	
							</div>
						</section>
                                                <div class="col-lg-12">
                                                    <div class="mdl-card mdl-shadow--2dp">
                                                        <div class="row">
                                                            <h1 class="text-center"><?php echo $lang['home']['profile']['editorProf']['calendar']['title'] ?></h1>
                                                            <h3 class="text-center"><?php echo $lang['home']['profile']['editorProf']['calendar']['reminder'] ?></h3>
                                                            <h4 class="text-center"><?php echo $lang['home']['profile']['editorProf']['calendar']['subtitle'] ?></h4>
                                                            <form id="calendarEditor">
                                                                <a class="margin-top-20 mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect bg-purple fonin-top-20t-white saveCalendarBtn" id="updateProfCalendar"><?php echo $lang['home']['profile']['editorProf']['saveCalendar'] ?></a>
                                                                <?php
                                                                $maxdate = $db->query('SELECT maxdate FROM users_psicos_calendar WHERE user_id='.USER_ID)->fetch_row()[0];
                                                                if($maxdate == '' || strtotime($maxdate) < time())
                                                                {
                                                                    $db->query('UPDATE users_psicos_calendar SET maxdate="'.date('Y-m-d',time()+2592000).'" WHERE user_id='.USER_ID);
                                                                }
                                                                $calendar = $core->getCalendar(USER_ID,true); ?>
                                                                <div class="row hideme" id="showFormErrorCalendar"><div class="col-md-12"><div class="alert alert-danger"><strong><?php echo $lang['home']['profile']['editorProf']['error']['title'] ?></strong> <?php echo $lang['home']['profile']['editorProf']['error']['desc'] ?></div></div></div>
                                                                
                                                                <div class="form-group"><label class="control-label col-sm-6"><?php echo $lang['home']['profile']['editorProf']['calendar']['maxdate'] ?>:</label><div class="col-sm-6"><p class="form-control-static"><input type="date" min="<?php echo date('Y-m-d') ?>" id="calendarMaxDate" <?php if(is_array($calendar)) { echo 'value="'.$calendar['maxdate'].'" ';} ?>class="calendarDatePicker"></p></div></div>
                                                                
                                                                <table class="table table-bordered calendarTable">
                                                                    <thead>
                                                                      <tr>
                                                                          <?php
                                                                          if(USER_WEEKSTARTS == 'S')
                                                                          {
                                                                            echo '<th class="text-center">'.$lang['CORE']['days']['sunday'].'</th>';
                                                                          }
                                                                          ?>
                                                                        <th class="text-center"><?php echo $lang['CORE']['days']['monday'] ?></th>
                                                                        <th class="text-center"><?php echo $lang['CORE']['days']['tuesday'] ?></th>
                                                                        <th class="text-center"><?php echo $lang['CORE']['days']['wednesday'] ?></th>
                                                                        <th class="text-center"><?php echo $lang['CORE']['days']['thursday'] ?></th>
                                                                        <th class="text-center"><?php echo $lang['CORE']['days']['friday'] ?></th>
                                                                        <th class="text-center"><?php echo $lang['CORE']['days']['saturday'] ?></th>
                                                                          <?php
                                                                          if(USER_WEEKSTARTS == 'M')
                                                                          {
                                                                            echo '<th class="text-center">'.$lang['CORE']['days']['sunday'].'</th>';
                                                                          }
                                                                          ?>
                                                                      </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                            if($calendar == 'NO_CALENDAR')
                                                                            {
                                                                                for($i = 0; $i < 24; $i++)
                                                                                {
                                                                                    echo '<tr>';
                                                                                    for($a = 0; $a <= 7; $a++)
                                                                                    {
                                                                                        if($i < 10)
                                                                                        {
                                                                                            $stri = '0'.$i;
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $stri = $i;
                                                                                        }

                                                                                        if(USER_WEEKSTARTS != 'S' && $a == 7)
                                                                                        {
                                                                                            $a = 1;
                                                                                            $breakAfter = true;
                                                                                        }
                                                                                        elseif($a == 7)
                                                                                        {
                                                                                            break;
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $breakAfter = false;
                                                                                        }
                                                                                        
                                                                                        echo '<td class="text-center">'.$stri.':<input type="number" class="calendarHour" value="00"/></td>';
                                                                                    
                                                                                        if($breakAfter)
                                                                                        {
                                                                                            break;
                                                                                        }   
                                                                                    }
                                                                                    echo '</tr>';
                                                                                }
                                                                            }
                                                                            elseif(is_array($calendar))
                                                                            {
                                                                                for($i = 0; $i < 24; $i++)
                                                                                {
                                                                                    echo '<tr>';
                                                                                    for($a = 0; $a <= 7; $a++)
                                                                                    {
                                                                                        if(USER_WEEKSTARTS == 'M' && $a == 0)
                                                                                        {
                                                                                            $a++;
                                                                                        }
                                                                                        if($i < 10)
                                                                                        {
                                                                                            $stri = '0'.$i;
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $stri = $i;
                                                                                        }

                                                                                        if(USER_WEEKSTARTS == 'M' && $a == 7)
                                                                                        {
                                                                                            $a = 0;
                                                                                            $break = true;
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $break = false;
                                                                                        }
                                                                                        $keyindex = -1;
                                                                                        for($x = 0;$x < count($calendar['days'][$a]);$x++)
                                                                                        {
                                                                                            if(strpos($calendar['days'][$a][$x],$stri.'.') !== false)
                                                                                            {
                                                                                                $keyindex = $x;
                                                                                            }
                                                                                        }
                                                                                        if($keyindex != -1)
                                                                                        {
                                                                                            $found = true;
                                                                                            $min = (int)explode('.',$calendar['days'][$a][$keyindex])[1];
                                                                                            if($min < 10)
                                                                                            {
                                                                                                $min = '0'.$min;
                                                                                            }
                                                                                            $lengthPrev = explode('--',$calendar['days'][$a][$keyindex]);
                                                                                            if(count($lengthPrev) > 1)
                                                                                            {
                                                                                                $length = $lengthPrev[1];
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                $length = config('session.defaultlenghtmins');
                                                                                            }
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $found = false;
                                                                                            $min = '00';
                                                                                            $length = config('session.defaultlenghtmins');
                                                                                        }
                                                                                        echo '<td data-weekday="'.$a.'" data-hour="'.$stri.'" class="text-center calendarTime'.($found ? ' calendarSelected':'').'">'.$stri.':<input type="number" min="0" max="59" class="calendarHour" value="'.$min.'"/>'.($found ? '<div class="form-group calendarSelectLength"><select class="form-control"><option value="30"'.($length == 30 ? ' selected':'').'>30 '.$lang['home']['profile']['calendar']['editor']['sesslenghtmin'].'</option><option value="60"'.($length == 60 ? ' selected':'').'>60 '.$lang['home']['profile']['calendar']['editor']['sesslenghtmin'].'</option></select></div>':'').'</td>'; 
                                                                                    
                                                                                        if($break)
                                                                                        {
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                    echo '</tr>';
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                echo '<h1>'.$lang['home']['profile']['editorProf']['calendar']['error'].'</h1>.';
                                                                            }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }
                                                if($incomingSessions->num_rows > 0)
                                                {
                                                ?>
                                                <section id="nextsessions" class="skills-sec sec-pad-top-sm">
                                                    <div class="row">
                                                        <h1><?php echo $lang['home']['profile']['nextsessions'] ?></h1>
                                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                            <?php
                                                            $seesid = 0;
                                                            while($sess = $incomingSessions->fetch_array())
                                                            {
                                                                echo '<div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="heading'.$seesid.'">
                                                                  <h4 class="panel-title">
                                                                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$seesid.'" aria-expanded="'.($seesid == 0 ? 'true':'false').'" aria-controls="collapse'.$seesid.'">
                                                                    '.date('d/m/Y - H:i',$sess['timestamp']).'
                                                                  </a>
                                                                </h4>
                                                                </div>
                                                                <div id="collapse'.$seesid.'" class="panel-collapse collapse'.($seesid == 0 ? ' in':'').'" role="tabpanel" aria-labelledby="heading'.$seesid.'">
                                                                  <div class="panel-body">
                                                                    <strong>'.$lang['home']['profile']['menu']['sessionsnexttexts']['psico'].'</strong>: '.$sess['name'].' '.$sess['surnames'].'<br>
                                                                    <strong>'.$lang['home']['profile']['menu']['sessionsnexttexts']['pat'].'</strong>: '.$lang['DB']['treatments'][$sess['key']].'<br>
                                                                    <strong>'.$lang['home']['profile']['menu']['sessionsnexttexts']['sessionlength'].'</strong>: '.$sess['sessionlengthmins'].' '.$lang['CORE']['time.elapsed.minutes'].'
                                                                  </div>
                                                                </div>
                                                              </div>';
                                                                $seesid++;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </section>
                                                <?php } 
                                                if(!USER_TYPE_CLIENT && $incomingSessionsToDo->num_rows > 0)
                                                {
                                                ?>
                                                <section id="nextsessions" class="skills-sec sec-pad-top-sm">
                                                    <div class="row">
                                                        <h1><?php echo $lang['home']['profile']['nextsessionspsico'] ?></h1>
                                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                            <?php
                                                            $seesid = 0;
                                                            while($sess = $incomingSessions->fetch_array())
                                                            {
                                                                echo '<div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="heading'.$seesid.'">
                                                                  <h4 class="panel-title">
                                                                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$seesid.'" aria-expanded="'.($seesid == 0 ? 'true':'false').'" aria-controls="collapse'.$seesid.'">
                                                                    '.date('d/m/Y - H:i',$sess['timestamp']).'
                                                                  </a>
                                                                </h4>
                                                                </div>
                                                                <div id="collapse'.$seesid.'" class="panel-collapse collapse'.($seesid == 0 ? ' in':'').'" role="tabpanel" aria-labelledby="heading'.$seesid.'">
                                                                  <div class="panel-body">
                                                                    <strong>'.$lang['home']['profile']['menu']['sessionsnexttexts']['client'].'</strong>: '.$sess['name'].' '.$sess['surnames'].'<br>
                                                                    <strong>'.$lang['home']['profile']['menu']['sessionsnexttexts']['pat'].'</strong>: '.$lang['DB']['treatments'][$sess['key']].'<br>
                                                                    <strong>'.$lang['home']['profile']['menu']['sessionsnexttexts']['sessionlength'].'</strong>: '.$sess['sessionlengthmins'].' '.$lang['CORE']['time.elapsed.minutes'].'
                                                                  </div>
                                                                </div>
                                                              </div>';
                                                                $seesid++;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </section>
                                                <?php } ?>
						<section id="status" class="skills-sec sec-pad-top-sm">
							<div class="row">
                                                            <?php
                                                            if($db->query('SELECT uid FROM users_status WHERE uid='.USER_ID)->num_rows > 0)
                                                            {
                                                                $chartValues = $db->query('SELECT * FROM users_status WHERE uid='.USER_ID)->fetch_array();
                                                            }
                                                            else
                                                            {
                                                                $chartValues = array('ihap' => 0, 'istr' => 0, 'imot' => 0, 'ahap' => 0, 'astr' => 0, 'amot' => 0);
                                                                echo '<h1><a [routerLink]="[\'/Test\']">'.$lang['home']['profile']['status']['nodata'].'</a></h1>';
                                                            }
                                                            ?>
								<div class="col-sm-6 mb-30">
									<h2 class="mb-30"><?php echo $lang['home']['profile']['status']['firsttime'] ?></h2>
									<div class="mdl-card mdl-shadow--2dp">
										<div class="mb-30">
											<span class="progress-cat"><?php echo $lang['home']['profile']['status']['happiness'] ?></span>
											<div class="progress-bar-graph"> 
												<div class="progress-bar-wrap">
													<div class="bar-wrap blue-bar">
														<span data-width="<?php echo $chartValues['ihap'] ?>"></span>
													</div>
												</div>	
											</div>
										</div>	
										<div class="mb-30">
											<span class="progress-cat"><?php echo $lang['home']['profile']['status']['stress'] ?></span>
											<div class="progress-bar-graph"> 
												<div class="progress-bar-wrap">
													<div class="bar-wrap green-bar">
														<span data-width="<?php echo $chartValues['istr'] ?>"></span>
													</div>
												</div>	
											</div>
										</div>
										<div class="mb-30">
											<span class="progress-cat"><?php echo $lang['home']['profile']['status']['motivation'] ?></span>
											<div class="progress-bar-graph"> 
												<div class="progress-bar-wrap">
													<div class="bar-wrap yellow-bar">
														<span data-width="<?php echo $chartValues['imot'] ?>"></span>
													</div>
												</div>	
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6 mb-30">
									<h2 class="mb-30"><?php echo $lang['home']['profile']['status']['now'] ?></h2>
										<div class="mdl-card mdl-shadow--2dp">
										<div class="mb-30">
											<span class="progress-cat"><?php echo $lang['home']['profile']['status']['happiness'] ?></span>
											<div class="progress-bar-graph"> 
												<div class="progress-bar-wrap">
													<div class="bar-wrap blue-bar">
														<span data-width="<?php echo $chartValues['ahap'] ?>"></span>
													</div>
												</div>	
											</div>
										</div>	
										<div class="mb-30">
											<span class="progress-cat"><?php echo $lang['home']['profile']['status']['stress'] ?></span>
											<div class="progress-bar-graph"> 
												<div class="progress-bar-wrap">
													<div class="bar-wrap green-bar">
														<span data-width="<?php echo $chartValues['astr'] ?>"></span>
													</div>
												</div>	
											</div>
										</div>
										<div class="mb-30">
											<span class="progress-cat"><?php echo $lang['home']['profile']['status']['motivation'] ?></span>
											<div class="progress-bar-graph"> 
												<div class="progress-bar-wrap">
													<div class="bar-wrap yellow-bar">
														<span data-width="<?php echo $chartValues['amot'] ?>"></span>
													</div>
												</div>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>
			
						<?php
                                                if($db->query('SELECT uid FROM users_patologies WHERE uid='.USER_ID)->num_rows > 0)
                                                {
                                                    echo '<section id="diagnosis" class="interest-sec sec-pad-top-sm">
							<h2 class="mb-30">'.$lang['home']['profile']['patologies']['title'].'</h2>
                                                        
							<div class="row">';
                                                    $patologies = $db->query('SELECT p.langkey,p.type FROM users_patologies up JOIN patologies p ON up.patid=p.id WHERE up.uid='.USER_ID.' ORDER BY up.grade DESC LIMIT 6');
                                                    while($row = $patologies->fetch_row())
                                                    {
                                                        echo '<div class="col-md-2 col-sm-4 col-xs-6 mb-30">
                                                                            <div class="mdl-card mdl-shadow--2dp text-center pa-20 pt-30 pb-30">
                                                                                    <i class="'.($row[1] == 'coach' ? 'fa fa-wheelchair-alt':'fa fa-users').'"></i>
                                                                                    <span>'.$lang['DB']['treatments'][$row[0]].'</span>
                                                                            </div>
                                                                    </div>';	
                                                    }
							echo '</div>
						</section>';
                                                }
                                                ?>
						
                                                <?php
                                                if($db->query('SELECT user_id FROM users_psicos_sessions WHERE timestamp<'.time().' AND user_id='.USER_ID)->num_rows > 0)
                                                {
                                                    echo '<section id="sessions" class="education-sec sec-pad-top-sm">
                                                            <h2 class="mb-30">'.$lang['home']['profile']['sessions']['title'].'</h2>
                                                            <div class="timeline-wrap overflow-hide mb-30">
                                                                    <ul class="timeline">';
                                                    $sessions = $db->query('SELECT p.langkey,ups.timestamp,u.name,u.surnames FROM users_psicos_sessions ups JOIN patologies p ON ups.patid=p.id JOIN users u ON u.id=ups.psico_id WHERE ups.timestamp<'.time().' AND user_id='.USER_ID.' ORDER BY timestamp DESC');
                                                    $colorCount = 0;
                                                    $mixingCount = 0;
                                                    $colorArray = ['blue','green','yellow','red'];
                                                    while($row = $sessions->fetch_array())
                                                    {
                                                        if($colorCount > count($colorArray)-1)
                                                        {
                                                            $colorCount = 0;
                                                        }
                                                        echo '<li'.(($mixingCount % 2)?'':' class="timeline-inverted"').'>
                                                                <div class="timeline-badge bg-'.$colorArray[$colorCount].' no-icon"></div>
                                                                <div class="timeline-panel mdl-card mdl-shadow--2dp pt-30 pb-30 border-top-'.$colorArray[$colorCount].'">
                                                                        <div class="timeline-heading">
                                                                                <h4 class="mb-10">'.$lang['DB']['treatments'][$row['langkey']].'</h4>
                                                                                <span class="duration mb-5">'.$core->timeElapsed($row['timestamp']).'</span>
                                                                                <span class="institution">'.$lang['home']['profile']['testimonials']['to'].': <b>'.$row['name'].' '.$row['surnames'].'</b></span>
                                                                        </div>
                                                                </div>
                                                            </li>';
                                                        $colorCount++;
                                                        $mixingCount++;
                                                    }
                                                                            echo '<li class="clearfix no-float"></li>
                                                                    </ul>
                                                            </div>
                                                    </section>';
                                                    }
                                                    ?>
                                                    
						<?php 
                                                if($db->query('SELECT id FROM testimonials WHERE uid='.USER_ID)->num_rows > 0)
                                                {?>
                                                    <section id="testimonials" class="reference-sec sec-pad-top-sm">
                                                            <h2 class="mb-30"><?php echo $lang['home']['profile']['testimonials']['title'] ?></h2>
                                                            <div class="row">
                                                                    <div class="col-sm-12 mb-30">
                                                                            <div class="mdl-card mdl-shadow--2dp border-top-yellow pa-35">
                                                                                    <div class="testimonial-carousel">
                                                                                        <?php
                                                                                        $testimonials = $db->query('SELECT t.content,t.timestamp,u.name,u.surnames FROM testimonials t JOIN users u ON u.id=t.pid WHERE uid='.USER_ID) or die($db->error);
                                                                                        while($row = $testimonials->fetch_array())
                                                                                        {
                                                                                            echo '<div>
                                                                                                    <blockquote>'.$row['content'].'</blockquote>
                                                                                                    <span class="ref-name block mb-5 mt-20">'.$lang['home']['profile']['testimonials']['to'].': <b>'.$row['name'].' '.$row['surnames'].'</b></span>
                                                                                                    <span class="ref-desgn block">'.$core->timeElapsed($row['timestamp']).'</span>
                                                                                            </div>';
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="clearfix"></div>
                                                                            </div>
                                                                    </div>
                                                            </div>

                                                    </section>
                                                <?php } ?>
						
					
					</div>
				</div>	
				<!--/Main Content-->
				
			</div>	
		</div>	
		<!--/Main Wrapper-->