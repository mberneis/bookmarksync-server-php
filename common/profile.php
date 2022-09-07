<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#profile.php
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
header("Expires: -1");
include '../inc/db.php';
include '../inc/mail.php';
include '../inc/welcome.php';

restricted("../common/profile.php");

$mainmenu="PROFILE";
$submenu="";

if (!db_connect())
	die();

$ID = $_SESSION['ID'];
$errmsg = "";
$email = "";
$pass = "";
$name = "";
$address1 = "";
$address2 = "";
$city = "";
$state = "";
$zip = "";
$country = "";
$phone = "";
$fax = "";
$gender = "";
$age = "";
$description = "";
$mymsg = "";

if (isset($_POST["email"]) && $_POST['email'] != ""){

	$pass = strip($_POST["pass"]);
	if ($pass != ""){
	    if ($pass != strip($_POST["pass2"]))
			$errmsg="Passwords do not match.";
	} 

	if ($errmsg == ""){
		$email = strip($_POST["email"]);
		$name = strip($_POST["name"]);
		if ($name == "" || $email == "")
			$errmsg = "Name and E-mail are required fields";
	}

	if ($errmsg == ""){
		if ($email != $_SESSION['email']){
			$res = mysql_query("select personid from person where email='" . $email . "'");
			if (mysql_num_rows($res) > 0){
				$errmsg = "New e-mail address &lt;<i>" . $email . "</i>&gt; exists already!";
				$email = $_SESSION['email'];
			}
		}
	} 


	if ($errmsg == ""){
	
		$address1 = strip($_POST['address1']);
		$address2 = strip($_POST['address2']);
		$city = strip($_POST['city']);
		$state = strip($_POST['state']);
		$zip = strip($_POST['zip']);
		$country = strip($_POST['country']);
		$phone = strip($_POST['phone']);
		$fax = strip($_POST['fax']);
		$gender = $_POST['gender'];
		$age = $_POST['age'];
		$description = strip($_POST['description']);
	
		$sql = "UPDATE person SET ";
	
		if ($pass != "")
			$sql .= "pass='" . $pass . "',";
	
	    if ($email != $_SESSION['email'])
			$sql .= "lastverified=NULL,";
	
	    if (!isset($_POST['optin']) || $_POST['optin'] == "")
			$optin=0;
		else
			$optin=1;
	
		$sql .= "optin=".$optin.",";
		$sql .= "email='".$email."',";
		$sql .= "name='".$name."',";
		$sql .= "address1='".$address1."',";
		$sql .= "address2='".$address2."',";
		$sql .= "city='".$city."',";
		$sql .= "state='".$state."',";
		$sql .= "zip='".$zip."',";
		$sql .= "country='".$country."',";
		$sql .= "phone ='".$phone."',";
		$sql .= "fax ='".$fax."',";
		$sql .= "gender ='".$gender."',";
		$sql .= "age ='".$age."',";
		$sql .= "description='".$description."' ";
		$sql .= "where personid = ".$ID;
	
		mysql_query($sql);
	
		$_SESSION['name'] = $name;
		if ($email != $_SESSION['email']){
			setcookie("email",$email);
			$_SESSION['email'] = $email;
			mysql_query("update person set lastverified = NULL where personid=".$ID);
		}

		$mymsg = "is modified";
	}
} 


$res = mysql_query("select name,address1,address2,city,state,zip,phone,fax,email,description,wherefrom,pass,country,age,gender,optin from person where personid = ".$ID);
if (!$res)
	dberror("Cannot retrieve person info");

$data = mysql_fetch_assoc($res);

$name = $data["name"];
$address1 = $data["address1"];
$address2 = $data["address2"];
$city = $data["city"];
$state = $data["state"];
$zip = $data["zip"];
$phone = $data["phone"];
$fax = $data["fax"];
$email = $data["email"];
$description = $data["description"];
$wherefrom = $data["wherefrom"];
$pass = $data["pass"];
$country = $data["country"];
$age = $data["age"];
$gender = $data["gender"];
$optin = $data["optin"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>SyncIt Profile</title>
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
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_profile.gif" width="503" height="37" alt="SyncIT Profile"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br><h2>Your Profile <font color="#FF0000"><? echo $mymsg; ?></font></h2>
            <p><font color="#FF0000"><b><? echo $errmsg; ?></b></font></p>
<script language="JavaScript"><!--
function validate(theForm)
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

  if (theForm.zip.value.length > 10)
  {
    alert("Please enter at most 10 characters in the 'zip' field.");
    theForm.zip.focus();
    return (false);
  }
  return (true);
}
//--></script>
<form method="POST" action="profile.php" onsubmit="return validate(this)">
  <table border="0" width="100%">
    <tr>
      <td class="menub" align="right">Name</td>
      <td><input type="text" name="name" size="33" class="register" maxlength="50" value="<? echo $name; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">E-mail</td>
      <td><input type="text" name="email" size="33" class="register" maxlength="50" value="<? echo $email; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">Address</td>
      <td><input type="text" name="address1" size="33" class="register" maxlength="50" value="<? echo $address1; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">Address</td>
      <td><input type="text" name="address2" size="33" class="register" maxlength="50" value="<? echo $address2; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">City</td>
      <td><input type="text" name="city" size="33" class="register" maxlength="50" value="<? echo $city; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">State</td>
      <td><input type="text" name="state" size="33" class="register" maxlength="20" value="<? echo $state; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">Postal Code</td>
      <td><input type="text" name="zip" size="33" class="register" maxlength="10" value="<? echo $zip; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">Country</td>
      <td><input type="text" name="country" size="33" class="register" maxlength="30" value="<? echo $country; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">Phone</td>
      <td><input type="text" name="phone" size="33" class="register" maxlength="50" value="<? echo $phone; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">Fax</td>
      <td><input type="text" name="fax" size="33" class="register" maxlength="50" value="<? echo $fax; ?>"></td>
    </tr>
    <tr>
      <td class="menub" align="right">Gender</td>
      <td><select size="1" name="gender" class="register">
		<option value="U" <? if ($gender=="U")
{
print "selected";} ?>>Not specified</option>
       <option value="F" <? if ($gender=="F")
{
print "selected";} ?>>Female</option>
       <option value="M" <? if ($gender=="M")
{
print "selected";} ?>>Male</option>
	</select>
    </tr>
    <tr>
      <td class="menub" align="right">Age Group</td>
      <td><select size="1" name="age" class="register">
		<option value="10" <? if ($age=="10")
{
print "selected";} ?>>13-18</option>
       <option value="20" <? if ($age=="20")
{
print "selected";} ?>>19-25</option>
       <option value="30" <? if ($age=="30")
{
print "selected";} ?>>26-35</option>
       <option value="40" <? if ($age=="40")
{
print "selected";} ?>>36-49</option>
       <option value="50" <? if ($age=="50")
{
print "selected";} ?>>50-59</option>
       <option value="60" <? if ($age=="60")
{
print "selected";} ?>>60-69</option>
       <option value="70" <? if ($age=="70")
{
print "selected";} ?>>70 and over</option>
        </select></td>
    </tr>
    <tr>
      <td class="menub" align="right">About You</td>
      <td><textarea rows="4" name="description" cols="32" class="register"><? echo $description; ?></textarea></td>
    </tr>
    <tr>
      <td class="menub" align="right">New Password</td>
      <td><input type="password" name="pass" size="33" class="register" maxlength="50"></td>
    </tr>
    <tr>
      <td class="menub" align="right">Confirm<br>
        Password</td>
      <td><input type="password" name="pass2" size="33" class="register" maxlength="50"></td>
    </tr>
</table>
<p><input border="0" src="../images/btnmodify.gif" name="modify" value="modify" type="image" width="62" height="16" alt="Modify"></p>
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

