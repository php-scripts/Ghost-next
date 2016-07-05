<?php

  session_start();
  error_reporting(0);
  
  require "config.php";

  if(!isset($_SESSION["chat"]))
  {
	  $_SESSION["chat"] = "";
  }
  
  if(isset($_GET["clear"]))
  {
	  $_SESSION["chat"] = "";
	  header("Location: ".$param["wsite_url"]);
	  exit;
  }
  
  if(trim(@$_REQUEST['question']) != "")
  {
	  // parse and answer question
	  $question = trim(str_replace("\n"," ",htmlspecialchars(strip_tags($_REQUEST['question']))));
	  $answer = '';

	  $debug = (@$_REQUEST['debug'] == 'true');

	  if ($debug)
		header('Content-Type: text/plain; charset=utf-8');

	  if ( $question != '' ) {

		// include parts
		require_once "drknow.php";
		require_once "dumb.php";
		require_once "lurker.php";
		require_once "sentence.php";
		require_once "sam.php";
		require_once "variation.php";
		require_once "topic.php";
		require_once "eval.php";
		require_once "capital.php";
		require_once "asdf.php";
		require_once "antispam.php";
		require_once "attribute.php";
		require_once "next/common.php";
		require_once "next/next.php";

		// split question to words
		$sentence = ghostSentence($question);
		
		if ($debug) {
		  print_r($sentence);
		  echo "<br/>\n";
		}

		// detect language    
		$language = "en";

		// ask various AI one by one
		
		// detect spam
		if (isSpam($question)) {
		  logSpam($question);
		  $question = '[SPAM REMOVED]';
		  $answer = 'Sorry but your question was detected to be spam!';
		}
		
		// function for detecting which engine first replied
		$who_answered = 'nobody';
		function who($AEngine) {
		  global $who_answered, $answer;
		  if (!empty($answer))
			if ($who_answered == 'nobody')
			  $who_answered = $AEngine;
		}

		// first is just a logger
		if (empty($answer)) $answer = ghostLurkerAsk('human: '.$question,$language);
		
		// AI improved by users
		if (empty($answer)) $answer = ghostSamAsk($sentence,$language,'improve');     who('improve');

		// real AIs
		if (empty($answer)) $answer = ghostEvalAsk($question);                        who('eval');
		if (empty($answer)) $answer = ghostDrknowAsk($sentence,$language);            who('drknow');
		if (empty($answer)) $answer = ghostCapitalAsk($sentence,$language);           who('capital');
		if (empty($answer)) $answer = ghostSamAsk($sentence,$language,'sam');         who('sam');
		if (empty($answer)) $answer = ghostVariationAsk($sentence,$language);         who('variation');
		if (empty($answer)) $answer = ghostAsdfAsk($question,$language);              who('asdf');
		if (empty($answer)) $answer = ghostNextAsk($question,$language,20,0.5,3);     who('next');
		if (empty($answer)) $answer = ghostTopicAsk($sentence,$language);             who('topic');

		// dumb is last resort
		if (empty($answer)) $answer = ghostDumbAsk($sentence,$language);              who('dumb');

		// parse answer for attributes
		$answer = ghostAttributeReplace($answer,$language);

		// lets lurker also log answer (so we see in lurker's log what was question and answer)
		ghostLurkerAsk("GHOST: $answer\n",$language);

		if ($debug)
		  echo "Q: $question<br/>\nA: $answer<br/>\n";

		// store answer to the begining of chat file
		$_SESSION["chat"] .= "<div class=\"question\">$question</div>\n";
		$_SESSION["chat"] .= "<div class=\"answer\">$answer<a class=\"improve\" title=\"Improve the answer , Engine: $who_answered\" href=\"improve.php?question=$question&answer=$answer\">&#9997;</a></div>\n";
	  }
	  
	  if ($debug) exit;
  }
  
  if (@$_GET["log"] != "off" || $param["slog_stat"] == "on") {
        $fp = fopen('log.txt', 'a');
        fwrite($fp,"\n[".date(DATE_RFC822)."]\n");
        fwrite($fp,$_SERVER["REMOTE_ADDR"]."\n");
        fwrite($fp,@$_SERVER["HTTP_USER_AGENT"]."\n");
        fwrite($fp,@$_SERVER["HTTP_REFERER"]."\n");
        fclose($fp);
    }

?>
<html>
	<head>
		<title>Ghost</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="img/icon.png" />
    <link rel="alternate" type="application/rss+xml" href="rss.php" title="Ghost recent chats" />
    <link rel="alternate" type="application/rss+xml" href="rss-improve.php" title="Recent english improvements" />
    <link rel="alternate" type="application/rss+xml" href="rss-feedback.php" title="Recent feedbacks" />
    <link rel="stylesheet" type="text/css" href="index.css" />
    <script src="index.js"></script>
	</head>
	<body onload="document.getElementById('input1').focus();log_adapt();">
	<script>
	    function link()
	    {
		window.location.href = "<?php echo $param["site_link"]; ?>";
	    }
	</script>
    <?php
      if ($_SERVER['HTTP_HOST'] == 'localhost') {
        echo '<center><div style="border: 1px solid gray; background: #FFFFAA;">localhost</div></center>';
      }
    ?>

    <div id="logo" onclick="link()"></div>
    <br>

    <!-- chat messages -->
    <div class="messages" id="ghost-log">
    <?php
      //  no question, so only show chats
      echo $_SESSION["chat"];
	?>  
	</div>
	
	<!-- char form -->
    <form action="<?php echo $param["wsite_url"]; ?>" method="post">
	<input id="input1" type="text" name="question" autocomplete="off" autofocus />
	<br/>
	<b>English Only</b>
	<input type="submit" id="top_sub"/>
	<input type="button" onclick="window.location.href = '?clear'" id="top_sub" value="Clear Chat Log">
	<?php
	if($param["feeedback"] == "on")
	{
		echo '<input type="button" onclick="feedback()" id="top_sub" value="Feedback Form">';
	}
	?>
	</form>  
    
     
        <div class="copy">© <?php echo date("Y"); ?> <a href="<?php echo $param["site_link"]; ?>"><?php echo $param["site_shrt"]; ?></a> </div>
    
	</body>
</html>
