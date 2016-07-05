<?php
  // add improved Q-A to data file
  require_once "next/common.php";
  require_once "sentence.php";
  
  $question = trim(str_replace("\n"," ",htmlspecialchars(strip_tags($_REQUEST['question']))));
  $improved = trim(str_replace("\n"," ",htmlspecialchars(strip_tags($_REQUEST['improved']))));
  
  // normalize question (otherwise sam will be unable to find it)
  $sentence = ghostSentence($question);
  $question = ghostSentencePartString($sentence,0,99);
  
  // guess language 
  $language = "en";

  // append question to log
  if ( (!empty($question))&&(!empty($improved)) ) {
    $f = fopen("data/$language/improve.dat", "a") or die("improve: can't open $language file");
    fwrite($f, $question."\n");
    fwrite($f, $improved."\n");
    fclose($f);  
  }

  // done
  header("Location: index.php?lang=$language");

?>
