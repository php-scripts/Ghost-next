<?php
  // antispam detection
  
  function isSpam($AQuestion) {
    // return true if questions seems to be spam
    $AQuestion = strtolower($AQuestion);

    // tinychat spam
    if (strstr($AQuestion,'tinychat'))
      return true;

    // .com spam
    if (strstr($AQuestion,'.com'))
      return true;

    // http spam
    if (strstr($AQuestion,'http'))
      return true;

    // bit.ly spam
    if (strstr($AQuestion,'bit.ly'))
      return true;

    // ban by IP address
    if ($_SERVER["REMOTE_ADDR"] == "1.2.3.4")
      return true;
    
    // no spam
    return false;    
  }
  
  function logSpam($AQuestion) {
    // log spammer's IP address
    $ban = file_get_contents('antispam.log');
    $ban .= 'IP='.$_SERVER["REMOTE_ADDR"]." UA=".$_SERVER["HTTP_USER_AGENT"]." REF=".$_SERVER["HTTP_REFERER"]." Q=$AQuestion\n";
    file_put_contents('antispam.log',$ban);
  }
  
  // if (isSpam('hello tinychat.com/asdf')) echo 'SPAM'; else echo "not spam";
  
?>
