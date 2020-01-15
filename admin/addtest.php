<?php require('admin.php');
if(!ADMIN_LOGGED_IN)
{
	header('Location: '.URL.'/login');
        die();
}
if(ADMIN_USER_LOCKED)
{
	header('Location: '.URL.'/locked');
        die();
}
if(isset($_POST) && count($_POST) > 0)
{
    $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("ADDED_TEST",INET_ATON(\''.USER_IP.'\'),(SELECT id FROM admin_users WHERE email="'.ADMIN_EMAIL.'"),"'.time().'")');                
    $db->query("INSERT INTO tests (langkey) VALUES ('')");
    $newTestId = $db->insert_id;
    $db->query("UPDATE tests SET langkey='t".$newTestId."' WHERE id=".$newTestId);
    $finalLangAdd = '';
    $finalLangAdd .= '$lang[\'test\'][\'t'.$newTestId.'\'] = \''.$_POST['testname'].'\';';
    unset($_POST['testname']);
    foreach($_POST as $key => $val)
    {
        if(stristr($key,'quest_'))
        {
            $key = preg_replace('/quest_/','',$key,1);
            $questId = substr($key,0,1);
            $key = preg_replace('/'.$questId.'_/','',$key,1);
            if(stristr($key,'title') && stristr($key,'resp_') === FALSE) // CAMBIAR TITULO
            {
                $db->query('INSERT INTO tests_questions (testid,questid,langkey) VALUES ('.$newTestId.','.$questId.',"test_'.$newTestId.'_quest_'.$questId.'_title")') or die($db->error);
                $finalLangAdd .= '$lang[\'test\'][\'question\'][\'test_'.$newTestId.'_quest_'.$questId.'_title\'] = \''.$val.'\';'.PHP_EOL;
            }
            else
            {
                $key = preg_replace('/resp_/','',$key,1);
                $respId = substr($key,0,1);
                $key = preg_replace('/'.$respId.'_/','',$key,1);
                $query_resp = $db->query('SELECT langkey FROM tests_responses WHERE questid='.$questId.' AND responseid='.$respId);
                if($query_resp->num_rows == 0)
                {
                    $db->query('INSERT INTO tests_responses (responseid,questid,langkey) VALUES ('.$respId.','.$questId.',"t'.$newTestId.'q'.$questId.'response'.$respId.'")') or die($db->error);
                }
                if(stristr($key,'title'))
                {
                    $finalLangAdd .= '$lang[\'test\'][\'response\'][\''.$db->query('SELECT langkey FROM tests_responses WHERE questid='.$questId.' AND responseid='.$respId)->fetch_row()[0].'\'] = \''.$val.'\';'.PHP_EOL;
                }
                elseif(stristr($key,'hap'))
                {
                    $db->query('UPDATE tests_responses SET hap='.$val.' WHERE responseid='.$respId);
                }
                elseif(stristr($key,'str'))
                {
                    $db->query('UPDATE tests_responses SET str='.$val.' WHERE responseid='.$respId);
                }
                elseif(stristr($key,'mot'))
                {
                    $db->query('UPDATE tests_responses SET mot='.$val.' WHERE responseid='.$respId);
                }
                elseif(stristr($key,'assocpatid'))
                {
                    $db->query('UPDATE tests_responses SET associatepatid='.$val.' WHERE responseid='.$respId);
                }
            }
        }
    }
    file_put_contents(subfolder.'/kernel/langs/es.php',file_get_contents(subfolder.'/kernel/langs/es.php').PHP_EOL.$finalLangAdd);
    header('Location: '.URL.'/tests?msg=testadded');
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="<?php echo $alang['meta.lang'] ?>" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="<?php echo $alang['meta.lang'] ?>" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="<?php echo $alang['meta.lang'] ?>">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="<?php echo $alang['meta.encoding'] ?>" />
        <title><?php echo $alang['title.adminsMgr'] ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?php echo $alang['meta.description'] ?>" name="description" />
        <meta content="<?php echo $alang['meta.author'] ?>" name="author" />
        <!-- BEGIN LAYOUT FIRST STYLES -->
        <link href="//fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet" type="text/css" />
        <!-- END LAYOUT FIRST STYLES -->
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo URL ?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo URL ?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo URL ?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo URL ?>/assets/layouts/css/layout.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo BASEURL ?>/favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="" data-toggle="context" data-target="#context-menu">
        <!-- BEGIN HEADER -->
        <header class="page-header">
            <nav class="navbar" role="navigation">
                <div class="container-fluid">
                    <div class="havbar-header">
                        <!-- BEGIN LOGO -->
                            <div class="logo"> <a href="<?php echo URL ?>" style="opacity: 1;"> Soluzink </a> </div>
                        <!-- END LOGO -->
                        <!-- BEGIN TOPBAR ACTIONS -->
                        <div class="topbar-actions">
                            <!-- END HEADER SEARCH BOX -->
                            <!-- BEGIN GROUP NOTIFICATION -->
                            <div class="btn-group-notification btn-group" id="header_notification_bar">
                                <button type="button" class="btn md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" style="margin-right: 10px">
                                    <span class="badge" id="logoutTimer"></span>
                                </button>
                            </div>
                            <!-- END GROUP NOTIFICATION -->
                            <!-- BEGIN USER PROFILE -->
                            <div class="btn-group-img btn-group">
                                <button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img src="<?php echo ADMIN_PHOTO ?>" alt=""> </button>
                                <ul class="dropdown-menu-v2" role="menu">
                                    <?php echo $admin->userMenu() ?>
                                </ul>
                            </div>
                            <!-- END USER PROFILE -->
                        </div>
                        <!-- END TOPBAR ACTIONS -->
                    </div>
                </div>
                <!--/container-->
            </nav>
        </header>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
        <div class="container-fluid">
            <div class="page-content page-content-popup">
                <div class="page-content-fixed-header">
                    <!-- BEGIN BREADCRUMBS -->
                    <ul class="page-breadcrumb">
                        <li><?php echo $alang['path.start'] ?></li>
                    </ul>
                    <!-- END BREADCRUMBS -->
                    <div class="content-header-menu">
                        <!-- BEGIN DROPDOWN AJAX MENU -->
                        <div class="dropdown-ajax-menu btn-group">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <i class="fa fa-circle"></i>
                                <i class="fa fa-circle"></i>
                                <i class="fa fa-circle"></i>
                            </button>
                            <ul class="dropdown-menu-v2">
                                <li>
                                    <a href="<?php echo URL ?>/start"><?php echo $alang['path.menu.start'] ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL ?>/users"><?php echo $alang['path.menu.users'] ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL ?>/config"><?php echo $alang['path.menu.config'] ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL ?>/langsMgr/admin/es"><?php echo $alang['path.menu.langs'] ?></a>
                                </li>
                            </ul>
                        </div>
                        <!-- END DROPDOWN AJAX MENU -->
                        <!-- BEGIN MENU TOGGLER -->
                        <button type="button" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="toggle-icon">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </span>
                        </button>
                        <!-- END MENU TOGGLER -->
                    </div>
                </div>
                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <?php echo $admin->menu('tests'); ?>
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <div class="page-fixed-main-content">
                    <h1>Añadir test</h1>
                    <h2><a href="<?php echo URL ?>/tests" class="btn btn-primary">Ver tests</a></h2>
                    
                    <form method="post">
                        <div class="form-group">
                          <label for="test">Nombre del test</label>
                          <input type="text" class="form-control" placeholder="Introduce aquí el nombre del formulario" autocomplete="off" name="testname">
                        </div>
                        <div class="form-group" style="margin-top:25px" data-questid="1">
                                <label for="test_1"><b>Pregunta 1</b></label>
                                <button type="button" class="btn btn-danger deleteQuestion">Eliminar pregunta 1</button>
                                <input type="text" class="form-control" placeholder="Introduce aquí la pregunta" autocomplete="off" name="quest_1_title">
                                <label for="test_1_resp" class="">Posibles respuestas (Pregunta 1)</label>
                            
                                    <div class="form-inline questResponse" data-respid="1" data-questid="1">
                                            <div class="form-group">
                                                <label for="test_1" class="marginright-resp">Respuesta 1</label>
                                                  <input type="text" class="form-control marginright-resp" placeholder="Respuesta 1" autocomplete="off" name="quest_1_resp_1_title">
                                                </div>
                                                <div class="form-group">
                                                  <label>Felicidad:</label>
                                                  <input type="number" class="form-control numberino" value="0" name="quest_1_resp_1_hap">
                                                </div>
                                                <div class="form-group">
                                                  <label>Estrés:</label>
                                                  <input type="number" class="form-control numberino" value="0" name="quest_1_resp_1_str">
                                                </div>
                                                <div class="form-group">
                                                  <label>Motivación:</label>
                                                  <input type="number" class="form-control numberino" value="0" name="quest_1_resp_1_mot">
                                                </div>
                                                <div class="form-group">
                                                  <label>Patología asociada:</label>
                                                  <select class="form-control" name="quest_1_resp_1_assocpatid"><option value="1" selected="">Ansiedad</option><option value="8">Testeo</option></select>
                                                </div>
                                                <div class="form-group">
                                                  <button type="button" class="btn btn-danger deleteResponse">Eliminar respuesta</button>
                                                </div>
                                            </div>
<button type="button" class="btn btn-primary addResponse">Agregar respuesta</button>
                              </div>
                        <button type="submit" class="btn btn-default">Finalizar test</button>
                        <button type="button" class="btn btn-info addQuestion">Agregar pregunta</button>
                      </form>
                </div>
                <!-- BEGIN FOOTER -->
                <p class="copyright-v2"> <?php echo $alang['footer.copy'] ?></p>
               <?php echo $admin->userSidebar(); ?>
                <?php echo $admin->contextUserMenu(); ?>
        <!--[if lt IE 9]>
<script src="<?php echo URL ?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo URL ?>/assets/global/plugins/excanvas.min.js"></script> 
<script src="<?php echo URL ?>/assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo URL ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo URL ?>/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo URL ?>/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo URL ?>/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/plugins/bootstrap-contextmenu/bootstrap-contextmenu.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/pages/scripts/components-context-menu.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo URL ?>/assets/layouts/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/layouts/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/layouts/scripts/quick-nav.min.js" type="text/javascript"></script>
		<script type="text/javascript">
                    var prevAddedResponses = new Array();
                    $(document).on("click", '.deleteResponse', function(e) {
                        var selectorResp = $(this).parent().parent().parent().children('.questResponse').last(), actualQuest = selectorResp.attr('data-questid');
                        console.log(actualQuest);
                        if(typeof prevAddedResponses[actualQuest] == 'undefined')
                        {
                            prevAddedResponses[actualQuest]--;
                        }
                        $(this).parent().parent().fadeOut(300, function() { $(this).remove(); });
                        $('input[name=\'removedResponses\']').val($('input[name=\'removedResponses\']').val()+actualQuest+',');
                    });
                    $(document).on("click", '.deleteQuestion', function(e) {
                        var actualQuest;
                        $(this).parent().remove().fadeOut(300, function() { $(this).remove(); actualQuest = $(this).attr('data-questid'); });
                        console.log(actualQuest);
                        $('input[name=\'removedQuestions\']').val($('input[name=\'removedQuestions\']').val()+actualQuest+',');
                    });
                    $(document).on("click", '.addResponse', function(e) {
                        var selectorResp = $(this).parent().children('.questResponse').last(), actualQuest = $(this).parent().attr('data-questid');
                        if(isNaN(actualQuest))
                        {
                            actualQuest = 1;
                        }
                        if(typeof prevAddedResponses[actualQuest] == 'undefined')
                        {
                            prevAddedResponses[actualQuest] = 1;
                        }
                        var actualResp = (parseInt(selectorResp.attr('data-respid')) + prevAddedResponses[actualQuest]), actualRealResp = (parseInt(selectorResp.attr('data-realrespid')) + 1 + prevAddedResponses[actualQuest]);
                        if(isNaN(actualResp))
                        {
                            if(!isNaN(prevAddedResponses[actualQuest]))
                            {
                                actualResp = prevAddedResponses[actualQuest];
                            }
                            else
                            {
                                actualResp = 1;
                            }
                        }
                        $(this).before('<div class="form-inline questResponse" data-respid="' + actualResp + '" data-questid="' + actualQuest + '"><div class="form-group"><label for="test_' + actualQuest + '" class="marginright-resp">Respuesta ' + actualResp + '</label><input type="text" class="form-control marginright-resp" placeholder="Respuesta ' + actualResp + ' para la pregunta ' + actualQuest + '" autocomplete="off" name="quest_' + actualQuest + '_resp_' + actualResp + '_title"></div><div class="form-group"><label>Felicidad:</label><input type="number" class="form-control numberino" value="0" name="quest_' + actualQuest + '_resp_' + actualResp + '_hap"></div><div class="form-group"><label>Estrés:</label><input type="number" class="form-control numberino" value="0" name="quest_' + actualQuest + '_resp_' + actualResp + '_str"></div><div class="form-group"><label>Motivación:</label><input type="number" class="form-control numberino" value="0" name="quest_' + actualQuest + '_resp_' + actualResp + '_mot"></div><div class="form-group"><label>Patología asociada:</label><select class="form-control" name="quest_' + actualQuest + '_resp_' + actualResp + '_assocpatid"> <?php $patologies = $db->query('SELECT id,langkey FROM patologies'); while($pat = $patologies->fetch_array()){echo '<option value="'.$pat['id'].'">'.$lang['DB']['treatments'][$pat['langkey']].'</option>';}?></select></div><div class="form-group"><button type="button" class="btn btn-danger deleteResponse">Eliminar respuesta</button></div></div>');
                    });
                    $(document).on("click", '.addQuestion', function(e) {
                        var selectorResp = $(this).parent().children('.form-group').last(),actualQuest = parseInt(selectorResp.attr('data-questid'))+1;
                        if(isNaN(actualQuest))
                        {
                            actualQuest = 1;
                        }
                        $(this).prev('button').before('<div class="form-group" style="margin-top:25px" data-questid="' + actualQuest + '"><label for="test_' + actualQuest + '"><b>Pregunta ' + actualQuest + '</b></label><button type="button" class="btn btn-danger deleteQuestion">Eliminar pregunta ' + actualQuest + '</button><input type="text" class="form-control" placeholder="Título de la pregunta ' + actualQuest + '" autocomplete="off" name="quest_' + actualQuest + '_resp_1_title"><label for="test_' + actualQuest + '_resp" class="">Posibles respuestas (Pregunta ' + actualQuest + ')</label><div class="form-inline questResponse" data-respid="1" data-questid="' + actualQuest + '"><div class="form-group"><label for="test_' + actualQuest + '" class="marginright-resp">Respuesta 1</label><input type="text" class="form-control marginright-resp" placeholder="Respuesta 1 de la pregunta ' + actualQuest + '" autocomplete="off" name="quest_' + actualQuest + '_title"></div><div class="form-group"><label>Felicidad:</label><input type="number" class="form-control numberino" value="0" name="quest_' + actualQuest + '_resp_1_hap"></div><div class="form-group"><label>Estrés:</label><input type="number" class="form-control numberino" value="0" name="quest_' + actualQuest + '_resp_1_str"></div><div class="form-group"><label>Motivación:</label><input type="number" class="form-control numberino" value="0" name="quest_' + actualQuest + '_resp_1_mot"></div><div class="form-group"><label>Patología asociada:</label><select class="form-control" name="quest_' + actualQuest + '_resp_1_assocpatid"><?php $patologies = $db->query('SELECT id,langkey FROM patologies'); while($pat = $patologies->fetch_array()){echo '<option value="'.$pat['id'].'">'.$lang['DB']['treatments'][$pat['langkey']].'</option>';}?></select></div><div class="form-group"><button type="button" class="btn btn-danger deleteResponse">Eliminar respuesta</button></div></div><button type="button" class="btn btn-primary addResponse">Agregar respuesta</button></div>');
                    });
		(function (win)
{
    var _LOCALSTORAGE_KEY = 'WINDOW_VALIDATION';
    var _initialized = false;
    var _isMainWindow = false;
    var _unloaded = false;
    var _windowArray;
    var _windowId;
    var _isNewWindowPromotedToMain = false;
    var _onWindowUpdated;
    function WindowStateManager(isNewWindowPromotedToMain, onWindowUpdated)
    {
        _onWindowUpdated = onWindowUpdated;
        _isNewWindowPromotedToMain = isNewWindowPromotedToMain;
        _windowId = Date.now().toString();
        bindUnload();
        determineWindowState.call(this);
        _initialized = true;
        _onWindowUpdated.call(this);
    }
    function determineWindowState()
    {
        var self = this;
        var _previousState = _isMainWindow;
        _windowArray = localStorage.getItem(_LOCALSTORAGE_KEY);
        if (_windowArray === null || _windowArray === "NaN")
        {
            _windowArray = [];
        }
        else
        {
            _windowArray = JSON.parse(_windowArray);
        }
        if (_initialized)
        {
            if (_windowArray.length <= 1 ||
               (_isNewWindowPromotedToMain ? _windowArray[_windowArray.length - 1] : _windowArray[0]) === _windowId)
            {
                _isMainWindow = true;
            }
            else
            {
                _isMainWindow = false;
            }
        }
        else
        {
            if (_windowArray.length === 0)
            {
                _isMainWindow = true;
                _windowArray[0] = _windowId;
                localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
            }
            else
            {
                _isMainWindow = false;
                _windowArray.push(_windowId);
                localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
            }
        }

        if (_previousState !== _isMainWindow)
        {
            _onWindowUpdated.call(this);
        }
        setTimeout(function()
                   {
                     determineWindowState.call(self);
                   }, 50);
    }
    function removeWindow()
    {
        var __windowArray = JSON.parse(localStorage.getItem(_LOCALSTORAGE_KEY));
        for (var i = 0, length = __windowArray.length; i < length; i++)
        {
            if (__windowArray[i] === _windowId)
            {
                __windowArray.splice(i, 1);
                break;
            }
        }
        localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(__windowArray));
    }
    function bindUnload()
    {
        win.addEventListener('beforeunload', function ()
        {
            if (!_unloaded)
            {
                removeWindow();
            }
        });
        win.addEventListener('unload', function ()
        {
            if (!_unloaded)
            {
                removeWindow();
            }
        });
    }
    WindowStateManager.prototype.isMainWindow = function ()
    {
        return _isMainWindow;
    };
    WindowStateManager.prototype.resetWindows = function ()
    {
        localStorage.removeItem(_LOCALSTORAGE_KEY);
    };
    win.WindowStateManager = WindowStateManager;
})(window);
var WindowStateManager = new WindowStateManager(true, windowUpdated);
var timesCalled = 0;
var windowStatusDisabled = false;
function windowUpdated()
{
    if(this.isMainWindow() === false && timesCalled > 0)
	{
            windowStatusDisabled = true;
            $("#openedSmwElse").modal("show");
            $('body').click(false);
            document.onkeydown = function (e) {
                    return false;
            }
	}
	timesCalled++;
}
		function startTimer(duration, display) {
			var timer = duration, minutes, seconds;
			var myTimer = setInterval(function () {
                            if(windowStatusDisabled == false)
                            {
				minutes = parseInt(timer / 60, 10);
				seconds = parseInt(timer % 60, 10);

				minutes = minutes < 10 ? "0" + minutes : minutes;
				seconds = seconds < 10 ? "0" + seconds : seconds;
				if (timer-- < 0) {
					clearInterval(myTimer);
					window.location.replace("<?php echo URL ?>/locked?ref=timeout");
				}
				else
				{
					display.text(minutes + ":" + seconds);
				}
                            }
			}, 1000);
		}

		jQuery(function ($) {
			startTimer(<?php echo config('admin.session.timeout') ?>, $('#logoutTimer'));
		});
                $('body').click(function (e){  
                    if (e.ctrlKey) {
                        return false;
                    }
                });
		</script>
        <!-- END THEME LAYOUT SCRIPTS -->
</body>
</html>