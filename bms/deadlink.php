<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#deadlink.php
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

restricted("../bms/deadlink.php");

$ID = $_SESSION['ID'];
$GLOBALS['mainmenu'] = "UTILITIES";
$GLOBALS['submenu'] = "DEAD LINKS";

if (!db_connect())
	die();

$sql = "select link.path,bookmarks.url,bookmarks.status,bookmarks.bookid from bookmarks right join link on bookmarks.bookid = link.book_id
		where link.expiration is null and status = 404 and bookmarks.lastchecked is not null and link.person_id=" . $ID . " order by link.path";

$res = mysql_query("select token from person where personid = " . $ID);
if (!$res)
	dberror("Cannot retrieve token in deadlink.php");
$data = mysql_fetch_assoc($res);
$token = $data["token"];
mysql_free_result($res);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title>BookmarkSync: Dead Links</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>
<script language=javascript>
<!--
function CheckAll(checked) {
	var i,len = document.frmdead.elements.length;
	for( i=0; i<len; i++) {
		if (document.frmdead.elements[i].name=='deldup') {
			document.frmdead.elements[i].checked=checked;
		}
	}
	CheckSusp(checked);
}
//-->
</script>
<body bgcolor="#FFFFFF" text="#000000" link="#3300CC" vlink="#990000" alink="#CC0099">
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
            <h2>Dead Links</h2>
	<form name="frmdead" method="post" action="deadlink.php">
<?php

if (isset($_POST['token']) && $_POST['token'] != ""){

	if (intval($token) == intval($_POST["token"])){

		// delete duplicates
		$deldup = " " . $_POST["deldup"] . ",";
		$checkit = " " . $_POST["checkit"] . ",";
		$res = mysql_query($sql);
		if (!$res)
			dberror("Cannot retrieve main data in deadlink.php");

		$cnt = 0;
		$strtemp = "";

		while($data = mysql_fetch_assoc($res))
			$strtemp .= str_replace("'","''",$data["path"]) . "\r";

		do {
			$cnt++;
			$i = strpos($strtemp,"\r");
			if ($i == 0)
				break;
			
			$strtoken = substr($strtemp,0,$i-1);
			$strtemp = substr($strtemp,strlen($strtemp)-(strlen($strtemp)-$i));
			if (strpos($deldup," " . $cnt . ","))
				mysql_query("update link set expiration = now() where person_id=" . $ID . " and path=" . $strtoken);
		} while (true);

		if ($cnt > 0){
			mysql_query("update person set token = token + 1, lastchanged=now() where personid=" . $ID);
			mysql_query("update publish set token = token + 1 where user_id=" . $ID);
			$token++;
			echo "<p><b>Selected dead links removed.<br>Please double-click on the SyncIT icon in your taskbar to re-synchronize</b></p>";
		} 

	}
	else {
		echo "<p><b><font color=#FF6666>Your bookmarks have changed since your selection.<br>";
		echo "Please re-select the dead links to be removed again.</font></b></p>";
	} 
}

echo "<input type='hidden' name='token' value='" . $token . "'>";
$res = mysql_query($sql);
if (!$res)
	dberror("Cannot retrieve data 2 in deadlink.php");
if (mysql_num_rows($res) == 0)
	echo "<p><b>You have no dead bookmark links</b></p>";
else {

?>
	The following list of bookmarks could not be accessed by our server.<br>Please review them carefully as
	they might be internal links or secure sites. <br>If you want to remove a specific bookmark check
	the Delete column.<br><br>
	<table width="491" border="0" cellpadding="0" cellspacing="0">
	<tr bgcolor="#000066"><th align="left"><font color="#FFFFFF">&nbsp;Folder</font></th><th align="left"><font color="#FFFFFF">Bookmark</font></th><th align="left"><font color="#FFFFFF">Status&nbsp;</font></th><th align="right"><font color="#FFFFFF">Delete ?&nbsp;</font></th></tr>
<?php

	$cnt = 0;
	$bid = 0;
	
	while ($data = mysql_fetch_assoc($res)){
		$cnt++;
		$deadurl = $data["url"];
		if (substr($deadurl,0,4) == "http"){
			$p = $data["path"];
			$p = substr($p,strlen($p)-(strlen($p)-1));
			$p1 = "";
			$p2 = $p;

			do {
				$i = strpos($p2,"\\");
				if ($i == 0)
					break;
				$p2 = substr($p2,strlen($p2)-(strlen($p2)-$i));
			} while (true);

			if (strlen($p2) < strlen($p))
				$p1 = str_replace("\\"," | ",substr($p,0,(strlen($p)-strlen($p2)-1)));
			if ($bg == "#EEEEEE")
				$bg = "#FFFFCC";
			echo "<tr bgcolor='" . $bg . "'><td>" . $p1 . "</td><td><a target='_blank' href='" . $deadurl . "'>" . $p2 . "</a></td>";
			echo "<td>" . $data["status"] . "</td>";
			echo "<td align='center'><input name='deldup' value ='" . $cnt . "' type='checkbox'></td></tr>";
		}
	}
?>
	<tr><td colspan="4">
	<p align="right"><br><input type="image" border="0" src="../images/btn_delchecked.gif" name="I1" width="102" height="16" alt="Delete Checked">
	</p><p align="left"><input type=button class="pbutton" onClick="CheckAll(true)" value="Check All"> <input type=button onClick="CheckAll(false)" value="Clear All" class="pbutton"> </p>
	</td></tr>
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
</html>

