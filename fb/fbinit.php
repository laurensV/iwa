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

if(!$session) {
?>
<!DOCTYPE html>
<html>
<head>
<title>Facebook Login</title>
<meta charset="UTF-8">
</head>
<body>
<a href="<?php echo $helper->getLoginUrl(array('public_profile', 'user_religion_politics', 'user_education_history')); ?>">Facebook login</a>
</body>
</html>
<?php
	die();
}
?>
