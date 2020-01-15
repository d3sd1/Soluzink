<?php require('../../../../../kernel/core.php');
if(isset($_GET['hash']) && $db->query('SELECT id FROM users WHERE id="'.$core->decrypt($_GET['hash']).'"')->num_rows > 0)
{
    $docInfo = $db->query('SELECT * FROM users u JOIN users_psicos up ON u.id=up.user_id WHERE id="'.$core->decrypt($_GET['hash']).'"')->fetch_array();
}
else
{
    echo '<script>window.location = \'/#/Psicos\'; </script>';
    die();
}
if(USER_IS_BLOCKED) {die();}
?>

        <link rel="stylesheet" type="text/css" href="<?php echo URL ?>/assets/css/home/profile.css">
        <link rel="stylesheet" type="text/css" href="<?php echo URL ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo URL ?>/assets/vendors/magnific-popup/magnific-popup.css">

        <script src="<?php echo URL ?>/assets/vendors/vex/js/vex.combined.min.js"></script>
                <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/vex/css/vex.css" />
                <link rel="stylesheet" href="<?php echo URL ?>/assets/vendors/vex/css/vex-theme-os.css" />
                
        <div id="wrapper">
            <a href="#sidebar" class="mobilemenu"><i class="icon-reorder"></i></a>

            <div id="sidebar">
                <div id="main-nav">
                    <div id="nav-container">
                        <div id="profile" class="clearfix">
                            <div class="portrate hidden-xs" style="background-image: url(<?php echo str_replace(array('{PROFILE_IMAGE_DEFAULT}','{URL}'),array(PROFILE_IMAGE_DEFAULT,URL),$docInfo['photo']) ?>);"></div>
                            <div class="title">
                                <h2><?php echo $docInfo['name'].' '.substr($docInfo['surnames'],0,1).'.' ?></h2>
                                <h3><?php echo $docInfo['pph'].' '.$core->getCurrency($docInfo['pphCoin'],'symbol').'/'.$lang['CORE']['time.elapsed.hour'] ?></h3>
                            </div>
                            
                        </div>
                        <ul id="navigation">
                            <li>
                              <a href="#about">
                                <div class="fa fa-user aboutColor"></div>
                                <div class="text"><?php echo $lang['home']['profile']['sidebar']['about'] ?></div>
                              </a>
                            </li>  
                            
                            <li>
                              <a href="#spec">
                                <div class="fa fa-book specColor"></div>
                                <div class="text"><?php echo $lang['home']['profile']['sidebar']['spec'] ?></div>
                              </a>
                            </li> 
                            
                            <li>
                              <a href="#ratings">
                                <div class="fa fa-star"></div>
                                <div class="text"><?php echo $lang['home']['profile']['sidebar']['ratings'] ?></div>
                              </a>
                            </li> 
                            <li>
                              <a href="#about">
                                <div class="fa fa-clock-o buyNowColor"></div>
                                <div class="text fadingBuyNow"><?php echo $lang['home']['profile']['sidebar']['sessionnow'] ?></div>
                              </a>
                            </li>
                        </ul>
                    </div>        
                </div>
            </div>

            <div id="main">
            
                <div id="about" class="page home" data-pos="home">
                    <div class="pageheader">
                        <div class="headercontent">
                            <div class="section-container">
                                
                                <div class="row">
                                    <div class="clearfix visible-sm visible-xs"></div>
                                    <div class="col-sm-6 col-md-7">
                                        <h3 class="title"><?php echo $lang['home']['profile']['content']['aboutme'] ?></h3>
                                        <p><?php echo $docInfo['description'] ?></p>
                                    </div>  
                                    <div class="col-sm-6 col-md-5">
                                        <div class="soluzinkCldr-loader fa fa-spinner fa-spin"></div>
                                        <input type="hidden" data-price-pph="<?php echo $docInfo['pph'] ?>" data-price-currency="<?php echo $core->getCurrency($docInfo['pphCoin'],'symbol') ?>" data-psico="<?php echo $docInfo['name'].' '.substr($docInfo['surnames'],0,1).'.' ?>" id="calendarProfile<?php echo $_GET['hash'] ?>" />
                                    </div>  
                                    
                                </div>
                            </div>        
                        </div>
                    </div>
                </div>

                <div id="spec" class="page">
                    <div class="pageheader">

                        <div class="headercontent">

                            <div class="section-container">
                                <h2 class="title"><?php echo $lang['home']['profile']['content']['speciality']['header'] ?></h2>
                            
                                <div class="row">
                                    <div class="col-md-8">
                                        <p><?php echo $lang['home']['profile']['content']['speciality']['description'] ?></p>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="ul-boxed list-unstyled">
                                        <?php
                                            if($db->query('SELECT user_id FROM users_psicos_sessions WHERE user_id='.$docInfo['id'])->num_rows == 0)
                                            {
                                                echo '<li>'.$lang['home']['profile']['content']['speciality']['secondrow']['nodata'].'</li>';
                                            }
                                            else
                                            {
                                                $profileSpecialities = $db->query('SELECT keyname FROM users_psicos_sessions WHERE user_id='.$docInfo['id']);
                                                while($row = $profileSpecialities->fetch_array())
                                                {
                                                    echo '<li>'.$lang['home']['profile']['content']['speciality']['secondrow'][$row[0]].'</li>';
                                                }
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if($db->query('SELECT id FROM testimonials WHERE pid='.$docInfo['id'])->num_rows)
                    {
                        $profileTestimonials = $db->query('SELECT t.content, u.name, u.surnames, u.photo FROM testimonials t JOIN users u ON u.id=t.uid WHERE pid='.$docInfo['id'].' ORDER BY timestamp DESC');
                        $row1 = null;
                        $row2 = null;
                        while($row = $profileTestimonials->fetch_array())
                        {
                            $row1 .= '<div><img draggable="false" alt="'.str_replace('{{user}}',$row['name'].' '.$row['surnames'],$lang['SEO']['ALTIMAGE']['extprofile']['userimage']).'" src="'.str_replace(array('{PROFILE_IMAGE_DEFAULT}','{URL}'),array(PROFILE_IMAGE_DEFAULT,URL),$row['photo']).'" width="120" height="120" class="img-circle lab-img" /></div>';
                            $row2 .= '<div>
                            <h3>'.$row['name'].' '.$row['surnames'].'</h3>
                            <h4>'.$row['content'].'</h4>
                        </div>';
                        }
                        echo '<div class="pagecontents">
                        <div class="section color-1">
                            <div class="section-container">
                                <div class="title text-center">
                                    <h3>'.$lang['home']['profile']['content']['speciality']['bestmatches'].'</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="labp-heads-wrap">
                                            <div id="lab-carousel">
                                            '.$row1.'
                                            </div>
                                            <div>
                                                <a href="#" id="prev"><i class="fa fa-arrow-left"></i></a>
                                                <a href="#" id="next"><i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>

                                        <div id="lab-details">
                                            '.$row2.'
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                        
                                    }
                                    ?>
                           
                </div>

                <div id="ratings" class="page">
                    <div class="page-container">
                        <div class="pageheader">
                            <div class="headercontent">
                                <div class="section-container">
                                    
                                    <h2 class="title"><?php echo $lang['home']['profile']['content']['votes']['title'] ?></h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><?php echo $lang['home']['profile']['content']['votes']['description'] ?></p>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="pagecontents">
                            
                            <div class="section color-1" id="filters">
                                <div class="section-container">
                                    <div class="row">
                                        
                                        <div class="col-md-3">
                                            <h3><?php echo $lang['home']['profile']['content']['votes']['filter']['title'] ?>:</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <select id="cd-dropdown" name="cd-dropdown" class="cd-select">
                                                <option class="filter" value="all" selected><?php echo $lang['home']['profile']['content']['votes']['filter']['all'] ?></option>
                                                <!--<option class="filter" value="5"><?php echo $lang['home']['profile']['content']['votes']['filter']['5'] ?></option>
                                                <option class="filter" value="4"><?php echo $lang['home']['profile']['content']['votes']['filter']['4'] ?></option>
                                                <option class="filter" value="3"><?php echo $lang['home']['profile']['content']['votes']['filter']['3'] ?></option>
                                                <option class="filter" value="2"><?php echo $lang['home']['profile']['content']['votes']['filter']['2'] ?></option>
                                                <option class="filter" value="1"><?php echo $lang['home']['profile']['content']['votes']['filter']['1'] ?></option>-->
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-3" id="sort">
                                            <span><?php echo $lang['home']['profile']['content']['votes']['filter']['sort'] ?>:</span>
                                            <div class="btn-group pull-right"> 

                                                <button type="button" data-sort="data-timestamp" data-order="desc" class="sort btn btn-default"><i class="fa fa-chevron-circle-up"></i></button>
                                                <button type="button" data-sort="data-timestamp" data-order="asc" class="sort btn btn-default"><i class="fa fa-chevron-circle-down"></i></button>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            </div>

                            <div class="section color-2" id="pub-grid">
                                <div class="section-container">
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="pitems">
                                                
                                                <?php
                                                if($db->query('SELECT * FROM testimonials WHERE pid='.$docInfo['id'])->num_rows > 0)
                                                {
                                                    $profileVotes = $db->query('SELECT upv.content, upv.timestamp, u.name, u.surnames FROM testimonials upv JOIN users u ON u.id=upv.uid WHERE pid='.$docInfo['id']);
                                                    while($row = $profileVotes->fetch_array())
                                                    {
                                                        echo '<div class="item mix" data-timestamp="'.$row['timestamp'].'">
                                                            <div class="pubmain">
                                                                <h4 class="pubtitle">'.$row['name'].' '.$row['surnames'].'</h4>
                                                                <div class="pubauthor"><strong>'.$row['content'].'</strong></div>
                                                            </div>
                                                        </div>';
                                                    }
                                                }
                                                else
                                                {
                                                    echo '<h1>'.$lang['home']['profile']['content']['votes']['novotes'].'</h1>';
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
                <div id="overlay"></div>
            
            </div>
        </div>