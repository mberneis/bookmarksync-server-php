<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#register.php
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


$GLOBALS['mainmenu'] = "LOG IN";
$GLOBALS['submenu'] = "REGISTER";

$url = $_POST['url'];
$refer = "&refer=" . $url;

$email = trim($_POST['email']);

if (!db_connect())
	die();

if (!isset($_POST['RID']) || $_POST['RID'] == ""){

	$name = trim($_POST['name']);
	$pass = trim($_POST['pass']);
	if ($email == "")
		myredirect ("../common/login.php?err=No+e-mail+address" . $refer);
	if ($name == "")
		myredirect("../common/login.php?err=No+user+name" . $refer);
	if ($pass == "")
		myredirect("../common/login.php?err=No+password" . $refer);
	if ($pass != trim($_POST['pass2']))
		myredirect("../common/login.php?err=passwords+do+not+match" . $refer);
	if (!is_email_valid($email))
		myredirect("../common/login.php?err=Invalid+e-mail+address" . $refer);

	$res = mysql_query("select personid from person where email='" . $email . "'");
	if (!$res)
		dberror("Cannot access database!");
	
	if (mysql_num_rows($res) > 0)
		myredirect("../common/login.php?err=E-Mail+address+already+registered." . $refer);

	mysql_query("insert into person (name,email,pass,age,gender,registered,token) values ('" . strip($name) . "','" . strip($email) . "','" . strip($pass) . "',-1,'U',now(),0)");
	$res = mysql_query("select personid from person where email='" . strip($email) . "'");
	if (!$res)
		dberror("Register insert failed!");
	$data = mysql_fetch_assoc($res);
	$ID = $data['personid'];
	$_SESSION['email'] = $email;
	$_SESSION['ID'] = $ID;
	$_SESSION['name'] = $name;
	setcookie("email",$email);

	$partner_id = $_SESSION['partner_id'];
	$partner_pub = $_SESSION['partnerpub'];
	if (intval($partner_id) > 0){
		mysql_query("update person set partner_id=" . $partner_id . " where personid=" . $ID);
		//Check for default publication
		if ($partner_pub != "")
			mysql_query("insert into subscriptions (person_id,publish_id,created) values(" . $ID . "," . $partner_pub . ",now())");
	} 


	//Preloaded subscriptions...
	mysql_query("insert into subscriptions (person_id,publish_id,created) select " . $ID . ",publishid,now() from publish,person where email='support@bookmarksync.com' and personid=user_id");

	$i = strpos($url,"addid=");
	if ($i > 0){
	    $pid = syncit_ndecrypt(substr($url,strlen($url)-(strlen($url)-$i-5)));
	    mysql_query("insert into subscriptions (person_id,publish_id,created) values (" . $ID . "," . $pid . ",now())");
	    $url = "";
	} 

	domail("mailer@syncit.com",$email,"Welcome to BookmarkSync",welcometxt($name,syncit_ncrypt($ID)));

}

else {
	$ID = $_POST['RID'];

	restricted("../common/profile.php");
	$ID =$_SESSION['ID'];
	$address1 = strip($_POST['address1']);
	$address2 = strip($_POST['address2']);
	$city = strip($_POST['city']);
	$state = strip($_POST['state']);
	$zip = strip($_POST['zip']);
	$country = strip($_POST['country']);
	$wherefrom = strip($_POST['wherefrom']);
	$phone = strip($_POST['phone']);
	$fax = strip($_POST['fax']);
	$gender =  $_POST['gender'];
	$age = $_POST['age'];
	$description = strip($_POST['description']);

	$sql="update person set ";

	if ($email != $_SESSION['email'])
		$sql .= "lastverified=NULL,";

	if (!isset($_POST['optin']) || $_POST['optin'] == "")
		$optin=0;
	else
		$optin=1;

	$sql .= "optin=" . $optin . ",";
	$sql .= "address1='" . $address1 . "',";
	$sql .= "address2='" . $address2 . "',";
	$sql .= "city='" . $city . "',";
	$sql .= "state='" . $state . "',";
	$sql .= "zip='" . $zip . "',";
	$sql .= "country='" . $country . "',";
	$sql .= "phone ='" . $phone . "',";
	$sql .= "fax ='" . $fax . "',";
	$sql .= "gender ='" . $gender . "',";
	$sql .= "age ='" . $age . "',";
	$sql .= "wherefrom ='" . $wherefrom . "',";
	$sql .= "description='" . $description . "' ";
	$sql .= "where personid = ". $ID;

	mysql_query($sql);

	if ($email != $_SESSION['email'])
		domail("mailer@syncit.com",$email,"Welcome back to BookmarkSync",welcometxt(name,syncit_ncrypt($ID)));

	if ($url == "")
		$url = "../download/default.php";

	myredirect($url);
} 


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>SyncIT Login and Registration</title>
<link rel="StyleSheet" href="syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#660066" vlink="#990000" alink="#CC0099">
<!-- #include file = "../inc/header.inc" -->
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
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_registration.gif" width="503" height="37" alt="SyncIT Registration"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br> <img src="../images/lbl_registration.gif" width="491" height="35" alt="New Users Register Free">

            <p>Although the following information is not required we would
            appreciate it if you could give us a little bit more information
            about yourself.<br>
            <i><b>It is important that you enter your correct e-mail address.
              </b></i>We will send you a special URL to complete your registration.
              </p>
<script language="JavaScript"><!--
function validate(theForm)
{

  if (theForm.email.value == "")
  {
    alert("Please enter a value for the 'email' field.");
    theForm.email.focus();
    return (false);
  }

  if (theForm.email.value.length > 50)
  {
    alert("Please enter at most 50 characters in the 'E-mail' field.");
    theForm.email.focus();
    return (false);
  }
  return (true);
}
//--></script>
<form method="POST" action="register.php" onsubmit="return validate(this)">
		<input type="hidden" name="RID" value="<? echo $ID; ?>">
            <table width="491" border="0" cellspacing="0" cellpadding="0">
              <tr>
                  <td width="173" align="right" class="menub">E-Mail:
                  </td>
                <td width="318">
                    <input type="text" name="email" maxlength="50" class="register" size="33" values="<? echo $email; ?>" value="<? echo $email; ?>">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">Address:&nbsp; </td>
                <td width="318">
                    <input type="text" name="address1" class="register" size="33">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">Address:&nbsp; </td>
                <td width="318">
                    <input type="text" name="address2" maxlength="50" class="register" size="25">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">City:&nbsp; </td>
                <td width="318">
                    <input type="text" name="city" maxlength="50" class="register" size="25">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">State:&nbsp; </td>
                <td width="318">
                    <input type="text" name="state" maxlength="20" class="register" size="25">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">Postal Code:&nbsp; </td>
                <td width="318">
                    <input type="text" name="zip" maxlength="10" class="register" size="25">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">Country </td>
                <td width="318">
                    <input type="text" name="country" maxlength="30" class="register" size="25">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">Phone: </td>
                <td width="318">
                    <input type="text" name="phone" maxlength="50" class="register" size="25">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">Fax: </td>
                <td width="318">
                    <input type="text" name="fax" maxlength="50" class="register" size="25">
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">Age: </td>
                <td width="318">
                  <select name="age" size="1" class="register">
                    <option value="10">13-18</option>
                    <option value="20">19-25</option>
                    <option value="30">26-35</option>
                    <option value="40">36-49</option>
                    <option value="50">50-59</option>
                    <option value="60">60-69</option>
                    <option value="70">70 and over</option>
                    <option selected value="-1">Not specified</option>
                  </select>
                </td>
              </tr>
			 <tr>
                    <td colspan=2 class="menub"> 
                      <div align="right"><font color="#CC0000">IF YOU ARE UNDER 
                        13 PLEASE LET A PARENT OR GUARDIAN SIGN IN!</font></div>
                    </td>
                  </tr>
              <tr>
                  <td width="173" align="right" class="menub">Gender: </td>
                <td width="318">
                    <select name="gender" size="1" class="register">
                    <option value="F">Female</option>
                    <option value="M">Male</option>
                    <option selected value="U">Not specified</option>
                  </select>
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">Where did
                    you&nbsp;<br>
                    hear about us: </td>
                <td width="318">
                    <textarea name="wherefrom" rows="3" class="register" cols="32"></textarea>
                </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub">What are&nbsp;<br>
                    your interests:&nbsp; </td>
                <td width="318">
                    <textarea name="description" rows="3" class="register" cols="32"></textarea>
                </td>
              </tr>
              <tr>
                  <td width="491" align="right" class="menub" colspan="2">
                  <img border="0" src="../images/psep.gif" width="491" height="10" alt="">
                  </td>
              </tr>
              <tr>
                  <td width="173" align="right" class="menub" valign="top"></td>
                <td width="318" rowspan="2" class="menub">
                &nbsp; &lt;- Press OK to continue...
                </td>
              </tr>
              <tr>
                <td width="173" align="right" valign="bottom">
                    <input type="image" border="0" name="imageField2" src="../images/btnok.gif" width="62" height="16" alt="OK">
                    &nbsp; </td>
              </tr>
            </table>
            <input type="hidden" name="url" value="<? echo $url; ?>">
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

