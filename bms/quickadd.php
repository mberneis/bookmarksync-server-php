<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#quickadd.php
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

$GLOBALS['mainmenu'] = "UTILITIES";
$GLOBALS['submenu'] = "QUICK ADD";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>Quick Add</title>
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
<!-- * -->
            <br>
            <h2>QUICK ADD</h2>
            <p>Need to add bookmarks to your account from a foreign computer? It's easy! </p>
<?php

$agent = $_SERVER['HTTP_USER_AGENT'];

// 1 - Netscape
// 2 - MSIE
// 3 - Other?

if (strpos($agent,"compatible"))
	$b_type = 1;
else if (strpos($agent,"MSIE"))
	$b_type = 2;
else
	$b_type = 3;


// 1 - Win
// 2 - Mac
// 3 - Other

if (strpos($agent,"Win"))
	$b_platform = 1;
else if (strpos($agent,"Mac"))
	$b_platform = 2;
else
	$b_platform = 3;

if ($b_type == 1 && $b_platform == 1){
?>
	<p><b>Netscape on Windows</b>
	<ol><li>Right-click on the link below</li>
	<li>Select &quot;Add Bookmark&quot;</li></ol></p>
<?php
}
else if ($b_type == 2 && $b_platform == 1){
?>
	<p><b>Internet Explorer on Windows</b>
	<ol><li>Right-click on the link below</li>
	<li>Select &quot;Add To Favorites...&quot;</li></ol></p>
<?php
}
else if ($b_type == 2 && $b_platform == 2){
?>
	<p><b>Internet Explorer on MacOS</b>
	<ol><li>Hold down the control key</li>
	<li>Click on the link below</li>
	<li>Select &quot;Add Link to Favorites&quot;</li></ol></p>
<?php
}
else if ($b_type == 1 && $b_platform == 2){
?>
	<p><b>Netscape on MacOS</b>
	<ol><li>Hold down the control key</li>
	<li>Click on the link below</li>
	<li>Select &quot;Add Bookmark for this Link&quot;</li></ol></p>
<?php
}
?>

<p align="center">
<A href="javascript:void(open('http://numlock/syncit/addbm.php?title='+escape(document.title)+'&url='+escape(location.href),'SyncIT','height=350,width=400,location=no,scrollbars=no,menubar=no,toolbar=no,directories=no,resizable=yes'));"><big><b>Add to SyncIT</b></big></a>
</p>
<table border='0'>
 <tr><td valign="top" align="right"><b>Netscape on Windows</b></td>
     <td><ol><li>Right-click on the link above</li>
             <li>Select &quot;Add Bookmark&quot;</li></ol></td></tr>
 <tr><td valign="top" align="right"><b>Internet Explorer on Windows</b></td>
     <td><ol><li>Right-click on the link above</li>
             <li>Select &quot;Add To Favorites...&quot;</li></ol></td></tr>
 <tr><td valign="top" align="right"><b>Internet Explorer on MacOS</b></td>
     <td><ol><li>Hold down the control key</li>
             <li>Click on the link above</li>
             <li>Select &quot;Add Link to Favorites&quot;</li></ol></td></tr>
 <tr><td valign="top" align="right"><b>Netscape on MacOS</b></td>
     <td><ol><li>Hold down the control key</li>
             <li>Click on the link above</li>
             <li>Select &quot;Add Bookmark for this Link&quot;</li></ol></td></tr>
</table>
<p>
For convenient access you might want to move the bookmark to your Netscape personal toolbar folder, or store it directly in your IE Links folder.
</p>
<p>
Browse to a site you would like to bookmark and select the link "Add to SyncIT". A popup window will appear (you will need to login the first time it pops up) where you can select the folder for the new bookmark.
</p>
<p>
When you return to your own computer all the new sites will already be in your bookmark list.</p>
</p>
<!-- * -->
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

