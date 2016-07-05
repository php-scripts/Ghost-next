<?php
  // rss feed of recent user's improvements
  require "config.php";
  require "tinyrss.php";
  $lang = 'en';
  tinyRssHeader("Recent user improvements - $lang","Last 20 improvements submited by users in $lang language","dusan.halicky@gmail.com","http://ayass.xf.cz/ghost/rss-improve.php");
  $file = file_get_contents("data/$lang/improve.dat");
  $lines = explode("\n",$file);
  $qa = array();
  for ($i=0; $i<count($lines) / 2 - 1; $i++) {
    array_push($qa,'Q: '.$lines[2*$i].'<br/>A: '.$lines[2*$i+1].'<br/><br/>');
    if ($i >= 20)
      break;
  }
  $file = implode("\n",$qa);
  tinyRssItem("New improvements", $file, $param["wsite_url"], $param["wsite_url"]."data/$lang/improve.dat", md5($file));
  tinyRssFooter();
?>
