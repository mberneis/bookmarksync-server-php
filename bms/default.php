<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#default.php
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

$GLOBALS['mainmenu'] = "HOME";
$GLOBALS['submenu'] = "";

if (!db_connect())
	die();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<title>SyncIT BookmarkSync syncs favorites across computers for easy access</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#000080" vlink="#000080" alink="#000080">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<?php include '../inc/ymenu.php'; ?>
<a href="#start"><img src="../images/arrowmove.gif" border="0" WIDTH="117" HEIGHT="97">
</a>
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
<?php include '../inc/yhead.php'; ?>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <table width="491" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="330">
                  <a href="../tree/view.php"><img border="0" alt="View your Bookmarks now" src="../images/bmillustration.gif" WIDTH="330" HEIGHT="370"></a>
                  </td>
                <td width="161" valign="top" align="right">
				<br><form method="GET" action="searchbm.php">
              <span class="menub"> &nbsp;Search your Bookmarks</span>
              <input type="text" name="searchbm" size="10" style="width:150px" value></form>
<?php
if ($_SESSION['ID'] == 0){
	echo "<h4>Your bookmarks, favorites and favorite places at your fingertips from anywhere in the world.&nbsp;</h4>";
	echo "<h4>Great for home computer users, travelers, telecommuters, teachers &amp; students, Internet lovers everywhere!</h4>";
	echo "<h4>Always up to date - no importing or exporting files.&nbsp; Let us do the work while you enjoy the Internet!</h4>";
}
else {

	$bmcnt = count_bookmarks($_SESSION['ID']);
	
	$res = mysql_query("Select date_format(lastchanged,'%d-%m-%Y') as last_changed from person where personid = " . $_SESSION['ID']);
	if (!$res)
		dberror("Cannot retrieve last change info!");
	$data = mysql_fetch_assoc($res);

	$lastchanged = $data["last_changed"];
	
	echo "<h4>Welcome " . $_SESSION['name'] . "</h4><p>You currently have <b>" . $bmcnt . "</b> bookmark entries</p>";
	
	if ($lastchanged != "")
		echo "<p>The last change was at <b>" . $lastchanged . "</b></p>";
}
?>
                </td>
              </tr>
            </table>
            <h3><a href="../download/" name="start"><img src="../images/download.gif" border="0" align="right" alt="Download" WIDTH="180" HEIGHT="65">It's
              Easy to Use BookmarkSync!</a></h3>
            <p><b>Getting Started</b>
            <p>Download and install BookmarkSync software,&nbsp;<br>
 a <img border="0" src="../images/trayicon.gif" WIDTH="16" HEIGHT="12"> will appear in the
				lower right hand corner of your screen.</p>
            <p>Click <img border="0" src="../images/trayicon.gif" WIDTH="16" HEIGHT="12"> to view your bookmarks and favorites.&nbsp;<br>
Click your bookmarks &amp; connect to your favorite web sites.</p>
<p>Adding or removing bookmarks is a snap - just add or delete them on
your browser. No files to import or export - we'll keep track of changes for you.</p>
<p><i>When you're traveling or using a new computer or browser</i>, you can visit
<a href="http://www.bookmarksync.com/">www.bookmarksync.com</a>, and log in with
your name and password to be connected to your bookmarks and favorites.</p>
            <p>It's that easy!
            </p>
          </td>
          <td width="10" valign="top">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
<?php include '../inc/footer.php'; ?>
</body>

</html>














