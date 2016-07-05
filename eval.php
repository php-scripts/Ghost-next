<?php
  // very simple math evaluation (e.g. 2*3+1)
  // TODO: Later use this: http://www.phpclasses.org/package/2695-PHP-Safely-evaluate-mathematical-expressions.html (but it is currently not available because of one of the most stupidly designed site ever, registration was incredibly complicated and it do not even work in the end)
  require_once "sentence.php";
  
  function ghostEval($AExpression) {
    // evaluate matematical expression
    // limit expression length
    $AExpression =  substr($AExpression,0,30);
    // create new string with same length
    $s = str_repeat(' ',strlen($AExpression));
    // keep only safe characters
    for ($i=0; $i<strlen($s); $i++)
      if (strstr(' 0123456789\.+-*/()',$AExpression[$i]))
        $s[$i] = $AExpression[$i];
    // evaluate it
    //echo "eval('return($s);')\n";
    return eval("return $s;");
  }
  
  function ghostEvalAsk($AQuestion) {
    // analyze if question contain math and try to calculate it
    $AQuestion = ghostSentenceNormalize($AQuestion); 
    //echo "q=$AQuestion\n";
    $a = array(
        'how much is ','count ','evaluate ', 'what is ','calculate ');
    $b = false;
    for ($i=0; $i<count($a); $i++)
      if (strstr($AQuestion,$a[$i])) {
        //echo "found!\n";
        $b = true;
        $AQuestion = str_replace($a[$i],'',$AQuestion);
      }
    if ($b)
      return ghostEval($AQuestion);
    return '';
  }

?>
  
  
  
