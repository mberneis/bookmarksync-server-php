<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#removeuser.php
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


$GLOBALS['mainmenu'] = "PROFILE";
$GLOBALS['submenu'] = "REMOVE ME";

$reason = "";
$popup = false;
$udeleted = 0;
$email = "";
if (isset($_POST['email']))
	$email = trim($_POST["email"]);

if ($email == "")
	$email = trim($_COOKIE["email"]);

else {
	$reason = trim($_POST["reason"]);
	if ($_POST["doit"] == "ON"){
		$res = mysql_query("select personid,name,pass,pc_license,mac_license,linux_license from person where email = '" . str_replace("'","''",$email) . "'");
		if (!$res)
			dberror("Cannot retrieve data in removeuser.php");

		if (!$data = mysql_fetch_assoc($res))
			$udeleted = 1;
		else if (request("license") == "" && (!($data["pc_license"] == "" && $data["mac_license"] == "" && $data["linux_license"] == ""))){
			$_SESSION['license'] = true;
			$udeleted = 3;
		}
		else if ($_POST["pass"] != $data["pass"])
			$udeleted = 1;
		else {


			$ID = $data["personid"];
			$name = $data["name"];
			$res1 = mysql_query("select publishid from publish where user_id=" . $ID);
			if (!$res1)
				dberror("Cannot retrieve data 2 in removeuser.php");

			while ($data1 = mysql_fetch_assoc($res1))
				mysql_query("delete from fmessages where forum_id = " . $data1["publishid"]);

			$res2 = mysql_query("select person_id from link where expiration is null and person_id=" . $ID);
			$count = mysql_num_rows($res2);
			mysql_free_result($res2);

			// do the remove user sp
			$reason = str_replace("'","''",$reason);
			mysql_query("insert into removed (name,email,bookmarks,reason,registered,removed,lastchanged,token,id) select name,email," . $count . ",'" . $reason . "',registered,now(),lastchanged,token,personid from person where personid=" . $ID);
			mysql_query("delete from subscriptions where person_id=" . $ID);
			mysql_query("delete from publish where user_id=" . $ID);
			mysql_query("delete from person where personid=" . $ID);
 
			$ID = "";
			setcookie("email","");
			setcookie("MD5","");
			$_SESSION['ID'] = "";

			domail("support@bookmarksync.com",$email,"BookmarkSync account removed",$name . ",\r\nYour BookmarkSync user account <" . $email . "> has been removed at " . strftime("%D %T") . "\r\n");
			if ($reason != "")
				domail($email,"removed@bookmarksync.com","Removed user: " . $name,$reason);
			$udeleted=2;
		}
	}

	else
		$popup = true;
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>Remove User</title>
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
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_remove.gif" width="503" height="37" alt="SyncIT Remove User"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
<?php
if ($udeleted == 2){
	echo " <br><h2>Goodbye !</h2>";
	echo "You have removed your profile and all your bookmarks from our database.";
}
else {
	echo " <br><h2>Remove User</h2>";
	if ($udeleted == 1)
		echo "<p><b><font color='#FF0000'>Wrong e-mail/password combination !</font></b></p>";
	if ($udeleted == 3)
		echo "<p><b><font color='#FF0000'>You have a payed SyncIT license.<br>If you remove yourself your license will forfeit</font></b></p>";
?>
	<h4>Please re-enter your e-mail address and password to confirm your cancellation.</h4>
	<p>Once you remove yourself all your bookmarks on our server will be removed...
	and there is no way of getting them back!</p>
	<p><b>Note: You do not have to remove yourself from the database if you just want to
	reinstall a new client. - <a href="../download/default.php">Download here</a>.</b></p>
	<h4>Your local bookmarks and favorites will not be affected.</h4>
	<script language="JavaScript"><!--
	function validate(theForm)
	{
	
	  if (theForm.email.value == "")
	  {
	    alert("Please enter a value for the 'E-mail Address' field.");
	    theForm.email.focus();
	    return (false);
	  }
	
	  if (theForm.pass.value == "")
	  {
	    alert("Please enter a value for the 'Password' field.");
	    theForm.pass.focus();
	    return (false);
	  }
	  return (true);
	}
	//--></script>
	<form method="POST" action="removeuser.php" onsubmit="return validate(this)">
           <table border="0" width="485">
            <tr>
              <td width="50%" align="right" class="menub">E-mail:</td>
              <td width="50%" colspan="2"><input type="text" name="email" size="20" class="register" value="<?   echo $email; ?>"></td>
            </tr>
            <tr>
              <td width="50%" align="right" class="menub">Password:</td>
              <td width="50%" colspan="2"><input type="password" name="pass" size="20" class="register"></td>
            </tr>
            <tr>
              <td width="50%" align="right" class="menub">Could you please tell us the reason
                for leaving so we can improve it for future members?</td>
              <td width="50%" colspan="2"><textarea rows="6" name="reason" cols="20" class="register"><?   echo $reason; ?></textarea></td>
            </tr>
<?php
	if ($_SESSION['license'] == true){
?>
		<tr>
		<td align="right" class="menub"><font color='red'>I forfeit my license(s):</a></td>
		<td><input type="checkbox" name="license" value="<?     echo $license_session; ?>"></td>
		<td></td>
		</tr>          
<?php
	}
?>
	<tr>
	<td width="50%" align="right" class="menub">I really want to do this:</td>
	<td width="25%"><input type="checkbox" name="doit" value="ON"></td>
	<td width="25%" align="right"><input border="0" src="../images/btn_remove.gif" name="I2" type="image" width="62" height="16" alt="Remove"></td>
	</tr>
	</table>
	</form>
<?php
}
?>
</td>
<td width="10" valign="top">&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
<?php
if ($popup){
	echo "<script>\r\n<!--\r\n";
	echo "alert('You must check \"I REALLY WANT TO DO THIS\" to remove yourself');\r\n";
	echo "//-->\r\n</script>";
}
?>
</html>

