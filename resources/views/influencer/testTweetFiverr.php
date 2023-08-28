<?php
require_once 'vendor/autoload.php';


$API_KEY = 'jfgwP46BbyIExEiVCK3ES4GJs';
$API_SECRET = 'YCiS3H8As5MZV8SLq1Q2MwL67wldcnsrnWEZTVf3JQ368OqIes';

$ACCESS_TOKEN = "849552149432467457-9b4gZDCZM8D0P1gUHZO7OxvkmwponU3";
$ACCESS_TOKEN_SECRET = "eeADmqskvSC0oGeG5105o53wZdOvyeq2C3ZLr1i0NLNPo";
$BEARER_TOKEN = "AAAAAAAAAAAAAAAAAAAAALSdpQEAAAAAHljxOglUCxteud%2F67KSC%2FjqUdC8%3DAbjItTloqlmQi2Vj5xpQBUCpW29vlSEd6saa5Vw098YxYsMcRP";


$twitterClient = new \App\TwitterService\TwitterWrapper($API_KEY, $API_SECRET, $ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);


//Example of usages. Uncomment below to see that it is working too.

$result = $twitterClient->getUserByUsername("AucT");


var_dump($result);
var_dump([
    'followers_count' => $result->data->public_metrics->followers_count,
    'following_count' => $result->data->public_metrics->following_count,
    'tweet_count' => $result->data->public_metrics->tweet_count,

]);

//echo PHP_EOL;
//echo PHP_EOL;
//
//$result = $twitterClient->getUserByUserId("112082660");
//var_dump($result);
//var_dump([
//    'followers_count' => $result->data->public_metrics->followers_count,
//    'following_count' => $result->data->public_metrics->following_count,
//    'tweet_count' => $result->data->public_metrics->tweet_count,
//
//]);
//
//echo PHP_EOL;
//echo PHP_EOL;
//
//
//
//$result = $twitterClient->getUsersByIds([112082660]);
//var_dump($result);
//var_dump([
//    'followers_count' => $result->data[0]->public_metrics->followers_count,
//    'following_count' => $result->data[0]->public_metrics->following_count,
//    'tweet_count' => $result->data[0]->public_metrics->tweet_count,
//
//]);
//
//echo PHP_EOL;
//echo PHP_EOL;
//
//
//$result = $twitterClient->getUsersByUsernames(["AucT"]);
//var_dump($result);
//var_dump([
//    'followers_count' => $result->data[0]->public_metrics->followers_count,
//    'following_count' => $result->data[0]->public_metrics->following_count,
//    'tweet_count' => $result->data[0]->public_metrics->tweet_count,
//
//]);
//
//echo PHP_EOL;
//echo PHP_EOL;