<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Ferret | Univeristy of Ulster | Find it with Ferret, your UUJ services guide</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- CSS concatenated and minified via ant build script-->
    <link rel="stylesheet" href="/css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>
    <!-- end CSS-->

    <script src="js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>

    <header>
        <nav>
            <ul>
                <li><a onclick="reloadApp();">Refresh Location</a></li>
                <li><a href="/profile/timetable">Your Timetable</a></li>
                <li><a href="/profile">Your Profile</a></li>
                <li><a href="/auth/logout">Sign Out</a></li>                
            </ul>
            <div style="clear:both"></div>
        </nav>        
    </header>
    <div id="main" role="main">
        <div id="logo_pane">
            <img src="/images/logo2.png" width="250" height="118" alt="Ferret Logo" id="logo" />
            <div id="loc_info"></div>
        </div>        
        <div id="service_content">
            <!-- AJAX loads in the services here --->
            <div id="loading_services">Ferreting out your local services...</div>
        </div>
    </div>
    <div id="applet">Loading Applet...</div>
    <footer>

    </footer>
  
  <div id="info_modal"></div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')
  var override = false;
  </script>


  <!-- scripts concatenated and minified via ant build script-->
        
  <script defer src="/js/plugins.js"></script>
  <script defer src="/js/script.js"></script>
  
   <?php if($bssid) : ?>
        <script defer type="text/javascript">
            $(document).ready(function(){
                $("#applet").html("");
                displayMac("<?= $bssid ?>");  
            });
        </script>
    <?php else : ?>
        <script defer type="text/javascript">
        $(document).ready(function(){

            // load in the MacSniffer Applet
            $("#applet").html([
                '<object', 
                'classid="java:com.B00528996.MacSniffer" id="sniffer"',
                'type="application/x-java-applet" width="1" height="1">',
                        '<param name="archive" value="/util/MacSniffer.jar"></param>',
                        '<param name="code" value="com.B00528996.MacSniffer"></param>',
                        '<param name="mayscript" value="true"></param>',
                        '<param name="id" value="sniffer"></param>',
                '</object'].join('\n'));        

        });
        </script>
    <?php  endif;  ?>
 
  <!-- end scripts-->


  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
