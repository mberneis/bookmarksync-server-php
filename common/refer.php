<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#refer.php
//	Copyright (C) 2003  SyncIT.com, Inc.
//	
//	This program is free software; you can redistribute it and/or modify
//	it under the terms of the GNU General Public License as published by
//	the Free Software Foundation; either version 2 of the License, or
//	(at your option) any later version.
//	
//	This program is distributed in the hope that it will be useful,
//	but WITHOUT ANY WARRANTY; without even the implied warranty of
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//	GNU General Public License for more details.
//	
//	You should have received a copy of the GNU General Public License
//	along with this program; if not, write to the Free Software
//	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//	-----------------
//	This library is GPL'd.  If you distribute this program or a derivative of
//	this program publicly you must include the source code.  It is easy
//	enough to drop us an email requesting a different license, if necessary.
//	
//	Author:      Michael Berneis, Terence Way, Lauren Roberts
//	Created:     July 1998
//	Modified:    9/22/2003 by Michael Berneis
//	E-mail:      mailto:opensource@syncit.com
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
?>

<?php
session_name("syncitmain");
	session_start();
include '../inc/asp.php';
include '../inc/db.php';
include '../inc/mail.php';
 
$mainmenu="TELL A FRIEND";
$submenu="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>Refer a Friend</title>
<link rel="StyleSheet" href="syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#660066" vlink="#990000" alink="#CC0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<?php include '../inc/bmenu.php'; ?>
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt=""><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt=""></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_refer.gif" width="503" height="37" alt="SyncIT Tell A Friend"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
<?php

if (!db_connect())
	die();

$email = "";
$allemail = "";

if (isset($_GET['email']))
	$email = $_GET['email'];

if ($email == "")
	$email = $_SESSION['email'];

if ($email == "" && isset($_COOKIE['email']))
	$email = $_COOKIE['email'];

if (!isset($_POST['toemail']) || $_POST['toemail'] != ""){

	if (isset($_POST['email']))
		$email = $_POST['email'];

	if (isset($_POST['toemail']))
		$allemail = $_POST['toemail'];

	if ($email != "" && $allemail != ""){
		$res = mysql_query("SELECT name FROM person WHERE email = '" . $email . "'");
		if (!$res)
			dberror("Cannot retrieve person name in refer.php");
	
		if (mysql_num_rows($res) > 0){
			$data = mysql_fetch_assoc($res);
			$name = $data['name'];
		}
		else
			$name = $email;

		$ID = $_SESSION['ID'];
	    if ($ID == "")
			$ID = 0;
	
	    $note = str_replace("'","''",trim($_POST['note']));
//          1         2         3         4         5         6         7
//012345678901234567890123456789012345678901234567890123456789012345678901
	    $subject="You have been invited to...";
	    $body="...Sign up for BookmarkSync";
	    if ($note != "")
			$body .= ":\r\n\r\n" . $name." (" . $email . ") wrote:\r\n" . makereply($note);
		else
			$body .= ".\r\n";
	
	    $body .= "\r\n";
	    $body .= "BookmarkSync is the award-winning, free tool that synchronizes all of\r\n";
	    $body .= "your Internet favorites or bookmarks for instant access from any\r\n";
	    $body .= "computer in the world.  BookmarkSync also gives you the tools\r\n";
	    $body .= "to publish links to useful Internet sites in your own bookmarks for\r\n";
	    $body .= "your friends, colleagues or the entire BookmarkSync community - it's\r\n";
	    $body .= "a great way to share information!\r\n";
	    $body .= "\r\n";
	    $body .= "For more information, or to download BookmarkSync now, visit our web\r\n";
	    $body .= "site http://www.bookmarksync.com.\r\n";
	    $body .= "\r\n";
	    $body .= "Our commitment: helping you get the most out of the Internet. We look\r\n";
	    $body .= "forward to serving you as a customer.\r\n";
	    $body .= "\r\n";
	    $body .= "Best Regards,\r\n\r\nMichael Berneis\r\nPresident, SyncIT.com\r\n";
	    $body .= "michaelb@syncit.com";
	
		do {
			$I = strpos($allemail,"\r\n");
			if ($I==0)
				break;
			$toemail = substr($allemail,0,$I-1);
			$allemail = substr($allemail,strlen($allemail)-(strlen($allemail)-$I));
			if (is_email_valid($toemail))
				domail($email,$toemail,$subject,$body);
		} while (is_email_valid($allemail));
	
	//	domail($email    $allemail    $subject    $body;
	//	domail($email,"refer@bookmarksync.com","Referral from " . $email,allemail);
		
		echo "<br><h2>Thank you for your referral!</h2>";
		echo "<h3>We have sent your friends the following invitation E-mail:</h3>";
		echo "<img src='../images/psep.gif' width='491' height='10' alt=''><br>";
		echo "<pre><b>Subject:</b> ".$subject."</b><br><b>Body:</b><br>".$body."</pre>";
		$mailsend = true;
		
		$ID = $_SESSION['ID'];
		if ($ID != "" && $ID != 0){
			mysql_query("update person set refercnt = refercnt +1 where person_id = " . $ID);
			$res  = mysql_query("select refercnt from person where person_id = " . $ID);
			if (!$res)
				dberror("Cannot retrieve referral count");
	
			$data = mysql_fetch_assoc($res);
			$refercnt = $data['refercnt'];
		}
		else
			$refercnt = 0;
	
		if ($refercnt == 0){
			$body="Dear SyncIt member,\r\n\r\n";
			$body .= "Thank you very much for referring your friends and colleagues to SyncIt.\r\n";
			$body .= "Your referral means the world to us!\r\n";
			$body .= "Be sure to check out our site's new look at http://www.syncit.com and try out SyncIt Express and MySync Collections.\r\n";
			$body .= "\r\n";
			$body .= "Best Regards,\r\n";
			$body .= "\r\n";
			$body .= "Michael Berneis\r\n";
			$body .= "President SyncIt.com\r\n";
			$body .= "\r\n";
			$body .= "michaelb@syncIt.com\r\n";
			$body .= "http://www.SyncIt.com\r\n";
			$body .= "\r\n";
			$body .= "How are we doing?  Please tell us how we can make you a happy customer.\r\n";
			$body .= "Fill in our survey online at\r\n";
			$body .= "http://SyncIt.com/common/survey.php\r\n";
			$body .= "We have a strict privacy policy (we are TRUSTe licensed) - \r\n";
			$body .= "we do not release names or contact information to any party outside of\r\n";
			$body .= "SyncIT.com.\r\n";
			
			domail("support@bookmarksync.com",$email,"Thank you for your referral",$body);
		}
	}
	else
		$mailsend = false;
}

if (!$mailsend)
{

?>
            <br><h2>Recommend us to Your friends</h2>
            <p>Please enter the required information below so we can send an
            invitation to your friends.</p>
<script language="JavaScript"><!--
function validate(theForm)
{

  if (theForm.email.value == "")
  {
    alert("Please enter a value for the 'Your E-mail' field.");
    theForm.email.focus();
    return (false);
  }

  if (theForm.toemail.value == "")
  {
    alert("Please enter a value for the 'Your friend's e-mail addresses' field.");
    theForm.toemail.focus();
    return (false);
  }
  return (true);
}
//--></script>
<form method="POST" action="refer.php" onsubmit="return validate(this)">
<table border="0">
  <tr>
    <td class="menub" align="right">Your E-mail:</td>
    <td>
        <p><input class="register" type="text" name="email" size="30" value="<?   echo $email; ?>"></p>
    </td>
  </tr>
  <tr>
    <td class="menub" align="right">Your friend's&nbsp;<br>
 E-mail Addresses:<br>
      <br>
      (Enter as many as you like&nbsp; One Address per line)</td>
    <td>
        <textarea rows="6" name="toemail" cols="30" class="register"></textarea>
    </td>
  </tr>
  <tr>
    <td class="menub" align="right">Additional&nbsp;<br>
 Information&nbsp;<br>
 to send:&nbsp;</td>
    <td>
        <textarea rows="6" name="note" cols="30" class="register"></textarea>
    </td>
  </tr>
  <tr>
    <td class="menub" align="right"></td>
    <td align="right">
        <input border="0" src="../images/btninvite.gif" name="I1" type="image" width="62" height="16" alt="Invite">
    </td>
  </tr>
</table>
      </form>
<? } ?>
            </td>
          <td width="10" valign="top">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
</html>

