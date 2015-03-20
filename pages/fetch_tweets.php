<?php
require_once ("libraries/TwitterAPIExchange.php");

function fetch_tweets($occ_url, $name){
    $cat_array = array(
        "fun",
        "danger",
        "rich",
        "boring"
    );
    foreach ($cat_array as $category) {
        
        $occ_name = urlencode($name . " " . $category . " since:".date("Y-m-d", strtotime("-1 days")));
        $settings = array(
            'oauth_access_token' => "3017875300-T4AFO9OC5J5m0zr8JTF9bvsSdH8wxCvSMFgXiKI",
            'oauth_access_token_secret' => "zJx3lmIAw9jt1GTsSTEBuAW9da6HcBAQnSD8vlZQEzDaQ",
            'consumer_key' => "ofOVAB4toaGIFJv9IrBcIRUIl",
            'consumer_secret' => "asoNqY7cqVj9heosApHJdgELsHEAyvzDuy4dqRLOcJ8OyGarjK"
        );
        
        $url = "https://api.twitter.com/1.1/search/tweets.json";
        
        $requestMethod = "GET";
        
        $getfield = '?q=' . $occ_name . '&count=100';
        
        $twitter = new TwitterAPIExchange($settings);
        $string = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest() , $assoc = TRUE);
        if (isset($string["errors"][0]["message"]) && $string["errors"][0]["message"] != "") {
            echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>" . $string[errors][0]["message"] . "</em></p>";
            exit();
        }
        $count = sizeof($string['statuses']);

    $graph = new \EasyRdf_Graph();
    $graph->add($occ_url, 'http://iwa2.cf/'.$category, $count);
    global $graphStore;

    var_dump($graphStore->insertIntoDefault($graph, 'rdfxml'));
    }
}
?>