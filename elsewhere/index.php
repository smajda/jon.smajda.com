<?php
    require('includes.php');
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 TRANSITIONAL//EN">
<html>
<head>
		<title>Jon's Recent Activity</title>
</head>
<body>

<ul id="elsewhere">
<?php 
if ($success) : 

    foreach($feed->get_items() as $item) {
        if ($itemlimit==15)
            break;

        $feedlink = $item->get_feed()->get_link();
        $link = $item->get_permalink();
        $source = get_source($item);
        $favicon = $item->get_feed()->get_favicon();
        $time = howLongAgo($item->get_date('U'));
        if ($source['name'] == 'Twitter') {
            $content = $item->get_content();
        } elseif ($source['name'] == 'Github') {
            $content = preg_replace('/^smajda /', '', $item->get_title()); 
        } else {
            $content = $item->get_title();
        }


        echo '<li class="'.$source['class'].'">';
        echo '<span class="title">'.$content.'</span><br />';
        echo '<span class="meta">&rarr; <a href="'.$link.'">'
             .$time.' on '.$source["name"].'</a></span>';
        echo "</li>\n";
        $itemlimit++;
    }

 endif; 
?>
</ul>

</body>
</html>
