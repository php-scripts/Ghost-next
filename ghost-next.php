<?php
  // main testing page for ghost-next
  header('Content-Type: text/html; charset=utf-8');

  require_once "next/next.php";
  require_once "attribute.php";

  // get user data
  $question = ghostParamStr('question','');
  $min = ghostParamFloat('min',0.5);
  $limit = ghostParamInt('limit',20);
  $random = ghostParamInt('random',5);
  if ($random <= 0)
    $random = 1;
  $debug = ghostParamBool('debug',false);
  $details = ghostParamBool('details',false);
  $language = ghostLanguage();
  $balance = ghostParamFloat('balance',0.5);
?>
<html>
  <head>
    <title>ghost-next</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <!-- link rel="stylesheet" href="style.css" type="text/css" / -->
    <!-- link rel="shortcut icon" href="favicon.ico" type="image/x-icon" / -->
    <style>
    table,tr,th,td {
      text-align: left;
      border: 1px solid gray;
      border-collapse: collapse;
    }
    table {
      min-width: 30em;
    }
    td.good {
      font-weight: bold;
      color: green;
    }
    td.best {
      font-weight: bold;
      color: blue;
    }
    td.similar {
      font-weight: bold;
      color: orange;
    }
    div.answer {
      color: red;
    }
    </style>
  </head>
  <body>
  <form>
<?php
  echo "Question <input name=\"question\" value=\"$question\" size=\"80\" autofocus />";
  echo "Max answers <input name=\"limit\" value=\"$limit\" type=\"number\" min=\"1\" max=\"1000\" step=\"1\" />";
  echo "Balance <input name=\"balance\" value=\"$balance\" type=\"number\" min=\"0.0\" max=\"5.0\" step=\"0.1\" />";
  echo "Random <input name=\"random\" value=\"$random\" type=\"number\" min=\"1\" max=\"1000\" step=\"1\" />";
  echo "<select name=\"lang\"><option ".($language=='en'?'selected':NULL).">en</option><option ".($language=='sk'?'selected':NULL).">sk</option>";
  echo "<input name=\"debug\" id=\"debug\" ".($debug?'checked':NULL)." type=\"checkbox\" /><label for=\"debug\">Debug</label>";
  echo "<input type=\"submit\"></form>";

  $a = ghostNextAsk($question,$language,$limit,$balance,$random,$debug);
  echo "<div class=\"answer\">Answer: <b>".ghostAttributeReplace($a,$language)."</b></div>";
  if ($question != '') {
    $n = implode(' ',ghostNextStems($question,'tokenizerSimple','stemmerSimple',10));
    ghostLog("Q:$n\nA:$a\n\n","data/$language/next.log");
  }

/*
  echo "<hr/>\n";
  $question = "test number four";
  $language = "en";
  $answer = ghostNextAsk($question,$language,20,0.5,3);     
  echo "question=$question answer=$answer";
*/
  
?>
