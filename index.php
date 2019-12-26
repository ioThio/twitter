<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>

  <link rel="stylesheet" href="styles.css">

</head>

<body>

Search <img src="twitter.png" alt="twitter image"><span>Twitter</span> for: <br>
<input id="TextSearch" type="text" name="keyword" />
<input type="button" class="button" id="SearchButton" value="Go!" />


<div class="content">

  <?php

  require_once('TwitterAPIExchange.php');
  /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
  $settings = array(
  'oauth_access_token' => "ACCESS_TOKEN",
  'oauth_access_token_secret' => "ACCESS_TOKEN_SECRET",
  'consumer_key' => "CONSUMER_KEY",
  'consumer_secret' => "CONSUMER_SECRET"
  );
  $url = "https://api.twitter.com/1.1/search/tweets.json?q=$_POST['keyword']&src=typed_query";
  $requestMethod = "GET";
  if (isset($_GET['user']))  {$user = preg_replace("/[^A-Za-z0-9_]/", '', $_GET['user']);}
  if (isset($_GET['count']) && is_numeric($_GET['count']) {$count = $_GET['count'];} else {$count = 10;}
  $getfield = "?screen_name=$user&count=$count&tweet_mode=extended";
  $twitter = new TwitterAPIExchange($settings);
  $string = json_decode($twitter->setGetfield($getfield)
  ->buildOauth($url, $requestMethod)
  ->performRequest(),$assoc = TRUE);
  if(array_key_exists("errors", $string)) {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
  foreach($string as $items)
      {
          echo "Time and Date of Tweet: ".$items['created_at']."<br />";
          echo "Tweet: ". $items['full_text']."<br />";
          echo "Tweeted by: ". $items['user']['name']."<br />";
          echo "Screen name: ". $items['user']['screen_name']."<br />";
          echo "Followers: ". $items['user']['followers_count']."<br />";
          echo "Friends: ". $items['user']['friends_count']."<br />";
          echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
      }
  ?>




</div>


</body>

</html>
