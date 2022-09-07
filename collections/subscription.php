<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#subscription.php
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

$myurl = "../collections/subscription.php";
if ($_GET != "")
	$myurl .= "?" . $_GET;
restricted($myurl);

if (!db_connect())
	die();

$GLOBALS['mainmenu'] = "SUBSCRIBED";
$GLOBALS['submenu'] = "";
$MyMsg = "";
$ID = $_SESSION['ID'];
$xaddit = "";
$addit = "";

if (isset($_GET['addid']))
	$xaddit = $_GET['addid'];

if ($xaddit != ""){

	if ($xaddit == "-1")
		$xaddit = syncit_ncrypt($_SESSION['curcol']);
	
	$addit = syncit_ndecrypt($xaddit);
	
	$res = mysql_query("select user_id from publish where publishid=" . $addit);
	if (!$res)
		dberror("Cannot retrieve user_id in subscription.php");
	if (mysql_num_rows($res) > 0){
		$data = mysql_fetch_assoc($res);
		if ($data["user_id"] == $ID)
			$MyMsg = "You can not subscripe to your own collection!<br><br>";
		else {
			$res = mysql_query("insert into subscriptions (person_id,publish_id,created) values (" . $ID . "," . $addit . ",now())");
			if ($res)
				$MyMsg = "The collection has been added to your subscriptions<br><br>";
		} 
	} 
}

if (isset($_GET['delid']) && $_GET['delid'] != ""){
	mysql_query("delete from subscriptions where subscriptionid = " .syncit_ndecrypt($_GET['delid']));
	$MyMsg = "The collection has been removed from your subscriptions<br><br>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync Subscribed Collections</title>
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
            You currently subscribe to the following collections. Check out our <a href="recent.php">recent</a>
            or most <a href="popular.php">popular</a> collections from the
            menu. You can also <a href="showcategory.php">browse</a>
            or <a href="searchcol.php">search</a> for specific topics.
            <p>Click on a red diamond to unsubscribe from any of the
            collections.
            <br>
            <font color="#FF0000"><b><?php echo $MyMsg; ?></b></font>
            </p>
            <table width="491" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="59" rowspan="2"><img src="../images/subscribeicon.gif" width="59" height="43" alt=""></td>
                <td height="14" width="374" colspan="4"><img src="../images/tpix.gif" width="374" height="14" alt=""></td>
                <td width="58" rowspan="3"><img src="../images/inviteicon.gif" width="58" height="64" alt="Invite"></td>
              </tr>
              <tr>
                <td bgcolor="#FF9933" height="29" width="374" colspan="4"> &nbsp;<b>Subscribed Collections</b></td>
              </tr>
              <tr>
                <td width="59"><img src="../images/lbl_remove.gif" width="59" height="21" alt="Remove"></td>
                <td bgcolor="#000066" height="21" width="51" align="center"><img src="../images/lbl_view.gif" width="36" height="21" alt="View"></td>
                <td bgcolor="#000066" width="55" align="center"><img src="../images/lblb_author.gif" width="42" height="21" alt="Author"></td>
                <td bgcolor="#000066" width="84" align="center"><img src="../images/lblb_title.gif" width="27" height="21" alt="Title"></td>
                <td bgcolor="#000066" width="184" align="center"><img src="../images/lblb_description.gif" width="93" height="21" alt="Description"></td>
              </tr>
<?php
$res = mysql_query("select publish.publishid,subscriptions.subscriptionid,publish.title,person.name as pname,publish.description,publish.anonymous
						from person,subscriptions,publish where publish.publishid = subscriptions.publish_id 
						and person.personid = publish.user_id and publish.user_id <> " . $newsid . " and subscriptions.person_id=".$ID);

if (!$res)
	dberror("Cannot retrieve data in subscription.php");

while($data = mysql_fetch_assoc($res)){
	$pid = syncit_ncrypt($data["publishid"]);
	$sid = syncit_ncrypt($data["subscriptionid"]);
	$title = $data["title"];
	$author = $data["pname"];
	$description = $data["description"];
	if ($data["anonymous"] == "true")
		$author = "---";

	if ($xaddit == $pid)
		echo "<tr bgcolor='#FFEEDD'>";
	else
		echo "<tr>";
?>
	<td width="59" align="center"><a href="subscription.php?delid=<?php echo $sid; ?>"><img border="0" src="../images/rsquare.gif" width="14" height="14" alt="Remove"></a></td>
	<td width="51" align="center"><a href="../tree/cview.php?ref=SUBSCRIBED&pid=<?php echo $pid; ?>"><img src="../images/bsquare.gif" width="14" height="14" border="0" alt="View"></a></td>
	<td width="55" align="center" class="f11"><?php echo $author; ?></td>
	<td width="84" align="center" class="f11" bgcolor="#FFEEDD"><?php echo $title; ?></td>
	<td width="184" align="center" class="f11"><?php echo $description; ?></td>
	<td width="58" align="center"><a href="invite.php?ref=SUBSCRIBED&pid=<?php echo $pid; ?>"><img src="../images/ysquare.gif" width="14" height="14" border="0" alt="Invite"></a></td>
	</tr>
<?php
	echo "<tr><td width='491' align='center' colspan='6'><img src='../images/psep.gif' width='491' height='10' alt=''></td></tr>";
} 
?>
            </table>
            <h3><b>Legend:</b></h3>
            <p><b> </b><img src="../images/rsquare.gif" width="14" height="14" alt="Remove"> Remove
              this Collection (double-click your SyncIT icon to reflect changes)<b><br>
              </b><img src="../images/bsquare.gif" width="14" height="14" alt="View"> View this
              Collection as a bookmark tree<br>
              <img src="../images/ysquare.gif" width="14" height="14" alt="Invite"> Send someone
              an e-mail invitation to subscribe to this collection</p>
            </td>
          <td width="10" valign="top">&nbsp;</td>
      </table>

    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
</html>










