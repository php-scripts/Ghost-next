<?php
  // add improved TOPIC to data file
  require_once "next/common.php";
  require_once "sentence.php";
  
  // FIXME: make it universal, not just 5, I didnt have time/willpower so I copy-pasted it :(

  // guess language 
  $language = "en";
  
  // get parameters
  $type1 = ghostParamStr('type1'); $match1 = ghostParamStr('match1'); echo "type=$type1 match=$match1<br/>";
  $type2 = ghostParamStr('type2'); $match2 = ghostParamStr('match2'); echo "type=$type2 match=$match2<br/>";
  $type3 = ghostParamStr('type3'); $match3 = ghostParamStr('match3'); echo "type=$type3 match=$match3<br/>";
  $type4 = ghostParamStr('type4'); $match4 = ghostParamStr('match4'); echo "type=$type4 match=$match4<br/>";
  $type5 = ghostParamStr('type5'); $match5 = ghostParamStr('match5'); echo "type=$type5 match=$match5<br/>";
  
  // normalize matches
  $match1 = ghostSentenceNormalize($match1);
  $match2 = ghostSentenceNormalize($match2);
  $match3 = ghostSentenceNormalize($match3);
  $match4 = ghostSentenceNormalize($match4);
  $match5 = ghostSentenceNormalize($match5);
  
  // check types
  if ( ($type1 != '*')&&($type1 != '^')&&($type1 != '$') ) die("improve: type1 is invalid!");
  if ( ($type2 != '*')&&($type2 != '^')&&($type2 != '$') ) die("improve: type2 is invalid!");
  if ( ($type3 != '*')&&($type3 != '^')&&($type3 != '$') ) die("improve: type3 is invalid!");
  if ( ($type4 != '*')&&($type4 != '^')&&($type4 != '$') ) die("improve: type4 is invalid!");
  if ( ($type5 != '*')&&($type5 != '^')&&($type5 != '$') ) die("improve: type5 is invalid!");
  
  // get answers
  $answers = explode("\n",@$_REQUEST['answers']);
  for ($a=0;$a<count($answers);$a++)
    $answers[$a] = trim(str_replace("\n"," ",htmlspecialchars(strip_tags($answers[$a]))));
  echo "<pre>";
  print_r($answers);
  echo "</pre>";
  
  // create topic data
  $topic = "[TOPIC]\n";
  // answers
  for ($a=0;$a<count($answers);$a++)
    if ($answers[$a] != '')
      $topic .= $answers[$a]."\n";
  // type+match
  if ($match1 != '') $topic .= "$type1$match1\n";
  if ($match2 != '') $topic .= "$type2$match2\n";
  if ($match3 != '') $topic .= "$type3$match3\n";
  if ($match4 != '') $topic .= "$type4$match4\n";
  if ($match5 != '') $topic .= "$type5$match5\n";
  $topic .= "[TOPIC END]\n\n";

  // actually write the data (lets be brave/lazy, write directly to topic.dat)
  if ( (count($answers) > 0)&&($match1 != '') ) {
    $f = fopen("data/$language/topic.dat", "a") or die("improve-add-topic: can't open $language file");
    fwrite($f, $topic);
    fclose($f);  
    // done
    echo "<h3>Written data:</h3>\n";
    echo "<pre>\n";
    echo "$topic\n";
    echo "</pre>\n";
    header("Location: index.php?lang=$language");
  }

?>
