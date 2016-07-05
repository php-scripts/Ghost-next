<?php
  // This AI module never know the answer, but he remember every question and store it to log

  function ghostLurkerAsk($AQuestion,$ALanguage) {
    // append question to log
    if ($_SERVER['HTTP_HOST'] != 'localhost') {
      $f = fopen("data/$ALanguage/lurker.dat", "a") or die("lurker: can't open data/$ALanguage/lurker.dat file for append");
      fwrite($f, $AQuestion."\n");
      fclose($f);  
      return '';  
    } else {
      // on localhost use different log
      $f = fopen("data/$ALanguage/lurker.local", "a") or die("lurker: can't open data/$ALanguage/lurker.local file for append");
      fwrite($f, $AQuestion."\n");
      fclose($f);  
      return '';  
    }
  }

?>
