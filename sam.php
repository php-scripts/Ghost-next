<?php
  // simple AI that search in Q-A database
  require_once "sentence.php";

  function ghostSamAsk($ASentence,$ALanguage,$AFile) {
    // search question in file of questions and answers

    // normalize sentence
    $question = ghostSentencePartString($ASentence,0,99);
    //echo "question=$question<br/>";

    // load data file
    $file = file_get_contents("data/$ALanguage/$AFile.dat"); // or die("sam: cannot open '$AFile' for $ALanguage language");
    $lines = explode("\n",$file);

    // find every matching question
    $cache = array();
    for ($i=0; $i<count($lines)/2-1; $i++)
      if ($lines[$i*2] == $question)
        array_push($cache,$lines[$i*2+1]);

    // nothing found?
    if (count($cache) <= 0)
      return '';

    // return random line from cache
    return $cache[rand(0,count($cache)-1)];
  }

?>
