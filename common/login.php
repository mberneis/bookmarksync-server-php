<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#login.php
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

if (isset($_GET['logout']) && $_GET["logout"] != ""){

	setcookie("md5","",time()-3600);
	setcookie("email","",time()-3600);
	setcookie("pass","",time()-3600);
	setcookie("ID","",time()-3600);
	setcookie("name","",time()-3600);
	
	$_SESSION['ID'] = "";
	$_SESSION['email'] = "";
	$_SESSION['name'] = "";
	$_SESSION['pass'] = "";
	$_SESSION['partner_id'] = "";
	$_SESSION['partnerurl'] = "";
	$_SESSION['partnerlogo'] = "";
	$_SESSION['license'] = "";
	$ID = 0;
	$errmsg = "LOGGED OUT";
	$email = "";
	header("Location: ../default.php?logout=true");
} 

$GLOBALS['mainmenu'] = "LOG IN";
$GLOBALS['submenu'] = "";
$email = "";
$pass = "";
$errmsg = "";
$sendpassemail = "";

if (isset($_POST['email']))
	$email = trim(my_stripslashes($_POST['email']));
if (isset($_POST['pass']))
	$pass = trim(my_stripslashes($_POST['pass']));
if (isset($_POST['err']))
	$errmsg = my_stripslashes($_POST['err']);
if (isset($_POST['sendpass']))
	$sendpassemail = trim(my_stripslashes($_GET['sendpass']));

// get a db handle
if (!db_connect())
	die();

// here we go
if ($sendpassemail != ""){

	$subj = "Your SyncIT Password";
	$body = "You have requested that your SyncIT password be sent to you\r\n";

	$res = mysql_query("select pass from person where email='" . $sendpassemail . "'");
	if ($data = mysql_fetch_assoc($res))
		$body .= "Password: " . $data['pass'] . "\r\n";
	else
		$body .= "Your e-mail address could not be found.\r\nIf you have not registered yet please visit http://syncit.com/common/login.php\r\n";

	$errmsg="Your account information has been sent";
	$body .= "Your BookmarkSync Support Team\r\n";

	domail("mailer@syncit.com",$sendpassemail,$subj,$body);
} 

$refer = request("refer");

if ($refer != "" && $errmsg == "")
	$errmsg="RESTRICTED ACCESS";

if ($email != ""){

	$res = mysql_query("SELECT personid,name,email,pass,partner_id,token FROM person WHERE email='" . $email ."'");
	if (!$res)
		dberror("Unable to access user info");

	$data = mysql_fetch_assoc($res);
	if ($data['pass'] != $pass)
		$ID = 0;
	else
		$ID = $data['personid'];

	if ($refer == "" || stristr($refer,"/login.php"))
		$refer = "../tree/view.php";

	if ($ID > 0){
 		$_SESSION['ID'] = $ID;
		$_SESSION['name'] = $data['name'];
		$_SESSION['email'] = $data['email'];
		setcookie("email",$_SESSION['email'],time()+31536000,"/");
		if (isset($_POST['savepass']) && $_POST['savepass'] == "ON"){
			setcookie("name",$data['name'],time()+31536000,"/");
			setcookie("md5",MD5Pwd($data['email'],$data['pass']),time()+31536000,"/");
		} 
	
	    $_SESSION['partner_id'] = $data['partner_id'];
	    $_SESSION['token'] = intval($data['token']);
	    $_SESSION['license'] = 1;		//(isset($data['pc_license']) || isset($data['mac_license']) || isset($data['linux_license']));

	    header("Location: " . $refer);
	    exit();
	}

	else
		$errmsg = "INCORRECT LOGIN";
} 

if ($email == "" && isset($_COOKIE['email']))
	$email = $_COOKIE['email'];
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>SyncIT Login and Registration</title>
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>
<script language="JavaScript">
<!--
	function sendpass() {
		email = login_form.email.value;
		if (email.indexOf('.') == -1 || email.indexOf('@') == -1) {
			alert ("Please enter a valid E-mail address");
			login_form.email.focus();
		} else {
			location.href='login.php?sendpass=' + email;
		}
	}
//-->
</script>
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
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt="QuickSync News"><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt="SyncIT Express"></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/header_login_register.gif" width="503" height="37" alt="SyncIT Login &amp; Registration"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
<script language="JavaScript"><!--
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
<form method="POST" action="login.php" onsubmit="return validate_login(this)" name="login_form">
          <input type="hidden" name="refer" value="<? echo $refer; ?>">
              <table width="491" border="0" cellspacing="0" cellpadding="2">
                <tr>
                <td rowspan="4" width="173"><img src="../images/registerillustration.gif" width="159" height="127" alt="Secure Login"></td>
                <td colspan="2" width="318"><img src="../images/lbl_registeredusers.gif" width="318" height="37" vspace="4" alt="Registered Users"></td>
              </tr>
              <tr>
                <td width="133">
                  <h4>
<?php
if ($errmsg != "")
	echo "<font color='#FF0000'>" . $errmsg . "</font><br><br>";
?>
                  <b>Please log in <br>
                      with your <br>
                      E-mail address and password.</b>
                      </h4>
                </td>
                <td width="185" ><div class="menub">E-MAIL:</div><br>
                    <input type="text" name="email" class="login" size="15" maxlength="50" value="<? echo $email; ?>" onkeypress="if (event.which==13) {document.login_form.pass.focus()}">
                  <br>
                  <div class="menub">PASSWORD:</div><br>
                    <input type="password" name="pass" class="login" size="15" maxlength="50" onkeypress="if (event.which == 13) {document.login_form.submit()}">
                </td>
              </tr>
              <tr>
                <td width="133" class="f11">Check &quot;Save Password&quot; to
                  enable automatic <br>
                  log in for the future.</td>
                <td width="185" class="menub" valign="middle">
                    <input type="image" border="0" name="login_submit" src="../images/btnlogin.gif" width="53" height="16" align="absmiddle" alt="LOG IN">
                  <input type="checkbox" name="savepass" value="ON">
                  SAVE PASSWORD</td>
              </tr>
              <tr>
                <td width="133" class="f11"><b>Forgot the password?</b></td>
                <td width="185" class="f11" valign="middle">
                   <a href="javascript:sendpass()"><img border="0" src="../images/btn_sendpass.gif" width="102" height="16" alt="Send Password"></a><br>
                      Have it sent to the e-mail above.</td>
              </tr>
            </table>
	    </form>
            <p> <a name="register"> <img src="../images/lbl_registration.gif" width="491" height="35" alt="New Users Register Free">
            </a>
            </p>
            <p>Please register so we can reserve your personal database space.<br>
              <i><b>It is important that you enter your correct e-mail address.
              </b></i>We will send you a special URL to complete your registration.
              </p>
<script language="JavaScript"><!--
function validate_register(theForm)
{

  if (theForm.name.value == "")
  {
    alert("Please enter a value for the 'name' field.");
    theForm.name.focus();
    return (false);
  }

  if (theForm.name.value.length > 50)
  {
    alert("Please enter at most 50 characters in the 'name' field.");
    theForm.name.focus();
    return (false);
  }

  if (theForm.email.value == "")
  {
    alert("Please enter a value for the 'email' field.");
    theForm.email.focus();
    return (false);
  }

  if (theForm.email.value.length > 50)
  {
    alert("Please enter at most 50 characters in the 'email' field.");
    theForm.email.focus();
    return (false);
  }

  if (theForm.pass.value == "")
  {
    alert("Please enter a value for the 'pass' field.");
    theForm.pass.focus();
    return (false);
  }

  if (theForm.pass.value.length > 50)
  {
    alert("Please enter at most 50 characters in the 'pass' field.");
    theForm.pass.focus();
    return (false);
  }

  if (theForm.pass2.value == "")
  {
    alert("Please enter a value for the 'pass2' field.");
    theForm.pass2.focus();
    return (false);
  }

  if (theForm.pass2.value.length > 50)
  {
    alert("Please enter at most 50 characters in the 'pass2' field.");
    theForm.pass2.focus();
    return (false);
  }
  return (true);
}
//--></script>
<form method="POST" action="register.php" onsubmit="return validate_register(this)" name="register_form">
            <table width="491" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td width="173" align="right" class="menub">NICK NAME/ALIAS:&nbsp;
                  </td>
                <td width="318">
                    <input type="text" name="name" maxlength="50" class="register" size="30" onkeypress="if (event.which == 13) {document.register_form.email.focus()}">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">E-MAIL:&nbsp; </td>
                <td width="318">
                    <input type="text" name="email" maxlength="50" class="register" size="30" onkeypress="if (event.which == 13) {document.register_form.pass.focus()}">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">PASSWORD:&nbsp; </td>
                <td width="318">
                    <input type="password" name="pass" maxlength="50" class="register" size="30"  onkeypress="if (event.which == 13) {document.register_form.pass2.focus()}">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">RETYPE PASSWORD:&nbsp;
                  </td>
                <td width="318">
                    <input type="password" name="pass2" maxlength="50" class="register" size="30" onkeypress="if (event.which == 13) {document.register_form.submit()}">
                </td>
              </tr>
              
<tr><td></td><td width="318" align="right" valign="bottom"><input type="image" border="0" name="imageField2" src="../images/btnagree.gif" width="62" height="16" alt="I Agree">&nbsp;</td></tr>
</table>
<input type="hidden" name="url" value="../download/default.php">
<input type="hidden" name="partnerid" value="<? echo $_SESSION['partner_id']; ?>">
</form>
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

