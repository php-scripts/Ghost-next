<?php
  // this engine detects gibberish words like "ghgjjhgjhgjghjfhfh"
  
  function ghostAsdfAsk($question,$language) {
    // detect gibberish words by counting occurances of characters in single words questions
    if (function_exists('mb_strtolower'))
      $question = mb_strtolower($question,'utf8');
    else
      $question = strtolower($question);
    
    // multiple words means regular sentence
    if (strstr($question,' '))
      return '';
      
    // count characters
    $c = array();
    $qlen = strlen($question); 
    if (function_exists('mb_strlen'))
      $qlen = mb_strlen($question);
    for ($i=0;$i<$qlen;$i++) {
      $z = $question[$i];
      if (@!$c[$z])
        $c[$z] = 0;
      $c[$z]++;
    }
    //echo count($c);

    // sort by number descending
    $cv = array_values($c);
    natsort($cv);
    $cv = array_reverse($cv);
    
    //echo "<pre>"; print_r($cv); echo "</pre>";
    
    // calculate indicators
    $u = round(100*count($c)/strlen($question));  // number of unique characters ("abcd"=100, "aaaa"=25)
    $a = round(100*$cv[0]/strlen($question));     // occurance of most common character in percents, for "aaaa" it is 100. for "aaab" it is 75, for "well" it is 50
    $b = round(100*$cv[1]/strlen($question));     // occurance of second most common character ("aaaa"=0, "well"=25)
    $na = 100-$a;
    $nb = 100-$b;
    $score = round(-2*$u + 2*$a + $b);
    if (@$_REQUEST['test'])
      echo " u=$u a=$a b=$b na=$na nb=$nb score=$score ";

    // correct words 
    if ($score < 0) 
      return '';
      
    // reply to gibberish words
    $r = array();
    if ($language=='en') {
      array_push($r,"Word '$question' does not look like real word to me");
      array_push($r,"Dude, what's '$question'");
      array_push($r,"Stop talking '$question' gibberish");
      array_push($r,"There is no such word like '$question'");
      array_push($r,"$question? what do you mean by that?");
      array_push($r,"I don't understand '$question'");
    }
    if ($language=='sk') {
      array_push($r,"Slovo '$question' nevyzerá ako ozajstné slovo");
      array_push($r,"Kámo, čo je to '$question'");
      array_push($r,"Prestaň hovoriť '$question'");
      array_push($r,"Myslím že neexistuje slovo ako '$question'");
      array_push($r,"$question? čo tým myslíš?");
      array_push($r,"Nerozumiem slovu '$question'");
    }
    
    return $r[array_rand($r)];
  }
  
  // test 
  if (@$_REQUEST['test']) {
    $asdf_yes = array('jjkgjgjgjkbj','ghgjjhgjhgjghjfhfh','jkhjhkj','gjgjghjgj','hfhfhfh','aaaaaaaaaaaaaaaabcd','aosdnvawne','asdfasdf');
    $asdf_no = array('well','hello','yes','maybe','potopa','apple','coordination','successfull','mama');
    $language = 'en';

    echo "<hr/>\n";
    for ($i=0; $i<count($asdf_yes); $i++)
      echo $asdf_yes[$i]." = ".ghostAsdfAsk($asdf_yes[$i],$language)." <br/>\n";

    echo "<hr/>\n";
    for ($i=0; $i<count($asdf_no); $i++)
      echo $asdf_no[$i]." = ".ghostAsdfAsk($asdf_no[$i],$language)." <br/>\n";
  }
?>