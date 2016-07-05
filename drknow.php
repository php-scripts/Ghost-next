<?php
  // AI for answering basic dictionary questions (what is X, define X, who is X, where is X, ...) 
  require_once "sentence.php";

  function ghostDrknowDefine($ATerm,$ALanguage) {
    // return definition of single term, e.g. "apple" --> "apple is a juicy fruit, usually green or red"
    $file = file_get_contents("data/$ALanguage/drknow.dat");
    $lines = explode("\n",$file);
    $i = array_search($ATerm,$lines);
    if (empty($i))
      return '';
    return $lines[$i+1];
  }

  function ghostDrknowAsk($ASentence,$ALanguage) {
    // look into definitions file
    $p1 = ghostSentencePartString($ASentence,0,0);
    $p2 = ghostSentencePartString($ASentence,0,1);
    $p3 = ghostSentencePartString($ASentence,0,2);
    $max = 20;

    if (in_array($p1,array('whats','define','describe','whos'))) 
      return ghostDrknowDefine(ghostSentencePartString($ASentence,1,$max), $ALanguage);

    if (in_array($p2,array('what is','please define','please describe','co je','who is','kto je'))) 
      return ghostDrknowDefine(ghostSentencePartString($ASentence,2,$max), $ALanguage);

    if (in_array($p3,array('what is it','please define the','please describe the','co je to','kto je to','kto to je'))) 
      return ghostDrknowDefine(ghostSentencePartString($ASentence,3,$max), $ALanguage);

  }  

?>
