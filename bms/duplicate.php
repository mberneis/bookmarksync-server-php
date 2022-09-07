<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#duplicate.php
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

restricted("../bms/duplicate.php");

$ID = $_SESSION['ID'];
$GLOBALS['mainmenu'] = "UTILITIES";
$GLOBALS['submenu'] = "DUPLICATES";

if (!db_connect())
	die();

$sql = "select link_id,book_id,path from link where person_id=" . $ID . " and book_id is not null and expiration is null order by book_id";

$res = mysql_query("select token from person where personid = " . $ID);
if (!$res)
	dberror("Cannot retrieve token in duplicate.php");
$data = mysql_fetch_assoc($res);
$token = $data["token"];
mysql_free_result($res);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync: Duplicate Links</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#660066" vlink="#990000" alink="#CC0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<?php include '../inc/ymenu.php'; ?>
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
<?php include '../inc/yhead.php'; ?>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br>
            <h2>Duplicate Links</h2>
            <form method="POST" action="duplicate.php">
<?php
if (isset($_POST['token']) && $_POST['token'] != ""){

	if (intval($token) == intval(substr($_POST["token"],5))){

		$inlist = "";
		foreach ($_POST as $delid){
			if (is_numeric($delid))
				$inlist .= $delid . ",";
		}
		$inlist = rtrim($inlist,",");

		if ($inlist != ""){
			mysql_query("update link set expiration = now() where link_id in(" . $inlist . ")");
			mysql_query("update person set token = token + 1, lastchanged=now() where personid=" . $ID);
			mysql_query("update publish set token = token + 1 where user_id=" . $ID);
			echo "<p><b>Selected duplicates removed.<br>Please double-click on the SyncIT icon in your taskbar to re-synchronize</b></p>";
		}
	
	}
	else
		echo "<p><b>Your bookmarks have changed since your selection.<br>Please reselect the duplicates to remove again.</b></p>";
}
echo "<input type='hidden' name='token' value='token" . $token . "'>";
$res = mysql_query($sql);
if (!$res)
	dberror("Cannot retrieve 2nd data in duplicate.php");
if (mysql_num_rows($res) == 0)
	echo "<p><b>You have no bookmarks</b></p>";
else {
?>
	These are all the duplicates we could find in your bookmarks.<br>
	You may want to remove some duplicate entries by checking the appropriate link.   <br><br>
	<table width="491" border="0" cellpadding="0" cellspacing = "0">
	<tr bgcolor="#000066"><th align="left"><font color="#FFFFFF">&nbsp;Folder</font></th><th align="left"><font color="#FFFFFF">Bookmark</font></th><th align="right"><font color="#FFFFFF">Delete ?&nbsp;</font></th></tr>
<?php
	$cnt = 0;
	$bid = 0;
	$lastb = "";
	$bg = "";

	while($data = mysql_fetch_assoc($res)){

		$tmp = explode("\\",$data["path"]);
		$p1 = $tmp[1];
		$p2 = substr($data["path"],strlen($p1)+2);

		if ($bid != $data["book_id"]){
			$bid = $data["book_id"];
			$chk = "";
		}
		else
			$chk = "checked";

		$delstr = "<td>" . $p1 . "</td><td><a target=_blank href='showbm.php?bid=" . $data["book_id"] . "'>" . $p2 . "</a></td><td align=right><input name=" . $data["link_id"] . " value=" . $data["link_id"] . " type=checkbox " . $chk . "></td></tr>\r\n";
		if ($data["book_id"] != $lastb){
			$lastb = $data["book_id"];
			$firststr = $delstr;
		}
		else {
			if ($firststr != ""){
				if ($bg == "#EEEEEE")
					$bg = "#FFFFCC";
				echo "<tr bgcolor=" . $bg . ">" . $firststr;
				$firststr = "";
			} 
			echo "<tr bgcolor=" . $bg . ">" . $delstr;
		}
	} 

	echo "<tr><td colspan=3 align='right'><br><input type='Submit' name='doit' value=' Delete checked ' class='pbutton'></td></tr>\r\n</table>";
} 
?>

</form></td><td width="10" valign="top">&nbsp;</td></tr></table></td></tr></table>
<?php include '../inc/footer.php'; ?>
</body>
</html>
