<?php
  // AI that perform various modifications on sentence and repeat query in conventional SAM
  require_once "sentence.php";
  require_once "sam.php";

  function ghostVariationLeetspeak($ASentence,$ALanguage) {
    // remove leetspeak from sentence
    for ($i=0; $i<count($ASentence); $i++) {
      $ASentence[$i] = str_replace('x','ch',$ASentence[$i]);
      $ASentence[$i] = str_replace('w','v',$ASentence[$i]);
    }
    return $ASentence;
  }

  function ghostVariationDialect($ASentence,$ALanguage) {
    // replace dialect words with propper one
    // load dictionary
    $dict = explode("\n",file_get_contents("data/$ALanguage/dialect.dat"));
    $cd2 = count($dict) / 2;
    // replace all worlds
    for ($i=0; $i<count($ASentence); $i++)
      for ($d=0; $d<=$cd2; $d=$d+2)
        if ($ASentence[$i] == $dict[$d])
          $ASentence[$i] = $dict[$d+1];
    return $ASentence;
  }

  /*
  Current SAM data has no question marks for question, therefore not required
  function ghostVariationQuestionMark($ASentence,$ALanguage) {
    // add or remove question mark
    if ($ASentence[count($ASentence)-1] == '?')
      $ASentence = array_splice($ASentence,0,count($ASentence)-1);
    else
      array_push($ASentence,'?');
    return $ASentence;
  }
  */

  function ghostVariationRemoveOpening($ASentence,$ALanguage) {
    // remove unnecessary opening words
    // NOTE: this would be probably possible to do in dialect by replacint such words with empty string which will then be removed
    if (
         ($ASentence[0] == 'well')||
  	     ($ASentence[0] == 'a')||
  	     ($ASentence[0] == 'ale')||
  	     ($ASentence[0] == 'hm')||
  	     ($ASentence[0] == 'hmm')||
  	     ($ASentence[0] == 'oh')
       )
      $ASentence = array_splice($ASentence,1,count($ASentence)-1);
    return $ASentence;
  }

  function ghostVariationAsk($ASentence,$ALanguage) {
    // search question in file of questions and answers
    // do all possible combinations
    for ($i=0; $i<2*2*2; $i++) {
      $s = $ASentence;
      if ($i & 1) $s = ghostVariationLeetspeak($s,$ALanguage);
      if ($i & 2) $s = ghostVariationDialect($s,$ALanguage);
      if ($i & 4) $s = ghostVariationRemoveOpening($s,$ALanguage);
      // ask modified sentence
      $s = ghostSamAsk($s,$ALanguage,'sam');
      if ($s != '')
        return $s;
    }
    return '';
  }

?>
