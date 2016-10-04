
<?php

if (!isset($_GET['name'])||!isset($_GET['count']))  {

?>
<img alt="" height="327" src="Twitter_Timeline.jpg" width="652"><br>

<form method="get" action="">
	<br>Specify the screeen name of a timeline: <br><br>&nbsp;<input name="name" type="text" style="width: 239px; height: 30px" /><br>
	<br>Count: <br><br>&nbsp;<input name="count" type="text" style="width: 239px; height: 30px" /><br>
	<br>&nbsp;<input type="submit" value="search timeline" />
</form>


<?php

}


else   {

require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/

$settings = array(
'oauth_access_token' => "782618078186119169-itY2Rgrf0WvwrRFywJyri94pAfEpN5M",
'oauth_access_token_secret' => "hl7qCYymg52cXFFn5ps5QLFHc5uAzK9NUTvKVA2oMyGNb",
'consumer_key' => "kh21i0YwJ7neGf9RXgqynd4ot",
'consumer_secret' => "tdENp9t2jLvCzEGpyQ9lCHxUssLxJExnzN9jNyeaIXHgNEvrcP"
);

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";


$requestMethod = "GET";

$name = $_GET['name'];
$count = $_GET['count'];

$getfield = "?screen_name=$name&count=$count";


$twitter = new TwitterAPIExchange($settings);


$string = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest(),TRUE);


//echo "<pre>";
//print_r($string);
//echo "</pre>";

foreach($string as $item)
    {
        echo "Time and Date of Tweet: ".$item['created_at']."<br />";
        echo "Tweet: ". $item['text']."<br />";
        echo "Source: ". $item['source']."<br />";
        echo "Geo Location: ".$item['geo']['coordinates'][0]."  ".$item['geo']['coordinates'][1]."<br />";
        echo "Place: ". $item['place']['full_name']."<br />";
        echo "Tweeted by: ". $item['user']['name']."<br />";
        echo "Screen name: ". $item['user']['screen_name']."<br />";
        echo "Followers: ". $item['user']['followers_count']."<br />";
        echo "Friends: ". $item['user']['friends_count']."<br />";
        echo "Listed: ". $item['user']['listed_count']."<br /><hr />";
    }




}  // end of else

?>
