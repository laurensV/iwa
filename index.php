<?php
require_once("include/functions.php");
require_once("include/config.php");
require_once("libraries/sparqllib.php")
?>
<!DOCTYPE html>
<html>
    <head>
        <title>IWA final project</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/JavaScript" src="js/js.js"></script> 
    </head>
    <body>
        <div id="page-wrapper">
            <div id="sidebar-left">
                <?php
                require_once ("include/occupation_list.php");
                ?>
            </div>
            <div id="page">
	            <?php
	            if(isset($_GET['p']))
	            	$page = $_GET['p'];
	            else 
	            	$page = "intro";
	            require_once("pages/$page.php");
	            ?>
            </div>
        </div>
    </body>
</html>