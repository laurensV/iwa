This is the intro page. Choose a job cluster from the left menu.
<?php
    require_once("libraries/TwitterAPIExchange.php");
    $settings = array(
                      'oauth_access_token' => "3017875300-T4AFO9OC5J5m0zr8JTF9bvsSdH8wxCvSMFgXiKI",
                      'oauth_access_token_secret' => "zJx3lmIAw9jt1GTsSTEBuAW9da6HcBAQnSD8vlZQEzDaQ",
                      'consumer_key' => "ofOVAB4toaGIFJv9IrBcIRUIl",
                      'consumer_secret' => "asoNqY7cqVj9heosApHJdgELsHEAyvzDuy4dqRLOcJ8OyGarjK"
                      );
    
    $url = "https://api.twitter.com/1.1/search/tweets.json";
    
    $requestMethod = "GET";
    
    $getfield = '?q=&geocode=-22.912214,-43.230182,1km&lang=pt&result_type=recent';
    
    $twitter = new TwitterAPIExchange($settings);
    $string = json_decode($twitter->setGetfield($getfield)
                          ->buildOauth($url, $requestMethod)
                          ->performRequest(),$assoc = TRUE);
    if(isset($string["errors"][0]["message"]) && $string["errors"][0]["message"] != "") {
		echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
		exit();
	}

    echo "<pre>";
    print_r($string);
    echo "</pre>";
    
?>
