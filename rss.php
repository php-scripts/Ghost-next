<?php
  // basic rss feed of recent chats
  require_once "tinyrss.php";
  tinyRssHeader("Recent ghost chat","Last 20 chats from ghost main page","dusan.halicky@gmail.com","http://ayass.xf.cz/ghost/rss.php");
  $file = file_get_contents('chat.txt');
  $lines = explode("\n",$file);
  for ($i=0; $i<count($lines); $i++) {
    $lines[$i] = str_replace('question">','question"><br/>Q: ',$lines[$i]);
    $lines[$i] = str_replace('answer">','answer">A: ',$lines[$i]);
  }
  $file = implode("\n",$lines);
  tinyRssItem("New comments", $file, "http://ayass.xf.cz/ghost/", "http://ayass.xf.cz/ghost/", md5($file));
  tinyRssFooter();
?>