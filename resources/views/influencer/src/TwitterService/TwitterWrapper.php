<?php
namespace App\TwitterService;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterWrapper
{


    public TwitterOAuth $client;

    public function __construct($consumer_key, $consumer_key_secret, $access_token, $access_token_secret)
    {

        $this->client = $this->getTwitterOauthClient($consumer_key, $consumer_key_secret, $access_token, $access_token_secret);
        $this->client->setApiVersion('2');
    }

    public function getTwitterOauthClient($consumer_key, $consumer_key_secret, $access_token, $access_token_secret): TwitterOAuth
    {

        return new TwitterOAuth($consumer_key, $consumer_key_secret, $access_token, $access_token_secret);
    }



    public function getUserByUserId(string $userId)
    {
        return $this->client->get("users/{$userId}", [
            'user.fields' => 'created_at,description,entities,id,location,name,pinned_tweet_id,profile_image_url,protected,public_metrics,url,username,verified'
        ]);
    }


    public function getUserByUsername(string $userName)
    {
        return $this->client->get("users/by/username/{$userName}", [
            'user.fields' => 'created_at,description,entities,id,location,name,pinned_tweet_id,profile_image_url,protected,public_metrics,url,username,verified'
        ]);
    }


    public function getUsersByUsernames(array $twitterUserNames)
    {
        return $this->client->get('users/by', [
            'usernames' => implode(',', $twitterUserNames),
            'user.fields' => 'created_at,description,entities,id,location,name,pinned_tweet_id,profile_image_url,protected,public_metrics,url,username,verified'
        ]);
    }

    public function getUsersByIds(array $twitterUserIds)
    {
        return $this->client->get('users', [
            'ids' => implode(',', $twitterUserIds),
            'user.fields' => 'created_at,description,entities,id,location,name,pinned_tweet_id,profile_image_url,protected,public_metrics,url,username,verified'
        ]);
    }


    /*
     * You can remove this if you don't need
     */

//    public function postTweet(string $message)
//    {
//        //https://api.twitter.com/2/tweets
//        return $this->client->post('tweets', ['text' => $message], true);
//    }
//
//
//    public function searchTweets(string $query)
//    {
//        //https://api.twitter.com/2/tweets/search/recent?query=
//        return $this->client->get('tweets/search/recent', ['query' => $query]);
//    }
//
//    public function getFollowersByUserIdPage(string $twitterUserId, string $nextToken = null)
//    {
//        //https://api.twitter.com/2/users/:id/followers
//        $params = ['max_results' => 1000];
//        if ($nextToken) {
//            $params['pagination_token'] = $nextToken;
//        }
//        return $this->client->get("users/$twitterUserId/followers", $params);
//    }
//
//    // This is helper func that will return array of users. If there is error it will throw exception
//    public function getAllFollowersByUserId(string $twitterUserId): array
//    {
//        $users = [];
//
//        $hasNextPage = true;
//        $nextToken = null;
//
//        while ($hasNextPage) {
//            $json = $this->getFollowersByUserIdPage($twitterUserId, $nextToken);
//            $array = (array) $json;
//            if (!isset($array['meta']['result_count'])) {
//                throw new \Exception(json_encode($json));
//            }
//            if ($array && isset($array['meta']['result_count']) && $array['meta']['result_count'] > 0) {
//                $users = array_merge($users, $array['data'] ?: []);
//
//                if (isset($array['meta']['next_token'])) {
//                    $nextToken = $array['meta']['next_token'];
//                } else {
//                    $hasNextPage = false;
//                }
//            } else {
//                $hasNextPage = false;
//            }
//        }
//
//        return $users;
//    }
//
//
//
//
//
//    public function followUserByUserId(string $sourceUserId, string $targetUserId)
//    {
//        //https://api.twitter.com/2/users/:id/following
//        return $this->client->post("users/$sourceUserId/following", ['target_user_id' => $targetUserId], true);
//    }
//
//
//    public function unFollowUserByUserId(string $sourceUserId, string $targetUserId)
//    {
//        //https://api.twitter.com/2/users/:source_user_id/following/:target_user_id
//        return $this->client->delete("users/$sourceUserId/following/$targetUserId");
//    }
//
//    public function sendDM(string $twitterUserId, string $message)
//    {
//        return $this->client->post("dm_conversations/with/$twitterUserId/messages", ['text' => $message], true);
//    }

}
