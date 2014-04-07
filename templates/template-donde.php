<?php
/*
Custom Plugin Template
File: template-store-locator.php
*/

$donde_key = get_option('dondeid');

if (empty($donde_key)) {

	echo 'You must specify your Donde ID for the store locator to work.';

} else {

	$donde_navmenu = get_option('donde_navmenu');
	$donde_primarycolor = get_option('donde_primarycolor');
	$donde_secondarycolor = get_option('donde_secondarycolor');
	$donde_linkcolor = get_option('donde_linkcolor');
	$donde_pincolor = get_option('donde_pincolor');
	
	if (empty($donde_primarycolor)) { $donde_primarycolor = '#000000'; }
	if (empty($donde_linkcolor)) { $donde_linkcolor = '#ffffff'; }
	if (empty($donde_pincolor)) { $donde_pincolor = 'red'; }
	
	// get logo	
    //$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_mime_type' => 'image', 'post_status' => null, 'post_parent' => $post->ID ); 
    $args = array( 'post_type' => 'attachment', 'numberposts' => -1); 
    $attachments = get_posts($args);
    if ($attachments) {
        foreach ( $attachments as $attachment ) {
        	if ($attachment->post_title == 'logo-donde') {
                $logourl = $attachment->guid;
            }
        }
    }
    $sitename = get_bloginfo('name');

?>

<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $sitename; ?> Store Locator</title>
    <meta name="description" content="A list of store and product locations for <?php echo $sitename; ?>, mobile locator brought to you by Dónde">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="google" value="notranslate" />
    <meta http-equiv="Content-Language" content="en_US" />
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="https://d3egb1p3jkzgcl.cloudfront.net/donde-style-v2.min.css">
    <link rel="stylesheet" href="http://api.donde.io/css/<?php echo $donde_key; ?>">
    <style>
        /* needed to avoid all elements to appear on page loading */
        .ng-cloak {
            display: none !important;
        }
            /* to align the checkboxes correctly */
        .form-inline .checkbox input[type="checkbox"] {
            float: none;;
            margin-bottom: 6px;
        }
    </style>
    <!-- endbuild -->
</head>
<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser
    today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better
    experience this site.</p>
<![endif]-->

<!--[if lt IE 9]>
<!--<script src="bower_components/es5-shim/es5-shim.js"></script>-->
<!--<script src="bower_components/json3/lib/json3.min.js"></script>-->
<![endif]-->

    <div id="page">
        
        <a href="#" class="open-panel">Menu</a>

        <?php
            $custom_menus = wp_get_nav_menus();
            foreach ( $custom_menus as $menu ){
                if($menu->slug == $donde_navmenu) {
                    $menu_items = wp_get_nav_menu_items($menu);
                }
            }
        ?>
        <nav class="mmenu">
            <?php 
                if (is_array($menu_items)){
                foreach ($menu_items as $menu_item):
                echo "<a href='$menu_item->url'>$menu_item->title</a>";
            endforeach; 
                }
            ?>
        </nav>

        <div id="content">

            <header class="donde-header">
                <div class="logo">
                <a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>" alt="<?php echo $sitename; ?>"> </a>
                </div>
                <nav>
                    <?php 
                    if (is_array($menu_items)){
                    foreach ($menu_items as $menu_item):
                        echo "<a href='$menu_item->url'>$menu_item->title</a>";
                    endforeach; 
                    }
                    ?>
                </nav>
            </header>

            <div id="dondeLocator"></div>

        </div>

    </div>


    <script>
        (function(e){var t=document.createElement("script");t.type="text/javascript";t.src="https://dtopnrgu570sp.cloudfront.net/donde-loader.js";if(t.addEventListener){t.addEventListener("load",function(t){e(null,t)},false)}else{t.onreadystatechange=function(){if(t.readyState in{loaded:1,complete:1}){t.onreadystatechange=null;e()}}}document.body.appendChild(t)})(function(){window.DondeIO.load("<?php echo $donde_key; ?>")});
    </script>
    
</body>
</html>

<?php } ?>
