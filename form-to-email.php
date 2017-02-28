<?php
if(!isset($_POST['submit']))
{
  //This page should not be accessed directly. Need to submit the form.
  echo "error; you need to submit the form!";
}
$name = $_POST['name'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];
$subject = $_POST['subject'];


//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Nimi ja email on kohustuslik!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "E-mail on vigane!";
    exit;
}

$email_from = 'marko@murula.pri.ee';//<== update the email address
$email_subject = "Kodulehelt saadetud sõnum $subject";
$email_body = "Sulle on uus sõnum kasutajalt $name.\n".
    "Sõnumi sisu:\n $message";
    
$to = "marko@murula.pri.ee";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body);
//done. redirect to thank-you page.



$message = "Sobis!!";
echo "<script type='text/javascript'>alert('$message');</script>";
echo '<script language="javascript">';
echo 'window.location.href="kolmasleht.html";';
echo '</script>';




// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 