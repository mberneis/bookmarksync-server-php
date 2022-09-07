<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#editpub.php
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

restricted("../collections/invite.php?" . $_GET);

$GLOBALS['mainmenu'] = "MODIFY";
$GLOBALS['submenu'] = "";
header("Expires: 0");

$delsub = request("delsub");
if ($delsub != "")
	mysql_query("delete from subscriptions where subscriptionid=" . str_replace(","," or subscriptionid=",$delsub));

if (isset($_GET['ref']))
	$ref = $_GET["ref"];

if ($ref != "")
	$GLOBALS['mainmenu'] = $ref;

$ID = $_SESSION['ID'];

$pubid = request("pid");
if ($pubid == "")
	$pubid = syncit_ncrypt($_SESSION['curcol']);

if ($pubid == "")
	myredirect("../collections/publication.php");

$pid = syncit_ndecrypt($pubid);
if ($pid == 0)
	myredirect($_SERVER['HTTP_REFERER']);

$_SESSION['curcol'] = $pid;

if (!db_connect())
	die();

$res = mysql_query("select * from publish where publishid = " . $pid);
if (!$res)
	dberror("Cannot retrieve data 1 in editpub.php");
$data = mysql_fetch_assoc($res);
$user_id = $data["user_id"];
$tree = $data["path"];
$catid = $data["category_id"];
$title = $data["title"];
$description = $data["description"];
$anonymous = "";
if ($data["anonymous"])
	$anonymous = "checked";

if ($user_id != $ID)
	myredirect("default.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync Modify Collection</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>
<script language="JavaScript">
<!--
function delit(pid) {
	if (confirm('Remove this collection?')) {
		location.href = 'publication.php?delid='+pid;
	}
}
//-->
</script>
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
              <img src="../images/iconpublish.gif" width="79" height="82" align="right" hspace="5" vspace="5" alt="Publish">
              <br><h2>Modify your collection.</h2>
		<br clear="all"><br><script language="JavaScript"><!--
function validate(theForm)
{

  if (theForm.title.value == "")
  {
    alert("Please enter a value for the 'title' field.");
    theForm.title.focus();
    return (false);
  }

  if (theForm.title.value.length > 50)
  {
    alert("Please enter at most 50 characters in the 'title' field.");
    theForm.title.focus();
    return (false);
  }

  if (theForm.description.value == "")
  {
    alert("Please enter a value for the 'description' field.");
    theForm.description.focus();
    return (false);
  }
  return (true);
}
-->
</script>
<form method="POST" action="publication.php" onsubmit="return validate(this)" name="edit_form">
				<input type="hidden" name="action" value="mod">
				<input type="hidden" name="pid" value="<? echo $pubid; ?>">
                <table border="0" cellpadding="2" cellspacing="2">
                  <tr> 
                    <td align="right" class="menub">FOLDER: </td>
                    <td colspan="3"><b><? echo $tree; ?></b></td>
                  </tr>
                  <tr> 
                    <td align="right" class="menub">TITLE: </td>
                    <td colspan="3"> 
                      <input type="text" name="title" class="register" value="<? echo $title; ?>" size="20" maxlength="50">
                    </td>
                  </tr>
                  <tr> 
                    <td align="right" class="menub"> &nbsp;&nbsp;DESCRIPTION:&nbsp;</td>
                    <td colspan="3"> 
                      <textarea name="description" rows="6" class="register" cols="20"><? echo $description; ?></textarea>
                    </td>
                  </tr>
                  <tr> 
                    <td align="right" class="menub">CATEGORY: </td>
                    <td colspan="3"> 
                      <select name="category" class="register">
<?php
$res = mysql_query("select * from category order by name");
if (!$res)
	dberror("Cannot retrieve data 2 in editpub.php");

while($data = mysql_fetch_assoc($res)){

	$cid = $data["categoryid"];
	if ($catid == $cid)
		echo "<option selected value = " . $cid . ">" . $data["name"] . "</option>";
	else
		echo "<option value = " . $cid . ">" . $data["name"] . "</option>";
} 
?> 
	</select>
	</td>
	</tr>
	<tr> 
	<td align="right" class="menub">ANONYMOUS: </td>
	<td align="right"> 
	<div align="left"> 
	<input type="checkbox" name="anonymous" value="checkbox" <? echo $anonymous; ?>>
	</div>
	</td>
	<td align="right" valign="bottom"> 
	<div align="center"><a href="javascript:delit('<? echo $pubid; ?>');"><img border="0" src="../images/btn_remove.gif" width="62" height="16" alt="Remove"></a><a href="publication.php"><img border="0" src="../images/btncancel.gif" width="62" height="16" alt="Cancel"></a> 
	</div>
	</td>
	<td align="right" valign="bottom">
	<input type="image" border="0" name="imageField" src="../images/btnmodify.gif" width="62" height="16" alt="Modify">
	</td>
	</tr>
	</table>
	</form>
<?php
if ($catid == 0){
?>
	<form method="post" action="editpub.php">
	<table border=0 width="100%">
	<tr bgcolor=#000066><td colspan=3 class="menuw">SUBSCRIBERS</td></tr>
<?php
	$res = mysql_query("select subscriptionid,email,name from subscriptions,person where publish_id = " . $pid . " and subscriptions.person_id=person.personid");
	while($data = mysql_fetch_assoc($res)){
		echo "<tr bgcolor=#EEEEEE><td><input type='checkbox' name='delsub' value=" . $data["subscriptionid"] . "></td>";
		$email = $data["email"];
		echo "<td>" . $data["name"] . "</td><td><a href='mailto:" . $email . "'>" . $email . "</a></td></tr>";
  } 
?>            
		</table>
		<input type=submit value="Remove checked Subscriber" class="pbutton">
            </form>
<?php
}
?>            
</td>
<td width="10" valign="top">&nbsp;</td>
</table>
</td>
</tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
</html>

