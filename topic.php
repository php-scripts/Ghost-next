<?php
  // AI that search for bits of topic indicators. E.g. if sentence contain word "pizza", AI will say how much he likes pizza. It was mostly used in TMW to understand "I sell XYZ" sentences.
  require_once "sentence.php";

  function ghostTopicAsk($ASentence,$ALanguage) {
    // search topics in sentence

    // normalize question
    $question = ghostSentencePartString($ASentence,0,99);

    // load data file
    $lines = explode("\n",file_get_contents("data/$ALanguage/topic.dat"));
    
    // all correct answers
    $cache = array(); 
  
    // parse topics file
    for ($t=0; $t<count($lines); $t++) {
      
      // begining of topic
      if ($lines[$t] == '[TOPIC]') {
        //echo "------\n";
        $re = array();    // current possible replies, not yet validated
        while ($lines[$t] != '[TOPIC END]') {
          $t++;
          $c = substr($lines[$t],0,1);
          if ($c=='[')
            continue;
          $s = substr($lines[$t],1,999);
          //echo "c:=$c s:=$s\n<br/>";
          switch ($c) {
            case '^': 
              // question starts with s
              if (strpos(' '.$question,$s) == 1) {
                // sign ~ means rest of the sentence, # means "s" itself
                for ($r=0; $r<count($re); $r++) {            
                  $re[$r] = str_replace('#',substr($question,strlen($s)+1,999),$re[$r]);
                  $re[$r] = str_replace('~',substr($question,strlen($s)+1,999),$re[$r]);
                  //echo $re[$r]."\n";
                }
                $cache = array_merge($cache,$re);
                //echo "match: '$c$s' in '$question'\n";
                //echo "s=$s\n";
              }
              break;
            case '$': 
              // question ends with s
              $p = strpos(' '.$question,$s);
              //echo "zzz=".strpos(' '.$question,$s)."<br/>\n";
              if ( ($p!='')&&(strpos(' '.$question,$s) == strlen($question) - strlen($s)) ) {
                $cache = array_merge($cache,$re);
                //echo "match: '$c$s' in '$question'\n";
              }
              break;
            case '*': 
              // je aktualny riadok v otazke?
              //echo "matching '*' for '$s' in '$question'\n";
              if (strpos(' '.$question,$s) > 0) {
                for ($r=0; $r<count($re); $r++) {
                  $re[$r] = str_replace('#',$s,$re[$r]);
                  $re[$r] = str_replace('~',substr($question,strpos($question,$s)+strlen($s)+1,999),$re[$r]);
                  //echo "question=$question s=$s r=".$re[$r];
                  //die();
                }                  
                $cache = array_merge($cache,$re);
                //echo "--> FOUND !!!\n";
              }
              break;
            default:
              // no matching, this is one of possible replies
              array_push($re,$lines[$t]);
          }
        }
      }
    }

    // nothing found?
    if (count($cache) <= 0)
      return '';

    // return random line from cache
    return $cache[rand(0,count($cache)-1)];
  }

?>
