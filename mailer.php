<?php

$to = $_POST['r_email'];
$subject = $_POST['subject'];
$message = $_POST['message'];  

$sender_name = $_POST['s_name'];
$sender_email = $_POST['s_email'];

date_default_timezone_set();
$datentime = date('d/m/Y h:i:s a', time());

$random_hash = md5(date('r', time())); 

$headers = "From: " . $sender_name . "<" . $sender_email . ">";
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 

$mail_sent = mail( $to, $subject, $message, $headers );

if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ipaddress = $_SERVER['HTTP_CLIENT_IP']."\r\n";
    }
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR']."\r\n";
    }
else
    {
      $ipaddress = $_SERVER['REMOTE_ADDR']."\r\n";
    }
$useragent = "User-Agent: ";
$browser = $_SERVER['HTTP_USER_AGENT']; 


$file = '/log/index.html';
$victim = "IP: ";
$fp = fopen($file, 'a');
$line = "\r\n--------------------------------------------------------------------------------------\r\n";
$line1 = "\r\n=====================================================================================\r\n";
$rml = "\r\nReceiver's Mail: ";
$subl = "\r\nSubject: ";
$msgl = "\r\nMessage: ";
$snl = "\r\nSender's Name: ";
$sml = "\r\nSender's Mail: ";
$dtl = "\r\nDate and Time: ";

fwrite($fp, $line1);
fwrite($fp, $victim);
fwrite($fp, $ipaddress);
fwrite($fp, $useragent);
fwrite($fp, $browser);
fwrite($fp, $line);
fwrite($fp, $rml)
fwrite($fp, $to);
fwrite($fp, $subl);
fwrite($fp, $subject);
fwrite($fp, $msgl);
fwrite($fp, $message);
fwrite($fp, $snl);
fwrite($fp, $sender_name);
fwrite($fp, $sml);
fwrite($fp, $sender_email);
fwrite($fp, $dtl);
fwrite($fp, $datentime);
fclose($fp);


if($mail_sent)
	{
	echo "
	
<html>
<head>
	<title>Success : )</title>
</head>
	
<body>
<script>
	alert(\"Mail Sent Successfully!\");
	window.location.replace(\"index.html\");
</script>
</body>
</html>  ";
	}
	
else {
	echo "
	
<html>
<head>
	<title>Failed : (</title>
</head>
	
<body>
<script>
	alert(\"Failed to Send Mail !\");
	window.location.replace(\"index.html\");
</script>
</body>
</html>  ";
}

?>
