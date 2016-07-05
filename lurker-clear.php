<?php
  // remote cleanup for lurker logs (so I don't need to connect via ftp)
  
  // current state
  echo "<h3><a href=\"data/en/lurker.dat\">English log</a></h3>";
  echo "<pre>";
  $s = file_get_contents('data/en/lurker.dat');
  echo $s;
  echo "(".(count(explode("\n",$s))-1)." lines total)";
  echo "</pre>";
  
  echo "<h3><a href=\"data/sk/lurker.dat\">Slovak log</a></h3>";
  echo "<pre>";
  $s = file_get_contents('data/sk/lurker.dat');
  echo $s;
  echo "(".(count(explode("\n",$s))-1)." lines total)";
  echo "</pre>";

  // erase them
  if (@$_REQUEST['banana']) {
    file_put_contents('data/en/lurker.dat','');
    file_put_contents('data/sk/lurker.dat','');
    echo "<h3>Logs was ERASED</h3>";
  } else
    echo "<h3>Logs was NOT erased</h3>";
?>
