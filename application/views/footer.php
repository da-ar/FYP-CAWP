    </div>
    <footer>

    </footer>
  
  <div id="info_modal"></div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>
  <script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>
  
  <?php
    // provides a means to have custom javascripts 
    // injected into the scoure after jquery has been
   // called
  
    if(isset($scripts)){
        echo '<script type="text/javascript">';
        echo $scripts;
        echo '</script>';
    }
  
  ?>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="/js/plugins.js"></script>
  <!-- end scripts-->


  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>
