<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#BandLogin.php
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

<?
  session_name("syncitmain");
	session_start();
  session_register("ID_session");
  session_register("email_session");
  session_register("pass_session");
  session_register("partner_id_session");
  session_register("partnerurl_session");
  session_register("partnerlogo_session");
  session_register("name_session");
?>
<? // asp2php (vbscript) converted
?>
<!-- #include file = "../inc/asp.inc" -->
<!-- #include file = "../inc/db.inc" -->
<!-- #include file = "../inc/mail.inc" -->
<? 

if ($HTTP_GET_VARS["logout"]!="")
{

  setcookie("md5""",0,"","",0);
  setcookie("email""",0,"","",0);
  setcookie("pass""",0,"","",0);
  setcookie("ID""",0,"","",0);
  // Unsupported: Response.Cookie. Expires = Date - 1000
  // Unsupported: Response.Cookie. Expires = Date - 1000
  // Unsupported: Response.Cookie. Expires = Date - 1000
  // Unsupported: Response.Cookie. Expires = Date - 1000

  $ID_session="";
  $email_session="";
  $pass_session="";
  $partner_id_session="";
  $partnerurl_session="";
  $partnerlogo_session="";
  $ID=0;
  $errmsg="LOGGED OUT";
  $email="";
} 


$md5=$HTTP_COOKIE_VARS["md5"];
$mainmenu="LOG IN";
$submenu="";
$email=$HTTP_POST_VARS["email"];
$pass=$HTTP_POST_VARS["pass"];
$errmsg=$HTTP_GET_VARS["err"];
$sendpassemail=$HTTP_GET_VARS["sendpass"];
if ($sendpassemail!="")
{



  $Subj="Your SyncIT Password";
  $body="You have requested that your SyncIT password be sent to you"."\r\n";
  $sql="SELECT pass FROM person WHERE email='".$sendpassemail."'";
  $on$error$resume$next;
$conn  $execute[$sql];
  if ($err)
  {
    $dberror$err.$description." [".$err.$number."]";
  } 
  $on$error$goto0;
  if ($rs$eof)
  {

    $body=$body."Your e-mail address could not be found"."\r\n";
    $body=$body."If you have not registered yet please visit http://syncit.com/common/login.php"."\r\n";
  }
    else
  {

    $body=$body."Password: ".$rs["pass"]."\r\n";
  } 


  $rs.$close;
  $errmsg="Your account information has been sent";
  $body=$body."Your BookmarkSync Support Team"."\r\n";

  $domail"support@bookmarksync.com"  $sendpassemail  $subj  $body;
} 


$url=$HTTP_GET_VARS["refer"];
if ($url!="" && $errmsg=="")
{
  $errmsg="RESTRICTED ACCESS";
} 

if ($email!="")
{

  $on$error$resume$next;
$conn  $execute["SELECT personid, name, email, pass,partner_id FROM person WHERE email = '".$strip[$email]."'"];
  if ($err)
  {
    $dberror$err.$description." [".$err.$number."]";
  } 
  $on$error$goto0;
  if ($rs$eof)
  {

    $ID=0;
  }
    else
  if ($rs["pass"]!=$pass)
  {

    $ID=0;
  }
    else
  {

    $ID=$rs["personid"];
  } 


  if ($ID>0)
  {

    $ID_session=$ID;
    $name_session=$rs["name"];
    $email_session=$rs["email"];
    setcookie("email"$email,0,"","",0);
    if ($HTTP_POST_VARS["savepass"]=="ON")
    {

// $md5 is of type "FishX.MD5"

      $md5.$init;
      $md5.$Update["syncit.com"]; // site-specific salt
$md5.$Update[$email];
      $md5.$Update[$rs["pass"]];
      // Unsupported: Response.Cookie. Expires = Date + 365
      setcookie("md5"$md5.$Final,0,"","",0);
      // Unsupported: Response.Cookie. Expires = Date + 365
//response.write "Saved pass = " & md5.Final
      $md5=null;

    } 

    $partner_id_session=$rs["partner_id"];
    $rs.$close;
    $conn.$close;
    $conn=null;

    header("Location: ".$HTTP_POST_VARS["url"]);
    flush();

    exit();

  }
    else
  {

    $errmsg="INCORRECT LOGIN";
  } 

} 

if ($email=="")
{
  $email=$HTTP_COOKIE_VARS["email"];
} 
if ($url=="")
{
  $url="../bms/default.php";
} ?>
<HTML>
<HEAD>
<title>BookmarkSync WebBand</title>
</HEAD>
<BODY>
<script language="JavaScript">
<!--
function sendpass() {
	email = band_login.email.value;
	if (email.indexOf('.') == -1 || email.indexOf('@') == -1) {
		alert ("Please enter a valid E-mail address");
		band_login.email.focus();
	} else {
		location.href='login.php?sendpass=' + email;
	}
}
	
function validate_login(theForm)
{

  if (theForm.email.value == "") {
    alert("Please enter a value for the 'e-mail' field.");
    theForm.email.focus();
    return (false);
  }

  if (theForm.email.value.length > 50) {
    alert("Please enter at most 50 characters in the 'e-mail' field.");
    theForm.email.focus();
    return (false);
  }

  if (theForm.pass.value.length > 50) {
    alert("Please enter at most 50 characters in the 'pass' field.");
    theForm.pass.focus();
    return (false);
  }
  return (true);
}
//-->
</script>
<table border="0" cellpadding="0" cellspacing="0" width="120">
	<tr>
		<td width="120">
			<img src="../images/logo1.gif" width="113" height="52">
		</td>
	</tr>
	<tr>
		<td width="120">
			<form action="BandLogin.php" method="Post" name="band_login" onSubmit="validate_login(this)">
			<input type="hidden" name="url" value="<? echo $url; ?>">
			Please enter your email address and password below<br>
			Email:<br>
			<input type="text" name="email" class="login" size="15" maxlength="50" value="<? echo $email; ?>" onkeypress="if (event.which==13) {document.login_form.pass.focus()}"><br>
			Password:<br>
			<input type="password" name="pass" class="login" size="15" maxlength="50" onkeypress="if (event.which == 13) {document.login_form.submit()}"><br>
			Would you like to save your password to enable automatic login in the future? <input type=checkbox name="savepass" value="ON" checked> Yes!<br>
			If you forgot your password, please	enter your email address and <a href="javascript:sendpass()">Click Here.</a> Your password will be sent to the email address typed above.
			</td></tr></table>
</BODY>
</HTML>

