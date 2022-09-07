<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#edit.php
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

header("Expires: -1");

restricted("../tree/edit.php");

if (!db_connect())
	die();

$ID = $_SESSION['ID'];
$GLOBALS['mainmenu'] = "EDIT";
$GLOBALS['submenu'] = "";

include '../inc/tree.php';
?>
<html>

<head>
<title>BookmarkSync - My Bookmarks</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
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
            <br>
            <h2>Welcome <?php echo $_SESSION['name']; ?> </h2>
            <h4>Your bookmarks and favorites are shown below<br>Use the green button to edit or <a href="conf.php">add a bookmark</a> now.</h4>
<?php
$delpath = "";
if (isset($_GET['delpath']))
	$delpath = strip($_GET["delpath"]);

if ($delpath != ""){
	if (substr($delpath,strlen($delpath)-1) == "\\")
		$sql = "update link set expiration=now() where path like '" . my_addslashes(my_addslashes($delpath)) . "%' and person_id=" . $ID;
	else
		$sql = "update link set expiration=now() where path='" . my_addslashes($delpath) . "' and person_id=" . $ID;

	debug_clear();
	debug_dump($delpath);
	debug_dump($sql);

	mysql_query($sql);
	mysql_query("update person set token = token + 1, lastchanged=now() where personid=" . $ID);
	mysql_query(" update publish set token = token + 1 where user_id=" . $ID);
} 

$old = "";
$mytitle = "";
$upd = "";

if (isset($_POST['old']))
	$old = $_POST["old"];

if (isset($_POST['mytitle']))
	$mytitle = substr($_POST["mytitle"],0,1);

if ($old != "" && isset($_POST['tree']) && isset($_POST['path']))
	$upd = $_POST["tree"] . prep($_POST["path"]);

if ($mytitle == "B" && $old != $upd){
//	mysql_query("delete from link where path='" . $upd . "' and person_id = " . $ID);
	mysql_query("update link set path='" . my_addslashes($upd) . "' where person_id = " . $ID . " and path='" . my_addslashes($old) . "'");
	mysql_query("update person set token = token + 1, lastchanged=now() where personid=" . $ID);
	mysql_query(" update publish set token = token + 1 where user_id=" . $ID);
}

if ($mytitle == "F" && $old != $upd){
//	mysql_query("delete from link where person_id=" . $ID . " and path in (select stuff(path,1," & len(old)+1 & ",'" & (upd) & "\') from link where person_id = " & id & " and path like '" & old & "\%')"
	$sql = "update link set path=insert(path,1,";
	$sql .= strlen($old)+1 . ",'" . my_addslashes($upd) . "\\\') where person_id = " . $ID . " and path like '" . my_addslashes(my_addslashes($old)) . "\\\\\\\\%'";
//	echo "<br>sql=" . $sql;
	mysql_query($sql);
	mysql_query("update person set token = token + 1, lastchanged=now() where personid=" . $ID);
	mysql_query(" update publish set token = token + 1 where user_id=" . $ID);
}

$newurl = "";
if (isset($_POST['newurl']))
	$newurl = $_POST['newurl'];

if ($newurl != ""){
	$newtitle = request("newtitle");
	if ($newtitle == ""){
		$newtitle = $newurl;
		if (strtolower(substr($newtitle,strlen($newtitle)-4,4)) == ".com")
			$newtitle = substr($newtitle,0,strlen($newtitle)-4);
//		if lcase(right("xxxx" & newtitle,4)) = ".com" then newtitle = left(newtitle,len(newtitle)-4)
		if (strtolower(substr($newtitle,0,7)) == "http://")
			$newtitle = substr($newtitle,7);
//		if left(lcase(newtitle) & "xxxxxxx",7) = "http://" then newtitle = right(newtitle,len(newtitle) -7)
	}

// actually add the bookmark (was a stored proc)
//	sql = "{ call addbookmark (" & ID & ",'" & replace(request.form("tree") & newtitle,"'","''") & "','" & replace(newurl,"'","''") & "') }"
//	connexecute (sql)
	$res = mysql_query("select distinct bookid from bookmarks where url = '" . my_addslashes($newurl) . "'");
	$data = mysql_fetch_assoc($res);
	if (!$data){
		mysql_query("insert into bookmarks (url) values ('" . my_addslashes($newurl) . "')");
		$book_id = mysql_insert_id();
	}
	else
		$book_id = $data['bookid'];

	mysql_query("update link set expiration = null, book_id=" . $book_id . " where person_id=" . $ID . " and path='" . my_addslashes($_POST['tree'] . $newtitle) . "'");
	if (mysql_affected_rows() == 0)
		mysql_query("insert into link (expiration,person_id,book_id,access,path) values (null," . $ID . "," . $book_id . ",now(),'" . my_addslashes($_POST['tree'] . $newtitle) . "')");
	// bump token
	mysql_query("update person set token = token + 1,lastchanged=now() where personid=" . $ID);
	mysql_query("update publish set token = token + 1 where user_id=" . $ID);
}
tree (0,true);
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

