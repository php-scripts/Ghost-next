<?php
	require "config.php";
	
	if($param["feeedback"] == "off")
	{
		die("Feedback is disabled !!");
	}
	
	if(trim(@$_REQUEST['name']) != "" && trim(@$_REQUEST['feedback']) != "")
	{
	  // save feedback
	  $name = substr(htmlspecialchars(strip_tags($_REQUEST['name'])),0,30);
	  $feedback = str_replace("\n","<br />",htmlspecialchars(strip_tags($_REQUEST['feedback'])));
	  
	  if ($name=='anonymous') $name = '';

	  // store feedback to the begining of feedback file
	  $chat = "";
	  $chat .= "<div class=\"feedback\"><span class=\"name\">$name : </span>$feedback</div>\n";
	  $chat .= file_get_contents('feedback.txt');

	  // keep only first 10 lines
	  $lines = explode("\n",$chat);
	  $lines = array_splice($lines,0,10);
	  $chat = implode("\n",$lines);
	 
	  // save feedback
	  file_put_contents('feedback.txt',$chat);
	}
?>
<html>
	<head>
		<title>Feedback Form</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="img/icon.png" />
    <link rel="alternate" type="application/rss+xml" href="rss-feedback.php" title="Recent feedbacks" />
    <link rel="stylesheet" type="text/css" href="feedback.css" />
	</head>
	<body onload="if (localStorage && localStorage['name']) document.getElementById('name').value = localStorage['name'];">
<!-- feedback form -->
	  <h1>Feedback Form</h1>
      <form action="feedback.php" method="post">
          Name: <br><input id="name" type="text" name="name" value="anonymous"/>
          Message: <br><textarea id="input2" name="feedback"></textarea>
        <div class="buttons">
          <input type="submit" onclick="localStorage.setItem('name',document.getElementById('name').value)"/>
        </div>
      </form>
      <!-- feedback messages -->
      <?php
        $chat = explode("\n",file_get_contents('feedback.txt'));
        for ($i=0; ($i<2*20+1)&&($i<count($chat)-1); $i++)
          echo $chat[$i]."\n";
      ?>
    </body>
</html>
