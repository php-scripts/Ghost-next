<?php
  // answer geographical question about capital cities (e.g. "What is captal city of Uganda?")
  /*
  Data format:
  
  keyword1
  keyword2
  keyword3
  answer
  <empty line> 
  keyword1
  keyword2
  keyword3
  answer
  <empty line>
  ...
  */ 
  require_once "sentence.php";

  function ghostCapitalAsk($ASentence,$ALanguage) {
    // find capital city if asked for one
    $country = "";

    // find questioned country name
    $country = '';
    $openings = explode("\n",file_get_contents("data/$ALanguage/capital-opening.dat"));
    $q = ghostSentencePartString($ASentence,0,99);
    for ($i=0; $i<count($openings); $i++) {
      // does questiong start with this openings?
      $o = trim($openings[$i]);
      $a = strpos($q,$o);
      if ( ($a > 0)||($a===0) ) {
        $country = substr($q,$a+strlen($o)+1,strlen($q));
      }
    } 
    //echo "country = '$country'<br/>";

    // find capital city by country
    if (!empty($country)) {
      $lines = explode("\n",file_get_contents("data/$ALanguage/capital.dat"));
      //echo "lines=".count($lines)."<br/>";
      for ($i=0; $i<count($lines); $i++)
        //echo $lines[$i]." ?= ".$country."<br/>";
        if ($lines[$i] == $country) {
          //echo "match line $i<br/>";
          while ($i<count($lines)) {
            if (empty($lines[$i]))
              return $lines[$i-1];
            $i++;
          }
        }
    }
    
    // TODO: if unable to detect question, we can ignore all words and just look for name of coutnries, e.g. for "????? ??? ????? ?? france ??? ???? ???", valid answer is "Capital of France is Paris"
    // TODO: backward searach "for question containing 'paris', answer could be: I like France"  
    
    // give up
    return '';
  }

  //$sentence = ghostSentence("hlavne mesto barmy?");
  //echo ghostCapitalAsk($sentence,"sk")."<br/>";
?>