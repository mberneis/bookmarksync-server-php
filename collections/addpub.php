<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#addpub.php
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

restricted("../collections/addpub.php");

$ID = $_SESSION['ID'];
header("Expires: 0");

$GLOBALS['mainmenu']="ADD NEW";
$GLOBALS['submenu']="";

if (!db_connect())
	die();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync Add New Collection</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>
<script language="JavaScript">
<!--
function fillfrm() {
	   lbl = document.publish_form.tree.options[document.publish_form.tree.selectedIndex].value;
	   if (document.publish_form.title.value == '') document.publish_form.title.value = lbl;
	   if (document.publish_form.description.value == '') document.publish_form.description.value = lbl;
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
            <br><h2>Add your own collection.</h2>
            <dir>
              <p>The folders into which you have saved your bookmarks and
              favorites appear below. Select the folder which you would like to
              publish. Give your collection a Title and Description, and select
              a category which best describes your bookmarks.&nbsp;<br>
              If you choose <b>* Private *</b>, your publication will not be
              available to anyone but you and the people you invite to share.</p>
              <p>You can make additions to your publication at any time from
              your browser by saving bookmarks into the corresponding folder. If
              you wish to remove or modify the title or description of an
              existing publication, click <a href="publication.php">here</a>.&nbsp;</p>
            </dir>
<? 
$res = mysql_query("select path from link where person_id=" . $ID . " and expiration is null order by path");
if (!$res)
	dberror("Cannot retrieve bookmarks in addpub.php");
if (mysql_num_rows($res) == 0)
	echo "No bookmarks to publish yet.";
else {
?>
	<script language="JavaScript">
	<!--
	function validate(theForm)
	{
	
	  if (theForm.tree.selectedIndex <= 0)
	  {
	    alert("Please select a Folder to publish.");
	    theForm.tree.focus();
	    return (false);
	  }
	
	  if (theForm.category.selectedIndex <= 0)
	  {
	    alert("Please select a Category for your collection.");
	    theForm.category.focus();
	    return (false);
	  }
	
	  
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
	--></script>

	<form action="publication.php" method="POST" onsubmit="return validate(this);" name="publish_form">
			<input type="hidden" name="action" value="add">
                <table border="0" cellpadding="2" cellspacing="2">
                  <tr> 
                    <td align="right" class="menub">FOLDER: </td>
                    <td colspan="2"> 
                      <select name="tree" class="register" onclick="fillfrm();">
                        <option>[Pick Folder to Publish]</option>
<?php

	$delim = "";
	$showit = true;
	$publishit = true;
	$level = 0;
	$foldernum = 0;
	
	while($data = mysql_fetch_assoc($res)){
	
		$dpath = "";

		$line = explode("\\",substr($data['path'],1));
		$items = count($line);

		if ($items > 1){
			for ($i=0; $i<$items-2; $i++)
				$dpath .= "- ";

			$dpath .= $line[$items-2];

			if ($dpath != $cur_path){
				echo "<option " . "value='" . trim($data['path'],"\\") . "'>" . trim($dpath,"\\") . "</option>\r\n";
				$cur_path = $dpath;
			}
		}
	}
?> 
                      </select>
                    </td>
                  </tr>
                  <tr> 
                    <td align="right" class="menub">TITLE: </td>
                    <td colspan="2"> 
                      <input type="text" name="title" class="register" size="20" maxlength="50">
                    </td>
                  </tr>
                  <tr> 
                    <td align="right" class="menub"> &nbsp;&nbsp;DESCRIPTION:&nbsp;</td>
                    <td colspan="2"> 
                      <textarea name="description" rows="6" class="register" cols="20"></textarea>
                    </td>
                  </tr>
                  <tr> 
                    <td align="right" class="menub">CATEGORY: </td>
                    <td colspan="2"> 
                      <select name="category" class="register">
                      <option>[Please Pick Category]</option>
<?php
	$res = mysql_query("Select * from category order by name");
	while ($data = mysql_fetch_assoc($res))
		echo "<option value = " . $data['categoryid'] . ">" . $data['name'] . "</option>";
?> 
                      </select>
                    </td>
                  </tr>
                  <tr> 
                    <td align="right" class="menub">ANONYMOUS: </td>
                    <td align="left">
                      <input type="checkbox" name="anonymous" value="checkbox">
                    </td>
                    <td align="right">
                      <input type="image" border="0" name="imageField" src="../images/btnadd.gif" width="62" height="16" alt="Add">
                    </td>
                  </tr>
                </table>
            </form>
<?php
}
?>
            <h3>&nbsp;</h3>
            </td>
          <td width="10" valign="top">&nbsp;</td>
      </table>
    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
</html>
