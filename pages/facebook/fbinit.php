<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();

define("FB_APP_ID", "901100386608221");
define("FB_APP_SECRET", "ee95c42e66a467e48f2006aaa7b79818");

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;

require_once("autoload.php");

FacebookSession::setDefaultApplication(FB_APP_ID, FB_APP_SECRET);

if(isset($_GET['logout']) && $_GET['logout'] == "true") {
	$_SESSION['FB_TOKEN'] = null;
	unset($_SESSION['FB_TOKEN']);
}

$helper = new FacebookRedirectLoginHelper("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
if(!isset($_SESSION['FB_TOKEN'])) {
	try {
		$session = $helper->getSessionFromRedirect();
		if($session) {
			$_SESSION['FB_TOKEN'] = $session->getToken();
		}
	} catch(FacebookRequestException $ex) {
		echo "FB error:<br /><pre>";
		var_dump($ex);
		echo "</pre>";
	} catch(\Exception $ex) {
		echo "Error:<br /><pre>";
		var_dump($ex);
		echo "</pre>";
	}
} else {
	$session = new FacebookSession($_SESSION['FB_TOKEN']);
}
$loggedin = true;
if(!$session) {

?>

        <p class="lead"><?php require_once("pages/intro.php"); ?></p>
        <p><a class="btn btn-lg btn-success" role="button" href="<?php echo $helper->getLoginUrl(array('public_profile', 'user_religion_politics', 'user_location')); ?>">Facebook login</a></p>

<?php
	$loggedin = false;
}
?>
