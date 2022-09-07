<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#publication.php
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

restricted("../collections/publication.php");

$ID = $_SESSION['ID'];
$GLOBALS['mainmenu']="PUBLISHED";
$GLOBALS['submenu']="";

$description = "";
$category = "";
$title = "";
$action = "";
$MyMsg = "";

if (!db_connect())
	die();

if (isset($_POST['action']))
	$action = $_POST['action'];

if ($action != ""){

	if (isset($_POST['description']))
		$description = nohack(strip($_POST['description']));
	if (isset($_POST['category']))
		$category = $_POST['category'];
	if (isset($_POST['title']))
		$title = nohack(strip($_POST['title']));
	
	if ($action == "add"){
	
		$tree = trim(strip($_POST["tree"]),"\\");
		$res = mysql_query("select user_id from publish where path='" . $tree . "' and user_id = " . $ID);
		if (!$res)
			dberror("Cannot retrieve user_id from tree in publication.php");

		if (mysql_num_rows($res) == 0){
			$sql = "insert into publish (user_id,path,category_id,created,token,anonymous,title,description) values (" . $ID . ",'" . $tree ."'," . $category . ",now(),0,";
			if (!isset($_POST["anonymous"]) || $_POST['anonymous'] == "")
				$sql .= "0,";
			else
				$sql .= "1,";
	
			$sql .= "'" . $title . "',";
			$sql .= "'" . $description . "')";
			mysql_query($sql);
	
			$res = mysql_query("Select publishid from publish where path = '" . $tree . "' and user_id = " . $ID);
			if (!$res)
				dberror("Cannot retrieve publishid in publication.php");
			$data = mysql_fetch_assoc($res);
			$newpid = $data["publishid"];
			myredirect("invite.php?pid=" . syncit_ncrypt($newpid) . "&addbm=true");
		}
		else
			$MyMsg="The collection has already been added previously!<br><br>";
	}
	
	if ($action == "mod"){
		$sql = "update publish set category_id = " . $category . ",title = '" . $title . "',description = '" . $description . "', anonymous=";
		if (!isset($_POST["anonymous"]) || $_POST['anonymous'] == "")
			$sql .= "0";
		else
			$sql .= "1";
	
		$sql .= ", token = token + 1 WHERE publishid = " . syncit_ndecrypt($_POST["pid"]);
		mysql_query($sql);
		$MyMsg = "Your collection has been modified<br><br>";
	}
}

if (isset($_GET['delid']) && $_GET['delid'] != ""){
	$delid = syncit_ndecrypt($_GET['delid']);
	$res = mysql_query("select user_id from publish where publishid=" . $delid);
	if (!$res)
		dberror("Cannot retrieve user_id in publication.php");
	if (mysql_num_rows($res) > 0){
		$data = mysql_fetch_assoc($res);
		if ($ID != $data["user_id"])
			$MyMsg = "You can only remove your own collections!<br><br>";
		else {
			mysql_query("delete from subscriptions where publish_id=" . $delid);
			mysql_query("delete from publish where publishid = " . $delid . " and user_id = " .$ID);
			$MyMsg = "Your collection has been removed!<br><br>";
		}
	}
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync Published Collections</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#3333FF" vlink="#990099" alink="#CC0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="111" valign="top">
<?php include '../inc/cmenu.php'; ?>
    </td>
    <td width="511" valign="top">
      <table width="511" border="0" cellspacing="0" cellpadding="0">
<?php include '../inc/chead.php'; ?>
          <td width="10">&nbsp;</td>
          <td width="491" valign="top">
            <br>
            Here are your published collections.<br>
            Click on the green diamond to modify or remove any of them<br><b><font color="#FF0000"><?php echo $MyMsg; ?></font>
            </b>
            <table width="491" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="59" rowspan="2"><img src="../images/subscribeicon.gif" width="59" height="43" alt=""></td>
                <td height="14" width="374" colspan="4"><img src="../images/tpix.gif" width="374" height="14" alt=""></td>
                <td width="58" rowspan="3"><img src="../images/inviteicon.gif" width="58" height="64" alt="Invite"></td>
              </tr>
              <tr>
                <td bgcolor="#FF9933" height="29" width="374" colspan="4"> &nbsp;<b>My
                  Published Collections</b></td>
              </tr>
              <tr>
                <td width="59"><img src="../images/lbl_fans.gif" width="59" height="21" alt="Fans"></td>
                <td bgcolor="#000066" height="21" width="51" align="center"><img src="../images/lbl_view.gif" width="36" height="21" alt="View"></td>
                <td bgcolor="#000066" width="55" align="center"><img src="../images/lbl_modify.gif" width="42" height="21" alt="Modify"></td>
                <td bgcolor="#000066" width="84" align="center"><img src="../images/lblb_title.gif" width="27" height="21" alt="Title"></td>
                <td bgcolor="#000066" width="184" align="center"><img src="../images/lblb_description.gif" width="93" height="21" alt="Description"></td>
              </tr>
<?php

$res = mysql_query("select publishid,title,publish.description from publish where publish.user_id=" . $ID);
if (!$res)
	dberror("Cannot retrieve publications in publication.php");

while($data = mysql_fetch_assoc($res)){

	$res1 = mysql_query("select subscriptionid from subscriptions where publish_id=" . $data['publishid']);
	$pcount = mysql_num_rows($res1);

	$pid = syncit_ncrypt($data["publishid"]);
	$title = $data["title"];
	$description = $data["description"];

	echo "<tr>\r\n" . "<td width='59' align='center'>" . $pcount . "</td>\r\n";
	echo "<td width='51' align='center'><a href='../tree/cview.php?ref=PUBLISHED&pid=" . $pid . "'>";
	echo "<img src='../images/bsquare.gif' width='14' height='14' border='0' alt='View'></a></td>\r\n";
	echo "<td width='55' align='center' class='f11'><a href='editpub.php?ref=PUBLISHED&pid=" . $pid . "'>";
	echo "<img src='../images/gsquare.gif' width='14' height='14' border='0' alt='Modify'></a></td>\r\n";
	echo "<td width='84' align='center' class='f11' bgcolor='#FFEEDD'>" . $title . "</td>\r\n";
	echo "<td width='184' align='center' class='f11'>" . $description . "</td>\r\n";
	echo "<td width='58' align='center'><a href='invite.php?ref=PUBLISHED&pid=" . $pid . "'>";
	echo "<img src='../images/ysquare.gif' width='14' height='14' border='0' alt='Invite'></a></td></tr>\r\n";

	echo "<tr><td width='491' align='center' colspan='6'><img src='../images/psep.gif' width='491' height='10' alt=''></td></tr>";
} 
?>
            </table>
            <h3><b>Legend:</b></h3>
            <p><b> </b><img src="../images/bsquare.gif" width="14" height="14" alt="View"> View
              this Collection as a bookmark tree<br>
              <img src="../images/gsquare.gif" width="14" height="14" border="0" alt="Change">
              Make changes to your collection (modify title, description, access-rights)<br>
              <img src="../images/ysquare.gif" width="14" height="14" alt="Invite"> Send someone
              an e-mail invitation to subscribe to this collection
            </p>
            </td>
          <td width="10" valign="top">&nbsp;</td>
      </table>
    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>

</html>

