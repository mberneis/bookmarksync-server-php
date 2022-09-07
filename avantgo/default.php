<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#default.php
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
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
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
//	Description: Server code the syncit client communicates with 
//	for Bookmark synchronization
//	
//	Author:      Michael Berneis, Terence Way, Lauren Roberts
//	Created:     July 1998
//	Modified:    9/22/2003 by Michael Berneis
//	E-mail:      mailto:opensource@syncit.com
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
include '../inc/asp.php';
include '../inc/db.php';

$aid = "";
$msg = "";
$uid = "";
$bmcnt = 0;
$lastchanged = "";
$name = "";
$msg = "";
$aid = "";
$license = "";
$email = "";
$pass = "";
$dolist = false;
$errmsg = "";

if (isset($_GET["logoff"]) && $_GET['logoff'] != ""){
	setcookie("popup","");
	setcookie("avantgoid","");
	$uid = "";
	header ("location: default.php");
}

if (isset($_POST['email']))
	$email = $_POST["email"];
if (isset($_POST['pass']))
	$pass = $_POST["pass"];

if (!db_connect())
	die();

if ($email != "" && $pass != ""){

	$res = mysql_query("select personid,name from person where email='" . $email . "' and pass='" . $pass . "'");
	if (!$res || mysql_num_rows($res) == 0){
		$errmsg = "<hr>Invalid email/password combination<hr>";
		setcookie("avantgoid","");
	}

	else {
		$data = mysql_fetch_assoc($res);
		$uid = $data["personid"];
		setcookie("avantgoid",$uid);
		setcookie("email",$email);
	} 
	
	$dolist = (isset($_POST['dolist']) && $_POST["dolist"] <> "");
	if ($dolist)
		setcookie("avantgolist",$dolist);
	else
		setcookie("avantgolist","");
} 


if (isset($_COOKIE['msg']))
	$msg = $_COOKIE["msg"];
setcookie("msg","");

if (isset($_COOKIE['initid']))
	$aid = $_COOKIE["initid"];

if ($aid != ""){
	setcookie("initid","");
	$uid = syncit_ndecrypt($aid);
	setcookie("avantgoid",$uid);
}

if ($uid == "" && isset($_GET['uid']))
	$uid = $_GET["uid"];

if ($uid != "")
	setcookie("avantgoid",$uid);

if (strlen($uid) == 0 && isset($_COOKIE['avantgoid']))
	$uid = $_COOKIE["avantgoid"];

if (isset($_COOKIE['avantgolist']))
	$dolist = ($HTTP_COOKIE_VARS["avantgolist"] != "");

if (intval($uid) > 0){
	$res = mysql_query("select token from person where personid=" . $uid);
	$data = mysql_fetch_assoc($res);
    $license = 1;
} 

if ($uid == ""){
	if ($errmsg != ""){
		setcookie("avantgoid","");
	}
	setcookie("popup","done");
}

?>
<html>
<head>
<title>BookmarkSync - My Bookmarks</title>
<META name="HandheldFriendly" content="true"> 
</head>
<body bgcolor=#FFFFFF>
&nbsp;<br><center><img src="smalllogo.gif" width="56" height="26"></center>
<?php
if ($uid == ""){
	if ($errmsg != ""){
		echo $errmsg;
		$uid = "";
	}
?> 
	<form method="post" action="default.php">
	<b>Please enter your account info</b><br>
	E-mail: <input type="text" name="email" size=18 maxlength=64 value="<?php if (isset($_COOKIE['email'])) echo $_COOKIE["email"]; ?>">
	<br>
	Password: <input type="password" name="pass" size=18 maxlength=64>
	<br>
	Download Bookmarks? <input type="checkbox" name="dolist" value="listall"> [<a href="help.htm">Explain</a>]<br>
	<input type="submit" name="Submit" value="Log in" onClick="document.forms[0].submitNoResponse('Please synchronize now for full access to BookmarkSync',true,false)">  
	</form>
<?php
}
else {
	if ($msg != "")
		echo "<hr>" . $msg;

	echo "<hr>";

	$bmcnt = count_bookmarks($uid);
	if ($bmcnt == -1)
		dberror("Cannot retrieve data 1 in avantgo/default.php");

	$res = mysql_query("select name,date_format(lastchanged,'%d-%m-%Y') as lastchanged from person where personid=" . $uid);
	if (!$res)
		dberror("Cannot retrieve data 2 in avantgo/default.php");

	$data = mysql_fetch_assoc($res);
	$lastchanged = $data["lastchanged"];
	$name = $data["name"];

	echo "<b>Hi, " . $name . "</b><br>You have " . $bmcnt . " Bookmarks stored.<br>Last update: " . $lastchanged . "<br>";
	echo "<hr><center>";
	echo "<a href='add.php?uid=" . $uid . "'><img border=0 src='add.gif'></a> &nbsp;&nbsp;";
	if ($dolist)
		echo "<a href='list.php?uid=" . $uid . "'><img border=0 src='list.gif'></a> &nbsp;";

	echo "&nbsp; <a href='default.php?logoff=true'><img src='logoff.gif' border=0></a></center>";
}
?>
</body>
</html>
