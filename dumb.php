<?php
  // very dumb AI, but always know the answer because it simply reply random sentence, e.g. "yeah", "interesting", "hmm", ...

  function ghostDumbAsk($AQuestion,$ALanguage) {
    // reply random sentence from data file
    $file = file_get_contents("data/$ALanguage/dumb.dat");
    $lines = explode("\n",$file);
    $r = rand(0,count($lines)-1);
    return $lines[$r];
  }
   
?>
