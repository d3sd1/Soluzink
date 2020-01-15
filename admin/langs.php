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
if(!isset($_GET['type']) || !isset($_GET['langkey']) || !array_key_exists($_GET['langkey'],array_flip(config('langs.avaliable'))))
{
	header('Location: '.URL.'/start');
	die();
}
function str_replace_once($str_pattern, $str_replacement, $string){

    if (strpos($string, $str_pattern) !== false){
        $occurrence = strpos($string, $str_pattern);
        return substr_replace($string, $str_replacement, strpos($string, $str_pattern), strlen($str_pattern));
    }

    return $string;
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
        <title><?php echo $alang['title.langs'] ?></title>
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
        <script src="<?php echo URL ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/global/scripts/jquery.editablediv.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo BASEURL ?>/favicon.ico" /> </head>
    <!-- END HEAD -->
<?php
function checkIfArrayIsEmpty($array)
{
    foreach($array as $val)
    {
        if($val == null || $val == '')
        {}
        else 
        {
            return false;
            break;
        }
    }
    return true;
}
?>
    <body class="" data-toggle="context" data-target="#context-menu">
        <!-- BEGIN HEADER -->
        <header class="page-header">
            <nav class="navbar" role="navigation">
                <div class="container-fluid">
                    <div class="havbar-header">
                        <!-- BEGIN LOGO -->
                        
                            <div class="logo"> <a href="http://localhost" style="opacity: 1;"> Soluzink </a> </div>
                        <!-- END LOGO -->
                        <!-- BEGIN TOPBAR ACTIONS -->
                        <div class="topbar-actions">
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
                        <li><a href="<?php echo URL ?>/start"><?php echo $alang['path.start'] ?></a></li>
						<li><?php echo $alang['path.langs'] ?></li>
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
                        <?php echo $admin->menu('langs.'.$_GET['type'],'langs.'.$_GET['langkey']); ?>
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <div class="page-fixed-main-content">
					
					<h1><?php echo $alang['langedit.h1'].': <b>'.$_GET['type'].' '.strtoupper($_GET['langkey']).'</b>' ?></h1>
					<?php
					if(isset($_POST) && count($_POST) > 0)
					{
                                            $finalFile = '<?php'.PHP_EOL;
                                            foreach($_POST as $name => $val)
                                            {
                                                $finalFile .= str_replace(array('(',')','__'),array('[',']','.'),$name).' = \''.html_entity_decode($val).'\';'.PHP_EOL;
                                            }
                                            if($_GET['type'] == 'admin')
                                            {
                                                file_put_contents('kernel/langs/'.$_GET['langkey'].'.php',$finalFile);
                                            }
                                            else
                                            {
                                                file_put_contents(subfolder.'/kernel/langs/'.$_GET['langkey'].'.php',$finalFile);
                                            }
                                            $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("LANG_UPDATED",INET_ATON(\''.USER_IP.'\'),(SELECT id FROM admin_users WHERE email="'.ADMIN_EMAIL.'"),"'.time().'")');   
                                             echo '<div class="alert alert-success fade in alert-dismissable" style="margin-top:18px;">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">Ãƒâ€”</a>
                                                    <strong>'.$alang['langedit.success.title'].'</strong> '.$alang['langedit.success.desc'].'
                                            </div>';
						
					}
                                        ?>
					<form method="post">
                                        <?php 
                                        if($_GET['type'] == 'admin')
                                        {
                                            $lang = $alang;
                                            $langVar = '$alang';
                                        }
                                        else
                                        {
                                            $langVar = '$lang';
                                        }
					foreach($lang as $key => $val)
					{
                                                if(is_array($val))
                                                {
                                                    $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($val), RecursiveIteratorIterator::SELF_FIRST);
                                                    foreach ($iterator as $k => $v) {
                                                        $indent = str_repeat('&nbsp;', 10 * $iterator->getDepth());
                                                        if (!$iterator->hasChildren()) {
                                                            for ($p = array(), $i = 0, $z = $iterator->getDepth(); $i <= $z; $i++) {
                                                                $p[] = $iterator->getSubIterator($i)->key();
                                                            }
                                                            $path = $langVar.'[\''.$key.'\']';
                                                            foreach($p as $pathVal)
                                                            {
                                                                $path .= '[\''.$pathVal.'\']';
                                                            }
                                                            if($key != null)
                                                            {
                                                                /*if(stristr($path,$langVar.'[\'pagetitle\']') !== FALSE)
                                                                {
                                                                    $goForPageInfo = 'TÃƒÂ­tulos de las pÃƒÂ¡ginas';
                                                                }
                                                                else if(stristr($path,$langVar.'[\'META\']') !== FALSE)
                                                                {
                                                                    $goForPageInfo = 'Metadatos de las pÃƒÂ¡ginas';
                                                                }
                                                                else if(stristr($path,$langVar.'[\'DB\']') !== FALSE)
                                                                {
                                                                    $goForPageInfo = 'Elementos de la base de datos';
                                                                }
                                                                else if(stristr($path,$langVar.'[\'CONFIG\']') !== FALSE)
                                                                {
                                                                    $goForPageInfo = 'Metadatos del lenguaje de programaciÃƒÂ³n';
                                                                }
                                                                else
                                                                {
                                                                    $goForPageInfo = 'SecciÃƒÂ³n desconocida';
                                                                }*/
                                                                $finalVal = $v;
                                                                $filterings = array('varComplete1' => "/{{(.*?)}}(.*){{\/(.*?)}}/", 'varSingle1' => "/{{(.*?)}}/", 'varTag' => "/<(.*?)>(.*)<\/(.*?)>/", 'varSingle2' => "/{(.*?)}/", 'varTagSingle' => "/<(.*?)>/", 'varTagSingleClose' => "/<\/(.*?)>/");

                                                                $finalValFix = $finalVal;
                                                                foreach($filterings as $var => $regex)
                                                                {
                                                                    $i = 0;
                                                                    while(preg_match($regex ,$finalValFix,$returnContent))
                                                                    {
                                                                        if($i > 10)
                                                                        {
                                                                            break;
                                                                        }
                                                                        $i++;
                                                                        if(count($returnContent) > 0)
                                                                        {
                                                                            switch($var)
                                                                            {
                                                                                case 'varComplete1':
                                                                                    $finalVal = str_replace('{{'.$returnContent[1].'}}'.$returnContent[2].'{{/'.$returnContent[3].'}}','</span><span class="inputNonEditable">{{'.$returnContent[1].'}}</span><span class="inputEditable">'.$returnContent[2].'</span><span class="inputNonEditable">{{/'.$returnContent[1].'}}</span><span class="inputEditable">',$finalVal);
                                                                                    $finalValFix = preg_replace($regex, null, $finalValFix,1);
                                                                                break;
                                                                                case 'varSingle1':
                                                                                    $finalVal = str_replace('{{'.$returnContent[1].'}}','</span><span class="inputNonEditable">{{'.$returnContent[1].'}}</span><span class="inputEditable">',$finalVal);
                                                                                    $finalValFix = str_replace('{{'.$returnContent[1].'}}',null,$finalValFix);
                                                                                break;
                                                                                case 'varSingle2':
                                                                                    $finalVal = str_replace('{'.$returnContent[1].'}','</span><span class="inputNonEditable">{'.$returnContent[1].'}</span><span class="inputEditable">',$finalVal);
                                                                                    $finalValFix = str_replace('{'.$returnContent[1].'}',null,$finalValFix);
                                                                                break;
                                                                                case 'varTag':
                                                                                    $finalVal = str_replace('<'.$returnContent[1].'>'.$returnContent[2].'</'.$returnContent[3].'>','</span><span class="inputNonEditable">&lt;'.$returnContent[1].'&gt;</span><span class="inputEditable">'.$returnContent[2].'</span><span class="inputNonEditable">&lt;/'.$returnContent[1].'&gt;</span><span class="inputEditable">',$finalVal);
                                                                                    $finalValFix = preg_replace($regex, null, $finalValFix,1);
                                                                                break;
                                                                                case 'varTagSingle':
                                                                                    $finalVal = str_replace('<'.$returnContent[1].'>','</span><span class="inputNonEditable">&lt;'.$returnContent[1].'&gt;</span><span class="inputEditable">',$finalVal);
                                                                                    $finalValFix = str_replace('<'.$returnContent[1].'>',null,$finalValFix);
                                                                                break;
                                                                                case 'varTagSingleClose':
                                                                                    $finalVal = str_replace('</'.$returnContent[1].'>','</span><span class="inputNonEditable">&lt;/'.$returnContent[1].'&gt;</span><span class="inputEditable">',$finalVal);
                                                                                    $finalValFix = str_replace('</'.$returnContent[1].'>',null,$finalValFix);
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                $finalVal = '<span class="inputEditable">'.$finalVal.'</span>';
                                                                $goForPageInfo = null;
                                                                echo '<div class="form-group" style="width: 100%; cursor: pointer"><label><b>'.$goForPageInfo.'</b> - '.$path.' </label><div class="form-control goToFirst">'.$finalVal.'</div>
                                                                  <input type="hidden" class="form-control controlChars" name="'.str_replace(array('[',']','.'),array('(',')','__'),$path).'" value="'.htmlentities($v).'">
                                                                  <div class="input-group-btn">
                                                                        <a href="'.URL.'/langsMgr/'.(($_GET['type'] == 'admin') ? 'admin':'web').'/'.$_GET['langkey'].'/'.$key.'"></a>
                                                                  </div>
                                                                </div><br>';
                                                            }
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    $path = $langVar.'[\''.$key.'\']';
                                                    $finalVal = '<span class="inputEditable">'.$val.'</span>';
                                                                $goForPageInfo = null;
                                                                echo '<div class="form-group" style="width: 100%; cursor: pointer"><label><b>'.$goForPageInfo.'</b> - '.$path.' </label><div class="form-control goToFirst">'.$finalVal.'</div>
                                                                  <input type="hidden" class="form-control controlChars" name="'.str_replace(array('[',']','.'),array('(',')','__'),$path).'" value="'.htmlentities($val).'">
                                                                  <div class="input-group-btn">
                                                                        <a href="'.URL.'/langsMgr/'.(($_GET['type'] == 'admin') ? 'admin':'web').'/'.$_GET['langkey'].'/'.$key.'"></a>
                                                                  </div>
                                                                </div><br>';
                                                }
					}
					?>
					<button style="float: right" type="submit" class="btn btn-primary"><?php echo $alang['langedit.send'] ?></button>
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
        <script src="<?php echo URL ?>/assets/global/plugins/bootstrap-contextmenu/bootstrap-contextmenu.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/assets/pages/scripts/components-context-menu.min.js" type="text/javascript"></script>
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
                
                $(".inputEditable:not(.inputNonEditable)").editableDiv();
                $('.goToFirst').click(function(e)
                {
                    if (e.target !== this)
                    {
                        return;
                    }
                    else
                    {
                        $(this).children('.inputEditable:first-child').focus();
                    }
                });
                $('.inputEditable').blur(function(e)
                {
                    var finalVal = '';
                    $(this).parent().each(function(index,element){
                        finalVal += $(element).text();
                    });
                    $(this).parent().parent().children('.controlChars').val(finalVal);
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