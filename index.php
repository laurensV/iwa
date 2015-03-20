<?php

if(isset($_GET['ajax'])) $ajaxCall = true;
else $ajaxCall = false;

if (isset($_GET['p'])) $page = $_GET['p'];
else $page = "fb_login";

require_once ("include/functions.php");
require_once ("include/config.php");
require_once ("libraries/sparqllib.php")

?>
            <?php
    if(!$ajaxCall){
      ?>
<!DOCTYPE html>
<html>
    <head>
        <title>IWA final project</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <?php
      }
      ?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
            <?php
    if(!$ajaxCall){
      ?>
        <script type="text/JavaScript" src="js/js.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>

    <body>
<div class="container">
      <div class="header clearfix">
        <h3 class="text-muted">IWA final project</h3>
      </div>
      <div class="jumbotron">
        <h1>Job Recommender</h1>
                      <?php
                if ($page != "fb_login"){
                    require_once ("pages/fb_login.php");
                }
              }
                echo "<div id='ajaxCall'>";
                require_once ("pages/$page.php");
                echo "</div>";
if (!$ajaxCall){
                ?>
</div>
<?php
if(isset($loggedin) && $loggedin){
    ?>
    <div class="col-sm-3 col-md-2 sidebar">
    <?php require_once("include/occupation_list.php"); ?>
        </div>
    <?php
}
?>
      <!--<div class="row marketing">
        <div class="col-lg-12">
          <h4>Subheading</h4>
          <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>
        </div>
      </div>-->

      <footer class="footer">
        <p>IWA final project 2015</p>
      </footer>

    </div>
    </body>
</html>
<?php
}
?>