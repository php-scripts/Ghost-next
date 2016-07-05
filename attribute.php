<?php
  // parse and replace various output attributes ($something;) with actual values

  function ghostAttributeReplace($AAnswer,$ALanguage) {
    // parse answer, replace $something; with value from attribute.dat
    if (strstr($AAnswer,'$')) {
      $attr = explode("\n",file_get_contents("data/$ALanguage/attribute.dat"));
      //print_r($attr);
      for ($a=0; $a<count($attr) / 2; $a++)
        $AAnswer = str_replace($attr[2*$a],$attr[2*$a+1],$AAnswer);
      // some attributes are "smart"
      $AAnswer = str_replace('$time;',date('H:i'),$AAnswer);
      $AAnswer = str_replace('$date;',date('d.m Y'),$AAnswer);
      $AAnswer = str_replace('$month;',date('m'),$AAnswer);
      $AAnswer = str_replace('$year;',date('Y'),$AAnswer);
    }
    return $AAnswer;
  }

?>
