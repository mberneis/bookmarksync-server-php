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

<?
session_name("syncitmain");
session_start();
include 'session_vars.php';
include 'inc/db.php';

$ID = $_SESSION['ID'];
$name = $_SESSION['name'];

if (!db_connect())
	die();

if (stristr($_SERVER['HTTP_ACCEPT'],"text/vnd.wap.wml")){

	if (stristr($_SERVER['HTTP_ACCEPT'],"text/x-hdml")){

		header("Content-type: text/x-hdml");
		echo "<HDML VERSION='3.0' PUBLIC='TRUE' MARKABLE='TRUE' Title='SyncIT.com Mobile'>";
		echo "<ACTION TYPE=ACCEPT TASK=GO LABEL=Enter DEST='/wap/mainxml.php'><DISPLAY>";
		echo "<br><CENTER><IMG SRC=/wap/syncit.bmp ALT='SyncIT.com Inc.'><BR><br><CENTER>www.SyncIT.com<br>";
		if ($name != "")
			echo "<center>Welcome " . $name;
		echo "</DISPLAY></HDML>";
	}
	else {
		header("Content-type: text/vnd.wap.wml");
		echo "<?xml version='1.0'?>";
		echo "<!DOCTYPE wml PUBLIC '-//WAPFORUM//DTD WML 1.1//EN' 'http://www.wapforum.org/DTD/wml_1.1.xml'>";
		echo "<wml><head><meta http-equiv='Cache-Control' content='max-age=0'/></head>";
		echo "<card id='intro' ontimer='/wap/mainxml.php'  newcontext='true'><timer name='key' value='25'/>";
		echo "<p align='center'><img src='/wap/syncit.wbmp' alt='SyncIT.com' />";
		if ($name != "")
			echo "<br/>Welcome " . $name . "<br/></p></card></wml>";
	} 
}

else {

$partner_id = "";
if (isset($_GET['sp'])){
	$partner_id = $_GET['sp'];
	if ($partner_id == "")
		$partner_id = $_SESSION['partner_id'];
	else
		$_SESSION['partner_id'] = $partner_id;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<!-- Welcome to our bookmark management software site -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<title>bookmark management software - A SyncIT Service</title>
<meta http-equiv="Content-Language" content="en-us">
<meta NAME="author" CONTENT="bookmark management software - Michael Berneis, Terence Way">
<meta NAME="publisher" CONTENT="SyncIT.com Inc">
<meta NAME="copyright" CONTENT="(c) 1998-2000 SyncIt.com  Inc, New York, support@bookmarksync.com">
<meta NAME="keywords" CONTENT="bookmark management software">
<meta NAME="description" CONTENT="bookmark management software: BookmarkSync is software that keeps your browser bookmarks synchronized across multiple computers and browsers.  A download tool for explorer and netscape browsers running on windows95, windows98, windowsnt, mac on OS8.5, apple. This tool lets you upgrade from oneview or extend visto briefcase">
<meta NAME="page-topic" CONTENT="bookmark management software">
<meta NAME="page-type" CONTENT="Software Download">
<meta NAME="audience" CONTENT="All">
<meta NAME="MS.LOCALE" CONTENT="US">
<meta NAME="Content-Language" CONTENT="english">
<meta NAME="ABSTRACT" content="bookmark management software : A download tool for IE Explorer and netscape browsers running on windows95, windows98, windowsnt, mac on OS8.5, apple.  A SyncIT product: BookmarkSync is software that keeps your browser bookmarks synchronized across multiple computers and browsers.  This tool lets you upgrade from oneview or extend visto briefcase">
<meta NAME="Classification" content="bookmark management software : This tool lets you upgrade from oneview or extend visto briefcase.  A SyncIT product: BookmarkSync at http://www.bookmarksync.com is software that keeps your browser bookmarks synchronized across multiple computers and browsers.  A download tool for explorer and netscape browsers running on windows95, windows98, windowsnt, mac on OS8.5, apple. ">
<meta http-equiv="Publication_Date" CONTENT="may 1999">
<meta http-equiv="Custodian" content="SyncIt.com, USA">
<meta http-equiv="Custodian Contact" content="Mike Berneis, 917-4060243, webmaster@bookmarksync.com">
<meta http-equiv="Custodian Contact Position" content="CEO, SyncIt.com">
<meta NAME="ROBOTS" CONTENT="INDEX,FOLLOW">
<meta NAME="DC.Title" CONTENT="bookmark management software : BookmarkSync is software that keeps your browser bookmarks synchronized across multiple computers and browsers.  A download tool for explorer and netscape browsers running on windows95, windows98, windowsnt, mac on OS8.5, apple.  This tool lets you upgrade from oneview or extend visto briefcase">
<meta NAME="DC.Creator" CONTENT="Michael Berneis, Terence Way">
<meta NAME="DC.Subject" CONTENT="bookmark management software : Synchronization of bookmarks across the Internet">
<meta NAME="DC.Description" CONTENT="bookmark management software : A download tool for explorer and netscape browsers running on windows95, windows98, windowsnt, mac on OS8.5, apple.  A SyncIT product: BookmarkSync is software that keeps your browser bookmarks synchronized across multiple computers and browsers.  This tool lets you upgrade from oneview or extend visto briefcase">
<meta NAME="DC.Publisher" CONTENT="SyncIT.com">
<meta NAME="rating" CONTENT="General">
<link rel="Start" href="default.php">
<link REV="made" href="mailto:support@bookmarksync.com">
<link rel="StyleSheet" href="common/syncit.css" type="text/css">
<style type="text/css"></style>
</head>
<script language="javascript">
<!--
function showhelp(topic) {
	if (topic == 0) {
		helpurl=''; 
	}
	if (topic == 1) {
		helpurl='html/frequently_asked_questions.htm'; 
	}
	var helpwnd = window.open ("help-2.0/default.php?start=" + helpurl,"help","menubar=0,status=1,scrollbars=1,resizable=1");
	helpwnd.focus();
}
-->
</script>

<body text="#000000" link="#3333FF" vlink="#3333FF" bgcolor="#FFFFFF">
<!-- This page is about bookmark management software --> 

  <table width="628"  align="center"border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="5"><img src="images/introbanner.gif" width="627" height="55" usemap="#Map" border="0" alt="BookmarkSync"><map name="Map"><area shape="rect" coords="117,3,237,16" alt="BookmarkSync" href="bms/default.php"><area shape="rect" coords="239,2,384,16" Alt="Collections" href="collections/default.php"></td>
    </tr>
<?php
if ($ID == 0){
?>
  </table><table width="628"  align="center"border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="4">&nbsp;</td>
      <td colspan="3" align="right"><a href="common/login.php#register"><img src="images/introregister.gif" width="120" height="25" vspace="5" border="0" alt="Register Now!"></a></td>
    </tr>
<?php
}
else {
?>
    <tr> 
      <td colspan="7">&nbsp;</td>
    </tr>
<?php
}
?>
  </table><table width="628"  align="center"border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="7"><img src="images/tblbanner1.gif" width="628" height="18" alt="Search all Bookmarks"></td>
    </tr>

<?php
$cookiename = "";
$cookievalid = "";

if (isset($_COOKIE['name']))
	$cookiename = $_COOKIE['name'];
if (isset($_COOKIE['email']) && isset($_COOKIE['md5']))
	$cookievalid = ($_COOKIE['email'] != "" & $_COOKIE['md5'] != "" & $cookiename != "");

if (isset($_GET['logout']) && $_GET['logout'] != "")
	$cookievalid = false;

if (($ID == 0 || $ID == "") && !$cookievalid){

?>
    <tr valign="top"> 
      <td width="2" background="images/tblleft.gif" bordercolor="#000000"><img src="images/tblleft.gif" width="2" height="2"></td>
      <form method="POST" action="collections/searchcol.php">
        <td width="194" bgcolor="#000066" align="center"> <img src="images/tpix.gif" width="189" height="1"> 
          <input type="text" name="searchcol" size="18" class="footer" xstyle="{width:180px;}">
        </td>
        <td width="40" bgcolor="#000066" valign="bottom"> <img src="images/tpix.gif" width="40" height="1"> 
          <input type="image" border="0" name="imageField" src="images/introok.gif" width="38" height="18" alt="OK">
        </td>
      </form>
      <form method="POST" action="common/login.php">
        <td width="1" background="images/tblcenter2.gif" bgcolor="#330033"><img src="images/tblcenter.gif" width="1" height="2"></td>
        <td width="348" bgcolor="#000066"> <img src="images/tpix.gif" width="343" height="1"> 
          <span class="menuw"> &nbsp;&nbsp;EMAIL</span> 
          <input type="text" style="{width:100px;}" name="email" size="14" class="footer">
          <span class="menuw">&nbsp;&nbsp;PASSWORD</span> 
          <input type="password" style="{width:100px;}" name="pass" size="8" class="footer">
        </td>
        <td width="40" bgcolor="#000066" valign="bottom"> <img src="images/tpix.gif" width="40" height="1"> 
          <input type="image" border="0" name="imageField2" src="images/introok.gif" width="38" height="18" alt="OK">
        </td>
        <td width="3" background="images/tblright.gif" bgcolor="#000000"><img src="images/tblright.gif" width="3" height="2"></td>
	  <input type="hidden" name="url" value="default.php">
      </form>
    </tr>
<?php
}
else {

if ($ID > 0){
	$num_bmarks = count_bookmarks($ID);
	$bmcnt = "<br>&nbsp;&nbsp;YOU HAVE " . $num_bmarks . " BOOKMARKS STORED.";
}
else {
	$_SESSION['name'] = $cookiename;
	$bmcnt = "<br>&nbsp;&nbsp;QUICK LOGIN TO YOUR BOOKMARKS";
}
?> 
    <tr valign="top"> 
      <td width="2" background="images/tblleft.gif" bordercolor="#000000"><img src="images/tblleft.gif" width="2" height="2"></td>
      <form method="POST" action="collections/searchcol.php">
        <td width="194" bgcolor="#000066" align="center"> <img src="images/tpix.gif" width="189" height="1"> 
          <input type="text" name="searchcol" size="20" class="footer" style="{width:180px;}">
        </td>
        <td width="40" bgcolor="#000066" valign="bottom"> <img src="images/tpix.gif" width="40" height="1"> 
          <input type="image" border="0" name="imageField" src="images/introok.gif" width="38" height="18" alt="OK">
        </td>
      </form>
        <td width="1" background="images/tblcenter2.gif" bgcolor="#330033"><img src="images/tblcenter.gif" width="1" height="2"></td>
        
      <td width="318" bgcolor="#000066"> <img src="images/tpix.gif" width="315" height="1"> 
        <span class="menuw">&nbsp;&nbsp;<font color="#FFCC00">WELCOME <?php echo $_SESSION['name']; ?></font><?php echo $bmcnt; ?></span> <a href="/tree/view.php"><img src="images/introviewnow.gif" width="100" height="18" border="0" alt="View Bookmarks Now"></a></td>
        
      <td width="70" bgcolor="#000066" valign="bottom"> <img src="images/tpix.gif" width="70" height="1"> 
        <a href="common/login.php?logout=true"><img src="images/intrologoff.gif" width="65" height="18" border="0" alt="Log Out"></a> 
      </td>
        <td width="3" background="images/tblright.gif" bgcolor="#000000"><img src="images/tblright.gif" width="3" height="2"></td>
    </tr>
    <?   } ?> 
    <tr> 
      <td colspan="7"><img src="images/tblbottom.gif" width="628" height="8"></td>
    </tr>
    <tr> 
      <td colspan="7">&nbsp;</td>
    </tr>
  </table>

<table width="628" align="center" border="0" cellspacing="0" cellpadding="0">
<tr><td>BookmarkSync is now being released under the GPL license and will be available
on sourceforge very soon.
</td>
</tr>
</table>

<table width="628"  align="center"border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
      <td colspan="3" class="footer" align="center">[ <a href="bms/default.php">BOOKMARKSYNC</a> | <a href="collections/default.php">COLLECTIONS</a> | <a href="download/default.php">DOWNLOAD</a> | <a href="common/profile.php">PROFILE</a> ] </td>
  </tr>
</table>

<p>&nbsp;</p><p><A HREF="http://search.yahoo.com/bin/search?p=bookmark+management+software"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/sitemap.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/bookmark_management/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/management_software/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/manager_software/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/bookmark_storage/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/unite_bookmarksets/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/organize_bookmarks/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/bookmark_manger/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/online_storage/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/access_bookmarks/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/convert_bookmarks/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/merge_bookmarks/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/synchronize_bookmarks/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/bookmarks/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/share_bookmarks/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/transfer_bookmarks/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.bookmark--manager.com/access/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.favorites-manager.com/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.favorites-manager.com/transfer_favorite_places/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.favorites-manager.com/convert_favorite/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.favorites-manager.com/unite_favorites/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.favorites-manager.com/organize_favorites/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
<A HREF="http://www.favorites-manager.com/merge_favorites/index.html"><IMG SRC="http://www.bookmark--manager.comimages/dotclear.gif" WIDTH="1" HEIGHT="1" BORDER="0" alt="bookmark management software"></A> 
</p></body>
<!-- Thank you for visiting our bookmark management software site -->
</html><? 
} 


if ($_SESSION['popup'] == "")
{
?>
<script>
self.name='syncitmain';
if (document.cookie == '') alert('You must at least enable temporary cookies to use this site!');
</script>
<?php
}
?>
