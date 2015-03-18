<?php
require_once("fbinit.php");

use Facebook\FacebookRequest;

echo "<a href=\"" . $helper->getLogoutUrl($session, "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?logout=true") . "\">Logout</a><br />";
echo "<a href=\"http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?logout=true\">Destroy my session</a>";
echo "<pre>";
//var_dump($session);

$request = new FacebookRequest(
  $session,
  'GET',
  '/me/permissions'
);
//echo "Exec request...<br />";
//var_dump($request);

$response = $request->execute();
// echo "Response<br />";
// var_dump($response);
$graphObject = $response->getGraphObject();
echo "Graph<br />";
var_dump($graphObject);
echo "</pre>";



?>
