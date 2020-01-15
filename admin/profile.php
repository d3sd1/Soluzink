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
        <title><?php echo $alang['title.profile'] ?></title>
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
        <link href="<?php echo URL ?>/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo URL ?>/assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css" />
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
                        <?php echo $admin->menu('NONE'); ?>
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <div class="page-fixed-main-content">
                    <div class="profile">
                        <div class="tabbable-line tabbable-full-width">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab"> <?php echo $alang['profile.menu.general'] ?> </a>
                                </li>
                                <li>
                                    <a href="#tab_1_3" data-toggle="tab"> <?php echo $alang['profile.menu.edit'] ?> </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <ul class="list-unstyled profile-nav">
                                                <li>
                                                    <img src="<?php echo ADMIN_PHOTO ?>" class="img-responsive pic-bordered" alt="" />
                                                    <a onClick="javascript:$('.nav-tabs li:eq(1) a').tab('show') + $('.ver-inline-menu li:eq(1) a').tab('show')" data-toggle="tab" class="profile-edit"> <?php echo $alang['profile.image.edit'] ?> </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo URL ?>/calendar"> <?php echo $alang['profile.submenu.calendar'] ?> <?php if(ADMIN_CALENDARNOTS > 0) { echo '<span> '.ADMIN_CALENDARNOTS.' </span>'; } ?></a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo URL ?>/tasks"> <?php echo $alang['profile.submenu.tasks'] ?> <?php if(ADMIN_TASKSNOTS > 0) { echo '<span> '.ADMIN_TASKSNOTS.' </span>'; } ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-8 profile-info">
                                                    <h1 class="font-green sbold uppercase"><?php echo ADMIN_NAME ?></h1>
                                                    <p><?php echo str_replace(array('{date}','{adminAdd}'),array(date('d/m/Y',ADMIN_ADDEDDATE),$db->query('SELECT user FROM admin_users WHERE id='.ADMIN_ADDEDBY)->fetch_row()[0]),$alang['profile.admInfo']) ?></p>
                                                    <p>
                                                        <?php echo $alang['profile.website'] ?>: <a href="<?php echo BASEURL ?>"> <?php echo BASEURL ?> </a>
                                                    </p>
                                                    <ul class="list-inline">
                                                        <li>
                                                            <i class="fa fa-map-marker"></i> <?php echo ADMIN_LOCCITY ?> </li>
                                                        <li>
                                                            <i class="fa fa-desktop"></i> <?php echo ADMIN_IP ?> </li>
                                                        <li>
                                                            <i class="fa fa-briefcase"></i> <?php echo $alang['adminRange.'.ADMIN_RANGE] ?> </li>
                                                    </ul>
                                                </div>
                                                <!--end col-md-8-->
                                                <div class="col-md-4">
                                                    <div class="portlet sale-summary">
                                                        <div class="portlet-title">
                                                            <div class="caption font-red sbold"> <?php echo $alang['profile.logs.head.summary'] ?> </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <ul class="list-unstyled">
                                                                <li>
                                                                    <span class="sale-info"> <?php echo $alang['profile.logs.head.lastLogin'] ?>
                                                                        <i class="fa fa-img-up"></i>
                                                                    </span>
                                                                    <span class="sale-num"> <?php echo $core->timeElapsed(ADMIN_LASTLOGIN) ?> </span>
                                                                </li>
                                                                <li>
                                                                    <span class="sale-info"> <?php echo $alang['profile.logs.head.email'] ?>
                                                                        <i class="fa fa-img-down"></i>
                                                                    </span>
                                                                    <span class="sale-num"> <?php echo ADMIN_EMAIL ?> </span>
                                                                </li>
                                                                <li>
                                                                    <span class="sale-info"> <?php echo $alang['profile.logs.head.lang'] ?> </span>
                                                                    <span class="sale-num"> <?php echo strtoupper(ADMIN_LANG) ?> </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end col-md-4-->
                                            </div>
                                            <!--end row-->
                                            <div class="tabbable-line tabbable-custom-profile">
                                                        <div class="portlet-body">
                                                            <table class="table table-striped table-bordered table-advance table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <i class="fa fa-id-badge"></i> <?php echo $alang['profile.logs.head.ip'] ?> </th>
                                                                        <th class="hidden-xs">
                                                                            <i class="fa fa-calendar"></i> <?php echo $alang['profile.logs.head.date'] ?> </th>
                                                                        <th>
                                                                            <i class="fa fa-info-circle"></i> <?php echo $alang['profile.logs.head.desc'] ?> </th>
                                                                        <th> </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                    $logData = $db->query('SELECT al.type,INET_NTOA(al.ip),au.user,al.timestamp FROM admin_logs al JOIN admin_users au ON al.userId=au.id WHERE al.userId="'.ADMIN_ID.'" ORDER BY al.timestamp DESC LIMIT '.config('admin.logs.maxtoshow'));
                                                    while($thisLog = $logData->fetch_row())
                                                    {
                                                        $iconGet = 'dot-circle-o';
                                                        if(stristr($thisLog[0],'LOGIN') !== FALSE)
                                                        {
                                                            $iconGet = 'sign-in';
                                                        }
                                                        else if(stristr($thisLog[0],'LOGOUT') !== FALSE)
                                                        {
                                                            $iconGet = 'sign-out';
                                                        }
                                                        else if(stristr($thisLog[0],'LOCKED') !== FALSE)
                                                        {
                                                            $iconGet = 'lock';
                                                        }
                                                        
                                                        if(stristr($thisLog[0],'ERROR') !== FALSE || stristr($thisLog[0],'FAILED') !== FALSE)
                                                        {
                                                            $iconColor = 'danger';
                                                        }
                                                        elseif(stristr($thisLog[0],'SUCCESS') !== FALSE)
                                                        {
                                                            $iconColor = 'success';
                                                        }
                                                        elseif(stristr($thisLog[0],'LOCKED') !== FALSE)
                                                        {
                                                            $iconColor = 'warning';
                                                        }
                                                        else
                                                        {
                                                            $iconColor = 'info';
                                                        }
                                                        echo '<tr>
                                                                        <td>
                                                                            <a href="javascript:;"> '.$thisLog[1].' </a>
                                                                        </td>
                                                                        <td class="hidden-xs"> '.$core->timeElapsed($thisLog[3]).' </td>
                                                                        <td> 
                                                                            <span class="label label-sm label-'.$iconColor.'"> <i class="fa fa-'.$iconGet.'"></i> '.$alang['log.'.str_replace('_','.',$thisLog[0])].' </span>
                                                                        </td>
                                                                    </tr>';
                                                    }
                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--tab_1_2-->
                                <div class="tab-pane" id="tab_1_3">
                                    <div class="row profile-account">
                                        <div class="col-md-3">
                                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#tab_1-1">
                                                        <i class="fa fa-cog"></i> <?php echo $alang['profile.edit.personalinfo'] ?> </a>
                                                    <span class="after"> </span>
                                                </li>
                                                <li>
                                                    <a data-toggle="tab" href="#tab_2-2">
                                                        <i class="fa fa-picture-o"></i> <?php echo $alang['profile.edit.photo'] ?> </a>
                                                </li>
                                                <li>
                                                    <a data-toggle="tab" href="#tab_3-3">
                                                        <i class="fa fa-lock"></i> <?php echo $alang['profile.edit.password'] ?> </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="tab-content">
                                                <div id="tab_1-1" class="tab-pane active">
                                                    <form role="form" method="POST">
                                                        <div class="form-group">
                                                            <?php
                                                            if(isset($_POST['editOn']) && $_POST['editOn'] == 'editUser')
                                                            {
                                                                if(isset($_POST['userCurrentPass']) && $_POST['userCurrentPass'] != null && md5($core->crypt($_POST['userCurrentPass'])) == ADMIN_CRYPTPASS && isset($_POST['newUserName']) && $_POST['newUserName'] != null && !preg_match('#[^\p{L}\s- ]#u',$_POST['newUserName']) && isset($_POST['newUserEmail']) && $_POST['newUserEmail'] != null && filter_var($_POST['newUserEmail'], FILTER_VALIDATE_EMAIL))
                                                                {
                                                                    $db->query('UPDATE admin_users SET email="'.$_POST['newUserEmail'].'", user="'.$_POST['newUserName'].'" WHERE id='.ADMIN_ID) or die($db->error);
                                                                    define('ADMIN_NAME_U',$_POST['newUserName']);
                                                                    define('ADMIN_EMAIL_U',$_POST['newUserEmail']);
                                                                    echo  '<div class="alert alert-success fade in alert-dismissable">
                                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                                                    <strong>'.$alang['profile.edit.success'].'</strong> '.$alang['profile.edit.success.user'].'
                                                                    </div>'; 
                                                                    $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("PROFILE_UPDATE_SUCCESS",INET_ATON(\''.USER_IP.'\'),'.ADMIN_ID.',"'.time().'")');
                                                                }
                                                                else
                                                                {
                                                                    echo  '<div class="alert alert-danger fade in alert-dismissable">
                                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                                                    <strong>'.$alang['profile.edit.error'].'</strong> '.$alang['profile.edit.error.user'].'
                                                                    </div>'; 
                                                                    $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("PROFILE_UPDATE_ERROR",INET_ATON(\''.USER_IP.'\'),'.ADMIN_ID.',"'.time().'")');
                                                                }
                                                            }
                                                            ?>
                                                            <input type="hidden" name="editOn" value="editUser">
                                                            
                                                            <label class="control-label"><?php echo $alang['profile.edit.user.name'] ?></label>
                                                            <input type="text" name="newUserName" autocomplete="off" value="<?php echo (!defined('ADMIN_NAME_U') ? ADMIN_NAME:ADMIN_NAME_U); ?>" class="form-control" />
                                                            
                                                            <label class="control-label"><?php echo $alang['profile.edit.user.email'] ?></label>
                                                            <input type="text" name="newUserEmail" autocomplete="off" value="<?php echo (!defined('ADMIN_EMAIL_U') ? ADMIN_EMAIL:ADMIN_EMAIL_U); ?>" class="form-control" />
                                                            
                                                            <label class="control-label"><?php echo $alang['profile.edit.user.actualPass'] ?></label>
                                                            <input type="password" name="userCurrentPass" placeholder="******" class="form-control" /> </div>
                                                        
                                                        <div class="margiv-top-10">
                                                            <a href="#" onclick="$(this).closest('form').submit()" class="btn green"> <?php echo $alang['profile.edit.change'] ?> </a>
                                                            <a href="#" onclick="$(this).closest('form').find('input[name=newUserName]').val('<?php echo ADMIN_NAME ?>');$(this).closest('form').find('input[name=newUserEmail]').val('<?php echo ADMIN_EMAIL ?>');$(this).closest('form').find('input[name=userCurrentPass]').val('')" class="btn default"> <?php echo $alang['profile.edit.cancel'] ?> </a>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div id="tab_2-2" class="tab-pane">
                                                   <?php
                                                    if(isset($_POST['editOn']) && $_POST['editOn'] == 'editPhoto')
                                                            {
                                                                ini_set('post_max_size', '512M');
                                                                if(isset($_POST['formSentUpdateBg']))
                                                                {
                                                                    $imageBaseDir = BASEDIR.'/admin/assets/img/profile/'.ADMIN_ID;
                                                                    $target_file = $imageBaseDir.'/'.$_FILES['newUImage']['name'];
                                                                    $objects = scandir($imageBaseDir); 
                                                                    foreach ($objects as $object) { 
                                                                      if ($object != "." && $object != "..") { 
                                                                        if (is_dir($imageBaseDir."/".$object))
                                                                          rrmdir($imageBaseDir."/".$object);
                                                                        else
                                                                          unlink($imageBaseDir."/".$object); 
                                                                      } 
                                                                    }
                                                                    $uploadOk = 1;
                                                                    if (@$_FILES["newUImage"]["size"] > 536870912) {
                                                                        echo '<div class="alert alert-danger">
                                                                      <strong>'.$alang['profile.image.errorUpload'].'</strong> '.$alang['profile.image.errorUploadSize.desc'].'
                                                                    </div>';
                                                                        $uploadOk = 0;
                                                                    }
                                                                    if ($uploadOk != 0) {
                                                                        if (move_uploaded_file($_FILES["newUImage"]["tmp_name"], $target_file)) {
                                                                            echo '<div class="alert alert-success">
                                                                      <strong>'.$alang['profile.image.successUpload'].'</strong> '.$alang['profile.image.successUpload.desc'].'
                                                                    </div>';
                                                                    $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("PROFILE_UPDATE_SUCCESS",INET_ATON(\''.USER_IP.'\'),'.ADMIN_ID.',"'.time().'")');
                                                                        } else {
                                                                            echo '<div class="alert alert-danger">
                                                                      <strong>'.$alang['profile.image.errorUpload'].'</strong> '.$alang['profile.image.errorUpload.desc'].'
                                                                    </div>';
                                                                    $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("PROFILE_UPDATE_ERROR",INET_ATON(\''.USER_IP.'\'),'.ADMIN_ID.',"'.time().'")');
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                       ?>
                                    <form id="indexBgVideo" class="form-horizontal form-bordered" enctype="multipart/form-data" method="POST">
                                        <input type="hidden" name="editOn" value="editPhoto">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo $alang['profile.image.url'] ?></label>
                                                <div class="col-md-3">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="input-group input-large">
                                                            <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                <span class="fileinput-filename"> </span>
                                                            </div>
                                                            <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> <?php echo $alang['profile.image.select'] ?> </span>
                                                                <span class="fileinput-exists"> <?php echo $alang['profile.image.change'] ?> </span>
                                                                <input type="hidden" name="formSentUpdateBg" value="true"><input type="file" name="newUImage" accept="image/*"> </span>
                                                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> <?php echo $alang['profile.image.remove'] ?> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <a href="javascript:document.getElementById('indexBgVideo').submit();"  class="btn green">
                                                        <i class="fa fa-check"></i> <?php echo $alang['profile.edit.change'] ?></a>
                                                    <a href="javascript:;" class="btn btn-outline grey-salsa"><?php echo $alang['profile.edit.cancel'] ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </form>
                                                </div>
                                                <div id="tab_3-3" class="tab-pane">
                                                    <form action="#" method="POST">
                                                        <?php
                                                            if(isset($_POST['editOn']) && $_POST['editOn'] == 'editPass')
                                                            {
                                                                if(isset($_POST['userCurrentPass']) && $_POST['userCurrentPass'] != null && md5($core->crypt($_POST['userCurrentPass'])) == ADMIN_CRYPTPASS && isset($_POST['userNewPass']) && $_POST['userNewPass'] != null && isset($_POST['userNewPassRep']) && $_POST['userNewPassRep'] != null && $_POST['userNewPassRep'] == $_POST['userNewPass'] && strlen($_POST['userNewPass']) < 200 && strlen($_POST['userNewPass']) > 8 && $_POST['userNewPass'] != ADMIN_NAME && $_POST['userNewPass'] != ADMIN_EMAIL && preg_match('/[0-9]/',$_POST['userNewPass']) && preg_match('/[a-z]/',$_POST['userNewPass']) && preg_match('/[A-Z]/',$_POST['userNewPass']))
                                                                {
                                                                    $db->query('UPDATE admin_users SET pwd="'.md5($core->crypt($_POST['userNewPass'])).'" WHERE id='.ADMIN_ID) or die($db->error);
                                                                    echo  '<div class="alert alert-success fade in alert-dismissable">
                                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                                                    <strong>'.$alang['profile.edit.success'].'</strong> '.$alang['profile.edit.success.pass'].'
                                                                    </div>'; 
                                                                    $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("PROFILE_UPDATE_SUCCESS",INET_ATON(\''.USER_IP.'\'),'.ADMIN_ID.',"'.time().'")');
                                                                }
                                                                else
                                                                {
                                                                    echo  '<div class="alert alert-danger fade in alert-dismissable">
                                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                                                    <strong>'.$alang['profile.edit.error'].'</strong> '.$alang['profile.edit.error.pass'].'
                                                                    </div>'; 
                                                                    $db->query('INSERT INTO admin_logs (type,ip,userId,timestamp) VALUES ("PROFILE_UPDATE_ERROR",INET_ATON(\''.USER_IP.'\'),'.ADMIN_ID.',"'.time().'")');
                                                                }
                                                            }
                                                            ?>
                                                            <input type="hidden" name="editOn" value="editPass">
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $alang['profile.edit.password.new'] ?></label>
                                                            <input type="password" name="userNewPass" placeholder="<?php echo $alang['profile.edit.pass.ph2'] ?>" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $alang['profile.edit.password.newrep'] ?></label>
                                                            <input type="password" name="userNewPassRep" placeholder="<?php echo $alang['profile.edit.pass.ph3'] ?>" class="form-control" /> </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo $alang['profile.edit.password.actual'] ?></label>
                                                            <input type="password" name="userCurrentPass" placeholder="<?php echo $alang['profile.edit.pass.ph1'] ?>" class="form-control" /> </div>
                                                        <div class="margin-top-10">
                                                            <a href="#" onclick="$(this).closest('form').submit()" class="btn green"> <?php echo $alang['profile.edit.change'] ?> </a>
                                                            <a href="#" onclick="$(this).closest('form').find('input[name=userCurrentPass]').val('');$(this).closest('form').find('input[name=userNewPass]').val('');$(this).closest('form').find('input[name=userNewPassRep]').val('')" class="btn default"> <?php echo $alang['profile.edit.cancel'] ?> </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-md-9-->
                                    </div>
                                </div>
                                <!--end tab-pane-->
                            </div>
                        </div>
                    </div>
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
        <?php echo $admin->contextUserMenu() ?>
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
        <script src="<?php echo URL ?>/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        
		<script type="text/javascript">
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
                <?php
                if(isset($_POST['editOn']) && $_POST['editOn'] == 'editUser')
                {
                    echo '$(\'.nav-tabs li:eq(1) a\').tab(\'show\') + $(\'.ver-inline-menu li:eq(0) a\').tab(\'show\');';
                }
                else if(isset($_POST['editOn']) && $_POST['editOn'] == 'editPhoto')
                {
                    echo '$(\'.nav-tabs li:eq(1) a\').tab(\'show\') + $(\'.ver-inline-menu li:eq(1) a\').tab(\'show\');';
                }
                else if(isset($_POST['editOn']) && $_POST['editOn'] == 'editPass')
                {
                    echo '$(\'.nav-tabs li:eq(1) a\').tab(\'show\') + $(\'.ver-inline-menu li:eq(2) a\').tab(\'show\');';
                }
                ?>
		</script>
        <!-- END THEME LAYOUT SCRIPTS -->
</body>


</html>