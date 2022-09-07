<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#press.php
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

$GLOBALS['mainmenu'] = "ABOUT US";
$GLOBALS['submenu'] = "PRESS";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>SyncIT Press Releases</title>
<link rel="StyleSheet" href="syncit.css" type="text/css">
</head>
<body bgcolor="#ffffff" text="#000000" link="#3300cc" vlink="#990066" alink="#cc0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<?php include '../inc/bmenu.php'; ?>
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" bgcolor="#6633ff" width="503"><A href="../bms/default.php"><IMG alt=BookmarkSync border=0 height=18 src="../images/horbtn_bmup.gif" width=120></A><A href="../collections/default.php"><IMG alt="MySync Collections" border=0 height=18 src="../images/horbtn_collup.gif" width=147 ></A><IMG alt="" border=0 height=18 src="../images/horbtn_newsup.gif" width=124 ><IMG alt="" border=0 height=18 src="../images/horbtn_exup.gif" width=112 ></td>
          <td rowspan="2" width="10" valign="top"><IMG alt="" height=55 src="../images/rightbar.gif" width=10></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><IMG alt="SyncIT Press" height=37 src="../images/heading_press.gif" width=503 ></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br><h2>Press Releases</h2><b>
            
            <P>10/17/00<br>
            <a href="http://www.prnewswire.com/cgi-bin/stories.pl?ACCT=104&STORY=/www/story/10-17-2000/0001339915" target="_blank">Bookmarks Go Mobile with Alliance of SyncIT.com and AvantGo</a></P>
            <P>
            
            <P>4/26/00<br>
            <a href="http://www.prnewswire.com/cgi-bin/stories.pl?ACCT=104&amp;STORY=/www/story/04-26-2000/0001201463" target="_blank">SyncIT.com Gets Your Bookmarks in Sync</a></P>
            
            <p>4/24/00<br>
            <a href="http://www.prnewswire.com/cgi-bin/stories.pl?ACCT=104&amp;STORY=/www/story/04-24-2000/0001198777" target="_blank">SyncIT.com and Jurisline.com Make an Open-and-Shut Case For Bookmark Management </a><br>
            <br></P>
            
            <p>10/14/99<br>
            <a href="http://www.prnewswire.com/cgi-bin/stories.pl?ACCT=104&amp;STORY=/www/story/10-14-1999/0001044347" target="_blank">BookmarkSync.com Announces 'Most Bookmarked' Sites Awards</a><br>
            <br></P>
            
            <p>9/8/99<br>
            <a href="http://www.prnewswire.com/cgi-bin/stories.pl?ACCT=104&amp;STORY=/www/story/09-08-1999/0001017118" target="_blank">SyncIT.com First to Offer AOL Compatible Free Bookmark Synchronization and
            Shared Access Services</a><br></P>
            
            <hr noshade size=1 color=#330099>
            <H2>WEB Reviews</H2><B>
            <p><A href="http://www.accountingweb.com/cgi-bin/item.cgi?id=14158&d=101&h=0&f=0" target=_blank>AccountingWeb</A><BR>
            <A href="http://www.rocketdownload.com/details/inte/bkmarksync.htm" target=_blank>Rocket Download</A><BR>
            <A href="http://tucows.syracuse.net/preview/2847.html" target=_blank>Tucows</A><br>
            <a href="http://www.zdnet.com/downloads/stories/info/0,,000ZDR,.html" target=_blank>ZDNet</a><br>
            <a href="http://www.smartcomputing.com/editorial/article.php?article=articles/2000/s1110/01s10/01s10.php&guid=c9g87iji" target=_blank>Smart Computing</a><br>
            </p></b>
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

