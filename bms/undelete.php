<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#undelete.php
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

restricted("../bms/undelete.php");

$ID = $_SESSION['ID'];
$bg = "";

$GLOBALS['mainmenu'] = "UTILITIES";
$GLOBALS['submenu'] = "UNDELETE";

if (!db_connect())
	die();

$deldate = request("deldate");
if ($deldate == "" || strtotime($deldate) === -1){
	$date = getdate();
	$deldate = sprintf("%4d/%02d/%02d",$date['year'],$date['mon'],$date['mday']);
	$realdate = sprintf("%4d/%02d/%02d",$date['year'],$date['mon'],$date['mday']);
}
else {
	$d = strtotime($deldate);
	$rdate = getdate($d);
	$realdate = sprintf("%4d/%02d/%02d",$rdate['year'],$rdate['mon'],$rdate['mday']);
}

$undelete = request("undelete");
if ($undelete != ""){
	mysql_query("update link set expiration = null where link.person_id =" . $ID . " and link.expiration >= '" . $realdate . "'");
//	echo "update link set expiration = null where link.person_id =" . $ID . " and link.expiration > '" . $realdate . "'";
	mysql_query("update person set token = token + 1, lastchanged=now() where personid=" . $ID);
	mysql_query("update publish set token = token + 1 where user_id=" . $ID);
}

$delbid = request("delbid");
$deluid = request("deluid");
if ($delbid != "" && $deluid != ""){
	$pid = request("path");
	mysql_query("update link set expiration = null where link.person_id = " . $deluid . " and link.book_id = " . $delbid . " and link.path = '" . my_addslashes($pid) . "'");
	mysql_query("update person set token = token + 1, lastchanged=now() where personid=" . $ID);
	mysql_query("update publish set token = token + 1 where user_id=" . $ID);
} 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync: Undelete Bookmarks</title>
<meta http-equiv="Content-Type" content="text/html">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../common/syncit.css" type="text/css">
</head>

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
            <p>&nbsp;</p>
            <h2>Undelete Bookmarks </h2>
<?php
$res = mysql_query("select link.person_id,link.path,bookmarks.bookid as delbid,bookmarks.url,link.expiration from bookmarks 
		right join link on bookmarks.bookid = link.book_id where link.person_id = " . $ID . 
		" and link.expiration > '" . $realdate . "' order by link.expiration desc");
if (!$res)
	dberror("Cannot retrieve bookmarks in undelete.php");

if (mysql_num_rows($res) == 0){
	if (request("undelete") != "")
		echo "<font color='#FF0000'><b>Bookmarks undeleted. <br>Please double-click on your SyncIT Icon in the taskbar to re-synchronize</b></font>";
	else
		echo "<p><b>According to our database, you have not deleted any bookmarks or favorites since " . $deldate . ".</b></p>";
?>
	<form method="POST" action="undelete.php">
	<span class="menub">Deleted Bookmarks since: (MM/DD/YYYY) </span><br>
	<input class="register" type="text" name="deldate" size="20" value="<?php echo $deldate; ?>"> <input border="0" src="../images/btn_refresh.gif" name="I1" type="image" width="62" height="16" alt="Refresh">
	</form>
<?php
}
else {
?>
	<p>These Bookmarks have been deleted since <?   echo $deldate; ?>.
	To restore deleted bookmarks, highlite the date you want SyncIT to go back to,
	and SyncIT will restore all bookmarks deleted since that date.
	To restore all shown deleted bookmarks, press <b>UNDELETE ALL</b>.
	To undelete individual bookmarks, click to the
	<img src="../images/gsquare.gif" border="0" alt="Instant Undelete" width="14" height="14">
	button next to each bookmark you want SyncIT to restore.</p>

	<form method="POST" action="undelete.php">
	<span class="menub">Deleted Bookmarks since: (YYYY/MM/DD) </span><br>
	<input class="register" type="text" name="deldate" size="20" value="<?php echo $deldate; ?>"> <input border="0" src="../images/btn_refresh.gif" name="I1" type="image" width="62" height="16" alt="Refresh">
	</form>
	<form method="POST" action="undelete.php">
	<table width="491" border="0" cellpadding="0" cellspacing="0">
	<tr bgcolor="#000066"><th align="left"><font color="#FFFFFF">&nbsp;Folder</font></th><th align="left"><font color="#FFFFFF">Bookmark</font></th><th align="right"><font color="#FFFFFF">Removed (EST)</font></th><th>&nbsp;&nbsp;</th></tr>

<?php
	$endloop = false;
	debug_clear();
	$data = mysql_fetch_assoc($res);
		debug_dump($data["path"]);
	while($endloop == false){
		$p = $data["path"];
		$p = substr($p,strlen($p)-(strlen($p)-1));
		$p1 = "";
		$p2 = $p;

		do {
			$i = strpos($p2,"\\");
			if ($i === false || $i == 0)
				break;

			$p2 = substr($p2,strlen($p2)-(strlen($p2)-$i));
		} while (true);

		$expiration = $data["expiration"];

		if (strlen($p2) < strlen($p))
			$p1 = str_replace("\\"," | ",substr($p,0,strlen($p)-strlen($p2)));

		if ($bg == "#EEEEEE")
			$bg = "#FFFFCC";
		else
			$bg="#EEEEEE";

		echo "<tr bgcolor=" . $bg . "><td>" . $p1 . "</td><td>&nbsp;<a target=_blank href='" . $data["url"] . "'>" . $p2 . "</a></td>";
		echo "<td align='right'>";

		$delbid = $data["delbid"];
		$deluid = $data["person_id"];
		$delpid = rawurlencode($data["path"]);
		if ($p2 != "")
			$undelcell = "<td align='right' bgcolor=" . $bg . ">&nbsp;<a href='undelete.php?delbid=" . $delbid . "&deluid=" . $deluid . "&deldate=" . rawurlencode($deldate) . "&path=" . $delpid . "'><img vspace=5 src='../images/gsquare.gif' border=0 alt='Instant Undelete'></a></td>";
		else
			$undelcell = "<td>&nbsp;</td>";

		$data = mysql_fetch_assoc($res);
		if ($data)
			$doit = ($data["expiration"] != $expiration);
		else {
			$endloop = true;
			$doit = false;
		} 
		
		if ($doit)
			echo " <a href='undelete.php?deldate=" . rawurlencode($expiration) . "'>" . $expiration . "</a></td>";
		else
			echo $expiration . "</td>";

		echo $undelcell . "</tr>\r\n";
	}
?>
	<tr><td colspan="3" align="right"><br>
	<input border="0" src="../images/btn_undeleteall.gif" name="I1" type="image" width="102" height="16" alt="Undelete All"></p>
	</td></tr>
<?php
}
?>
</table>
<input type="hidden" name="deldate" value="<? echo $deldate; ?>">
<input type="hidden" name="undelete" value="true">
</form>
</table>
</td>
<td width="10" valign="top">&nbsp;</td>
</tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>






