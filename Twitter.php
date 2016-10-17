
<html>
<head>
<style>
body {
    background-image: url('twitter.png');
		background-size: cover;
}
h1{
  color: #9c2121;
}
input[type=text], select {
    width: 20%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    -webkit-transition: width 0.5s ease-in-out;
    transition: width 0.5s ease-in-out;
}
input[type=text]:focus {
    width: 100%;
}
select {
    width: 20%;
    padding: 16px 20px;
    border: none;
    border-radius: 4px;
    background-color: #f1f1f1;
}

</style>
</head>
<body>

	<?php

	if (!isset($_GET['keyword'])||!isset($_GET['lat'])||!isset($_GET['lng'])||!isset($_GET['range']))  {

	?>


	<form method="get" action="">
		<br><center><h1>Specify the hashtag:</h1><br>&nbsp;<input name="keyword" type="text" style="width: 400px; height: 50px" /></center><br>
		<br><center><h1>Latitude: </h1><br>&nbsp;<input name="lat" type="text" style="width: 239px; height: 50px" /></center><br>
		<br><center><h1>Longitude: </h1><br>&nbsp;<input name="lng" type="text" style="width: 239px; height: 50px" /><center><br>
		<br><center><h1>Range: </h1><br>&nbsp;<input name="range" type="text" style="width: 239px; height: 50px" /></cente><br>
		<br><center>&nbsp;<input type="submit" value="search timeline" /></center>
	</form>


	<?php

	}


	else   {

	require_once('TwitterAPIExchange.php');

	$settings = array(
	'oauth_access_token' => "782618078186119169-itY2Rgrf0WvwrRFywJyri94pAfEpN5M",
	'oauth_access_token_secret' => "hl7qCYymg52cXFFn5ps5QLFHc5uAzK9NUTvKVA2oMyGNb",
	'consumer_key' => "kh21i0YwJ7neGf9RXgqynd4ot",
	'consumer_secret' => "tdENp9t2jLvCzEGpyQ9lCHxUssLxJExnzN9jNyeaIXHgNEvrcP"
	);

	$url = "https://api.twitter.com/1.1/search/tweets.json";


	$requestMethod = "GET";

	$name = $_GET['keyword'] ;

	if (!empty($_GET['lat']) && !empty($_GET['lng']) && !empty($_GET['range'])) {

	$getfield = "?q=".$name."&geocode=".$_GET['lat'].",".$_GET['lng'].",".$_GET['range']."mi";

	$getfield.="&count=100";
	}

	else {

	$getfield = "?q=".$name;
	$getfield.="&count=100";
	}


	$twitter = new TwitterAPIExchange($settings);


	$string = json_decode($twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest(),TRUE);

	foreach($string as $item)
	    {
				for($i = 0; $i<=sizeof($item); $i++)
				{
					if(array_key_exists($i, $item))
					{
						echo "Time and Date of Tweet: ".$item[$i]['created_at']."<br />";
						echo "Tweet: ". $item[$i]['text']."<br />";
						echo "Source: ". $item[$i]['source']."<br />";
						echo "Geo Location: ".$item[$i]['geo']['coordinates'][0]."  ".$item[$i]['geo']['coordinates'][1]."<br />";
						echo "Place: ". $item[$i]['place']['full_name']."<br />";
						echo "Tweeted by: ". $item[$i]['user']['name']."<br />";
						echo "Screen name: ". $item[$i]['user']['screen_name']."<br />";
						echo "Followers: ". $item[$i]['user']['followers_count']."<br />";
						echo "Friends: ". $item[$i]['user']['friends_count']."<br />";
						echo "Listed: ". $item[$i]['user']['listed_count']."<br /><hr />";
	    	}
			}
		}
	}  // end of else

	?>
</body>
</html>
