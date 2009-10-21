<?php


$feeds = array(
    /*'http://jon.smajda.com/rss.xml',*/
    'http://smajda.tumblr.com/rss',
    'http://files.smajda.com/jon/feeds/greader/',
    /*'http://twitter.com/statuses/user_timeline/14285636.rss',*/
    'http://files.smajda.com/jon/feeds/twitter/',
    'http://feeds.delicious.com/v2/rss/smajda',
    'http://contexts.org/howto/feed/',
    'http://github.com/smajda.atom'
);


include_once('/home/smajda/public_html/simplepie/simplepie.inc'); // Include SimplePie
$feed = new SimplePie(); // Create a new instance of SimplePie
date_default_timezone_set('America/Chicago');
$feed = new SimplePie(); // Create a new instance of SimplePie
$feed->set_feed_url($feeds);
$feed->set_cache_duration (600); // Set the cache time
$feed->set_cache_location('/home/smajda/public_html/simplepie/cache');
$feed->enable_xml_dump(isset($_GET['xmldump']) ? true : false);
$success = $feed->init(); // Initialize SimplePie
$feed->handle_content_type();

function get_source($item) {

    $url = $item->get_id();

    if (strstr($url, 'smajda.tumblr.com'))
        $source = array("name" => "Tumblr", "class" => "tumblr");
    elseif (strstr($url, 'http://twitter.com'))
        $source = array("name" => "Twitter", "class" => "twitter");
    elseif (strstr($url, 'github.com'))
        $source = array("name" => "Github", "class" => "github");
    elseif (strstr($url, 'http://delicious.com'))
        $source = array("name" => "Delicious", "class" => "delicious");
    elseif (strstr($url, 'http://contexts.org/howto'))
        $source = array("name" => "Contexts.org How-To's", "class" => "cxthowto");
    elseif (strstr($url, 'http://jon.smajda.com'))
        $source = array("name" => "Jon's Blog", "class" => "my-blog");
    else
        $source = array( "name" => $item->get_feed()->get_title(), "class" => "default"); 
    return $source;
}

function howLongAgo($timestamp){
    $difference = time() - $timestamp;

    if($difference >= 60*60*24*7){ // if more than a week ago
        $r = date('M d, Y', $timestamp);
    } elseif($difference >= 60*60*24){      // if more than a day ago
        $int = intval($difference / (60*60*24));
        $s = ($int > 1) ? 's' : '';
        $r = $int . ' day' . $s . ' ago';
    } elseif($difference >= 60*60){         // if more than an hour ago
        $int = intval($difference / (60*60));
        $s = ($int > 1) ? 's' : '';
        $r = $int . ' hour' . $s . ' ago';
    } elseif($difference >= 60){            // if more than a minute ago
        $int = intval($difference / (60));
        $s = ($int > 1) ? 's' : '';
        $r = $int . ' minute' . $s . ' ago';
    } else {                                // if less than a minute ago
        $r = 'seconds ago';
    }
    return $r;
}
?>
