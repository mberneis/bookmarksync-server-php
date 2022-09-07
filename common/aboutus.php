<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#aboutus.php
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

$mainmenu="ABOUT US";
$submenu="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>SyncIT Company Background</title>
<link rel="StyleSheet" href="syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#660066" vlink="#990000" alink="#CC0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<?php include '../inc/bmenu.php'; ?>
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt=""><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt=""></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_companybg.gif" width="503" height="37" alt="SyncIT Background"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br><h2>Company Background</h2>
            <p>
                       Located in New York City, SyncIT.com Inc. was founded in November
            1998 as a developer of Internet synchronization technologies
            designed to enable free worldwide secure access to all types of
            personal and business documents via the Web.  The company's vision
            is the global uniform access of personal data with the ability to
            share parts of it in a secure and controlled fashion.&nbsp;
</p>
            <p>
            SyncIT's flagship product, BookmarkSync, is the first Internet
            bookmark synchronization service compatible with AOL's user
            interface.  BookmarkSync unobtrusively merges bookmarks and
            favorites from any personal computer across multiple Web browsers.
            It then provides intelligent synchronization and distribution of the
            merged bookmarks back to the original computers and browsers from
            which the data was retrieved.  A copy of the updated merged
            bookmarks is automatically stored on the SyncIT's Web server for
            secure remote access when traveling.&nbsp;
</p>
            <p>
            Other features of the BookmarkSync service include remote,
            real-time updates and edits to all shared bookmarks registered with
            SyncIT.com and a duplicate link remover and <q>dead-link</q> finder.
            BookmarkSync also delivers real-time news and weather -
            provided by ISyndicate (www.isyndicate.com) - from more than 400
            trusted sources such as Reuters NewMedia, Time, Salon, Fortune,
            CNET, The Associated Press, Rolling Stone and CBS Sportsline.  In
            addition, BookmarkSync allows users to <q>publish</q> portions of their
            bookmarks for public viewing, or set up remote shared access
            privileges just for family, friends, and co-workers.&nbsp;
</p>
            <p>
            Even when BookmarkSync registrants are not connected to the
            Internet, SyncIT's cache technology allows customers to access their
            documents and make changes without the hassle of manually updating
            the modified document information to global storage.&nbsp;
</p>
            <p>
            SyncIT plans to offer additional personal and corporate services
            including OS integrated virtual storage and synchronization
            services, disaster recovery, document management and version
            retrieval, and certified document delivery.&nbsp;
</p>
<p>
            For information about SyncIT or its services, please send E-mail to
                       <a href="mailto:press@syncit.com">press@syncit.com</a>
</p>
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

