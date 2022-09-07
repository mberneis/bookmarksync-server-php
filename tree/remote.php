<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#remote.php
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<?php include '../inc/tree.php'; ?>
<html>
<head>
<title>SyncIT Remote</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
<?php
$target = $_SESSION['target'];
if (request("target") != ""){
	$target = request("target");
	$_SESSION['target'] = $target;
}

if ($target == ""){
  $target = "_main";
  $_SESSION['target'] = $target;
}

//echo "<base target='" . $target . "'>";
?>
</head>
<body bgcolor="#FFFFFF">
<?php

if (!db_connect())
	die();

$pubid = "";
$email = "";
$XID = "";
$ID = "";

if (isset($_POST['pubid']))
	$pubid = $_POST["pubid"];
if (isset($_POST['XID']))
	$ID = syncit_ndecrypt($_POST["XID"]);

if ($ID == 0)
	$ID = intval($_SESSION['RID']);
if ($ID == 0)
	$ID = $_SESSION['ID'];

if (isset($_POST['email']))
	$email = $_POST["email"];

if ($ID == 0 || $email != ""){
	$pass = $_POST["pass"];
	$_SESSION['ID'] = 0;
	$_SESSION['RID'] = 0;

	if ($email != ""){
		$res = mysql_query("select personid,pass from person where email='" . strip($email) . "'");
		if (!$res)
			dberror("Cannot retrieve person data in remote.php");
		if ($data = mysql_fetch_assoc($res)){
			if ($pass == $data["pass"])
				$_SESSION['RID'] = $data["personid"];
			else
				echo "<font color=#FF0000><b>Invalid email or password</b></font><hr size=1>";
		}
		else
			echo "<font color=#FF0000><b>Invalid email or password</b></font><hr size=1>";
	}
	else {
		$email = $_COOKIE["email"];
	}
	$ID = $_SESSION['RID'];
}
else
	$_SESSION['RID'] = $ID;

if ($ID != 0){
	$res = mysql_query("select name, email from person where personid = " . $ID);
	if (!$res)
		dberror("Cannot retrieve data 3 in remote.php");
	if (mysql_num_rows($res) > 0)
		$_SESSION['RID'] = $ID;
} 

if ($ID == 0 || request("logout") != ""){
?>
	<table>
	<tr align="center">
	<td><a href="/"><img border=0 src="../images/logo1.gif" width="112" height="52" alt="SyncIT.com"></a></td>
	</tr>
	</table>
	<form method="POST" action="remote.php" target="_self">
	<span class="menub">E-MAIL:</span><br>
	<input type="text" name="email" class="login" size="12" maxlength="50" value="<?php echo $email; ?>">
	<br>
	<span class="menub">PASSWORD:</span><br>
	<input type="password" name="pass" class="login" size="12" maxlength="50">
	<p><input border="0" src="../images/btnlogin.gif" name="I1" type="image" width="53" height="16" alt="Login"></p>
	</form>
<?php
}
else {
?>
	<form method="POST" action="remote.php" name="frmsel" target="_self">
	<table>
	<tr align="center">
	<td><a target="_top" href="/"><img src="../images/logo1.gif" width="112" height="52" border="0" alt="SyncIT.com"></a></td> 
	<td><a href="remote.php?logout=true" target="_top" class="menub">CHANGE USER</a><br>
<?php
	if ($target!="_main"){
?>
		<script language=javascript>
		<!--
		if (parent.location.href != window.location.href) {
		document.write ('<a href="../bms/default.php" target="_top" class="menub">CLOSE WINDOW</a>');
		} else {
		document.write ('<a href="javascript:window.close();" target="_top" class="menub">CLOSE WINDOW</a>');   		
		}
		//-->
		</script>
<?php
	}
?>
	</td>
	</tr>
	</table>
	<br>
	<input type=hidden name="XID" value="<?   echo $syncit_ncrypt[$ID]; ?>">
	<select size="1" class="f11" name="pubid" onChange="document.frmsel.submit();">
<?php
	echo "<option value=0";
	if (syncit_ndecrypt($pubid) == 0)
		echo " selected";

	echo ">My Bookmarks</option>";
	$res = mysql_query("select publish.publishid,publish.title from subscriptions,publish where publish.publishid = subscriptions.publish_id and subscriptions.person_id=" . $ID);
	if (!$res)
		dberror("Cannot retrieve data 4 in remote.php");

	while($data = mysql_fetch_assoc($res)){
		echo "<option";
		$pid = syncit_ncrypt($data["publishid"]);
		if ($pid == $pubid)
			echo " selected";
		echo " value='" . $pid . "'>" . $rs["title"] . "</option>\r\n";
	}

	echo "</select><br></form><nobr>\r\n";
	tree($pubid,false);
}
?>
</body>
