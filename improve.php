<html>
	<head>
		<title>Ghost - Improve</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="img/icon.png" />
    <link rel="alternate" type="application/rss+xml" href="rss.php" title="Ghost recent chats" />
    <link rel="alternate" type="application/rss+xml" href="rss-pending.php" title="Pending corrections" />
    <link rel="stylesheet" type="text/css" href="index.css" />
	</head>
	<script src="index.js"></script>
  
	<body>
  
    <div id="logo"></div>

    <h3>1. Question - Answer</h3>
    
    <p>
    This is very simple engine. You can only assign answer to exact question (although ghost take care of diacritics,
    small/capital letters, comas, exclamation and question marks, etc...).
    </p>
  
    <form action="improve-add.php" method="get">
      <?php
        require_once "next/common.php";
        require_once "sentence.php";
        $question = str_replace("\n"," ",htmlspecialchars(strip_tags($_REQUEST['question'])));
        $answer = str_replace("\n"," ",htmlspecialchars(strip_tags($_REQUEST['answer'])));
      ?>

      <div class="improve">Question</div>
      <input type="text" name="question" value="<?php echo$question?>" />

      <div class="improve">Original answer</div>
      <input type="text" name="answer" value="<?php echo$answer?>" />

      <div class="improve">Improved answer</div>
      <input type="text" name="improved" autofocus />
      
      <input class="improve" type="submit" />
      
    </form>  

    <hr />

    <h3>2. Topic engine</h3>
    
    <p>Instead of simple question-answer engine, you can use more advanced topic analyzer engine. 
    There are search terms and possible answers. Search terms can be of 3 types: sentence start with something, 
    sentence contain something, sentence end with something. You can also use # to specify matching expression
    and ~ for rest of the sentence. For example:</p>
    
    <pre>
    Sentence contain: pizza
    Sentence contain: apple
    Answers:
      I love it too
      I like it too
      Omg, they are delicious!
    </pre>
    
    <p>Or using # you can specify what exactly is liked:</p>
    
    <pre>
    Sentence contain: pizza
    Sentence contain: apple
    Sentence contain: beer and wine
    Answers:
      I love # too
      I like # too
      Omg, # is the best!
    </pre>
    
    <p>The ~ character for rest of the sentence can be used like this:</p>
    
    <pre>
    Sentence start with: I was born in
    Answers:
      I like ~
      I never visited ~
      
    Q: I was born in London
    A: I like London
    Q: Do you know I was born in London
    A: I like London
    Q: I was born in small town in europe
    A: I like small town in europe
    </pre>
    
    <form action="improve-add-topic.php" method="get">
      <?php
        require_once "sentence.php";
        $question = str_replace("\n"," ",htmlspecialchars(strip_tags($_REQUEST['question'])));
        $answer = str_replace("\n"," ",htmlspecialchars(strip_tags($_REQUEST['answer'])));
      ?>

      <div class="improve">Matching expressions</div>

      <select name="type1">
        <option value="^">Sentence start with</option>
        <option value="*" selected>Sentence contain</option>
        <option value="$">Sentence end with</option>
      </select>
      <input type="text" name="match1" style="width: 20em" />
      <br />

      <select name="type2">
        <option value="^">Sentence start with</option>
        <option value="*" selected>Sentence contain</option>
        <option value="$">Sentence end with</option>
      </select>
      <input type="text" name="match2" style="width: 20em" />
      <br />

      <select name="type3">
        <option value="^">Sentence start with</option>
        <option value="*" selected>Sentence contain</option>
        <option value="$">Sentence end with</option>
      </select>
      <input type="text" name="match3" style="width: 20em" />
      <br />

      <select name="type4">
        <option value="^">Sentence start with</option>
        <option value="*" selected>Sentence contain</option>
        <option value="$">Sentence end with</option>
      </select>
      <input type="text" name="match4" style="width: 20em" />
      <br />

      <select name="type5">
        <option value="^">Sentence start with</option>
        <option value="*" selected>Sentence contain</option>
        <option value="$">Sentence end with</option>
      </select>
      <input type="text" name="match5" style="width: 20em" />
      <br />

      <div class="improve">Possible answers (put multiple answers on separate lines)</div>
      <textarea name="answers" style="width: 30em; height: 10em;">
      </textarea>
      
      <input class="improve" type="submit" />
      
    </form>      

      
    
	</body>
</html>
