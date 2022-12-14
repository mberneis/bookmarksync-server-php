<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#verify.php
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
include '../inc/welcome.php';

$GLOBALS['mainmenu'] = "REGISTER";
$GLOBALS['submenu'] = "";

$email = "";
if (isset($_POST['email)){
	$email = $_POST['email'];
	if ($email == ""){
		if (isset($_COOKIE['email']))
			$email = $_COOKIE["email"];
	}
}
else {
	restricted("../inc/verify.php");
	$_SESSION['email'] = $email;
	setcookie("email",$email);
	domail("support@bookmarksync.com",$email,"Welcome to BookmarkSync",welcometxt($_SESSION['name'],syncit_ncrypt($ID)));
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>SyncIT - E-mail verification</title>
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
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><a href="../news/"><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt="QuickSync News"></a><a href="../express/"><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt="SyncIT Express"></a></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/header_login_register.gif" width="503" height="37" alt="SyncIT Login &amp; Registration"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
<!-- * -->
            <br><h2>E-mail Verification</h2>
<?php
if (isset($_POST['email'] && $_POST['email'] != "")
	echo "We have sent you a new welcome letter to your e-mail address at <b>" . $email . "</b>.";
else {
	if (isset($_GET['id']))
		$vid = $_GET["id"];
	if ($vid == ""){
?>
This service is only available to SyncIT users who have verified their e-mail
address. In your initial welcome e-mail we provided a link to our site to
complete the e-mail verification. If you have not received this letter you may
have mis-spelled your e-mail address.&nbsp;<br>
Below you will find the e-mail address we currently have in our records. Please check
it carefully and make any necessary corrections.&nbsp;<br>
Then press <b>Resend Verification</b> and we will re-send you our
welcome letter.<script Language="JavaScript"><!--
function validate(theForm)
{

  if (theForm.email.value == "")
  {
    alert("Please enter a value for the \"E-mail\" field.");
    theForm.email.focus();
    return (false);
  }

  if (theForm.email.value.length > 50)
  {
    alert("Please enter at most 50 characters in the \"E-mail\" field.");
    theForm.email.focus();
    return (false);
  }

  var checkOK = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz??????????????????????????????????????????????????????????????????????0123456789-.@-_";
  var checkStr = theForm.email.value;
  var allValid = true;
  for (i = 0;  i < checkStr.length;  i++)
  {
    ch = checkStr.charAt(i);
    for (j = 0;  j < checkOK.length;  j++)
      if (ch == checkOK.charAt(j))
        break;
    if (j == checkOK.length)
    {
      allValid = false;
      break;
    }
  }
  if (!allValid)
  {
    alert("Please enter only letter, digit and \".@-_\" characters in the \"E-mail\" field.");
    theForm.email.focus();
    return (false);
  }
  return (true);
}
//--></script>
<form method="POST" action="verify.php" onsubmit="return validate(this)" name="form1">
  <p><input type="text" name="email" size="30" maxlength="50" value="<?     echo $email; ?>"><input type="submit" value="Resend Verification" name="B1" class="pbutton"></p>
</form>
<p>Upon receipt please click on the verification URL provided in our e-mail.&nbsp;
<?php
	}
	else {
		if (!db_connect())
			die();

		$res = mysql_query("update person set lastverified=now() where personid=" . syncit_ndecrypt($vid));
		if (!$res)
			dberror("Cannot update database in verify.php");

		if (mysql_affected_rows() == 1){
			echo "Thank you - We have validated your e-mail verification and have provided you with full access to our site.";
		else
			echo "We are sorry - Your e-mail verification has failed. Please <a href='../help/support.php'><b>contact our support</b></a> with full details so we can correct the problem.";
	} 
} 

?>
</p>
<!-- * -->
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

