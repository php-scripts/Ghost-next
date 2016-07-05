<?php
  // rss feed for feedback
  require_once "tinyrss.php";
  tinyRssHeader("Recent ghost feedbacks","Last 10 feedback messages","dusan.halicky@gmail.com","http://ayass.xf.cz/ghost/rss-feedback.php");
  $file = file_get_contents('feedback.txt');
  // separate lines by hr (because there is no css in rss)
  $lines = explode("\n",$file);
  $qa = array();
  for ($i=0; $i<count($lines); $i++) {
    array_push($qa,'<b>'.str_replace('</span>','</span>:</b> ',$lines[$i].'<hr />'));
  }
  $file = implode("\n",$qa);
  // spit it out
  tinyRssItem("New feedbacks", $file, "http://ayass.xf.cz/ghost/", "http://ayass.xf.cz/ghost/", md5($file));
  tinyRssFooter();
?>