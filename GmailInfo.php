
<?php
// WeTrain - Used to recieve and send new mail. This mail is then sent as text message to phone (for client trainers)
set_time_limit(4000);
 
// Connect to gmail
$imapPath = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'email_id@gmail.com';
$password = 'gmail_password';
 
// try to connect
$inbox = imap_open($imapPath,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
 
 
// search and get unseen emails, function will return email ids
$emails = imap_search($inbox,'UNSEEN');
 
$output = '';
 
foreach($emails as $mail) {
    
    $headerInfo = imap_headerinfo($inbox,$mail);
    
    $output .= $headerInfo->subject.'<br/>';
    $output .= $headerInfo->toaddress.'<br/>';
    $output .= $headerInfo->date.'<br/>';
    $output .= $headerInfo->fromaddress.'<br/>';
    $output .= $headerInfo->reply_toaddress.'<br/>';
    
    $emailStructure = imap_fetchstructure($inbox,$mail);
    
    if(!isset($emailStructure->parts)) {
         $output .= imap_body($inbox, $mail, FT_PEEK);
    }
   echo $output;
   $output = '';
}
 
// colse the connection
imap_expunge($inbox);
imap_close($inbox);
?>
