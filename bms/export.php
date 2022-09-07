<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#export.php
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

$ID = GetID();
if ($ID == 0)
	myredirect("../common/login.php?refer=../bms/export.php");

$GLOBALS['mainmenu'] = "UTILITIES";
$GLOBALS['submenu'] = "EXPORT";

if (!db_connect())
	die();

$res = mysql_query("select personid,name,email,pass from person where personid=" . $ID);
if (!$res)
	dberror("Cannot retrieve data 1 in export.php");
if (mysql_num_rows($res) == 0)
	myredir("../inc/login.php?refer=../bms/export.php");
$data = mysql_fetch_assoc($res);
$fishpw = MD5Pwd($data['email'],$data['pass']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync - Export Bookmarks</title>
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
            <h2>Export Bookmarks</h2>
            <p><br>
<form method="POST" action="/client/export.dll?">
  <h3>
  <input type="hidden" name="email" value="<?php echo $data["email"]; ?>">
  <input type="hidden" name="pass" value="<?php echo $data["pass"]; ?>">Select the format
  in which to export your bookmarks</h3>
  <table border="0">
    <tr>
      <td valign="top"><b>

  <input type="radio" name="format" value="netscape" checked></b></td>
      <td><b>Netscape<br>
        </b>This commonly used format is used by the <b>Netscape</b>
        Navigator Browser.&nbsp;<br>
        in a file called <i>bookmark.htm</i>.</td>
    </tr>
    <tr>
      <td valign="top"><b>
  <input type="radio" name="format" value="opera"></b></td>
      <td><b>Opera<br>
        </b>This format is used by the popular <a href="http://www.opera.com" target="_blank"><b>Opera
        </b></a>browser.</td>
    </tr>
    <tr>
      <td valign="top"><b>
  <input type="radio" name="format" value="xbel"></b></td>
      <td><b>XBEL<br>
        </b>This XML based format was designed by the <b><a href="http://www.python.org/topics/xml/xbel/" target="_blank">Python
        </a></b>group and extended by <b>SyncIT.com</b>.</td>
    </tr>
  </table>
  <p><b>&nbsp;</b><input border="0" src="../images/btnok.gif" name="I1" type="image" width="62" height="16" alt="OK"></p>
</form>
          <td width="10" valign="top">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
</html>
