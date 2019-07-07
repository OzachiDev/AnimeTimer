<?php
require "twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = '';
$consumerSecret = '';

if (isset($_GET['file'])) $file = $_GET['file'];
else $file = "sao";

include('_picture.php');
if ($file == "sao") {
    $accessToken = '';
    $accessTokenSecret = '';
    $title = 'SAO:A P2';
} else if ($file == "snk") {
    $accessToken = '';
    $accessTokenSecret = '';
    $title = 'SNK S4';
}
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
$user = $connection->get("account/verify_credentials");

$myTweet = date("l d-m-Y")."\n\nDays before $title: $daysLeft\nDays passed: $daysPassed\nPercentage: ".round($realPerc, 3)."%";

$tweetWM = $connection->upload('media/upload', ['media' => "file.png"]);
$tweet = $connection->post('statuses/update', ['media_ids' => $tweetWM->media_id, 'status' => $myTweet]);
die('Success!');
?>