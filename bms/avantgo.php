<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#avantgo.php
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

$GLOBALS['mainmenu'] = "UTILITIES";
$GLOBALS['submenu'] = "AVANTGO";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<?php
if ($_SESSION['ID'] > 0)
	$extra_cookie = "&amp;set_cookie=initid%3d" . syncit_ncrypt($_SESSION['ID']) . "%3B";
?>
<head>
<title>BookmarkSync</title>
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
            <td width="491" valign="top"> <!-- ******************************************************************************************************************************************** --> 
              <br> 
              <h2>AvantGO Channel </h2>
              <p>Add links to your Bookmarkset on the Go.</p>
              <p>Through SyncIT's partnership with <a href="http://www.avantgo.com" target="_blank">AvantGo</a> 
                you are able to enter bookmarks while on the road. Once you synchronize 
                your palmpilot these bookmarks will be added to all your computers 
                where syncit is installed.</p>
              <p align="center"><b> <a href="https://avantgo.com/channels/detail.html?cha_id=1840&amp;cat_id=&amp;type=search_result&amp;data=syncit<? echo $extra_cookie; ?>" target="_blank"><img src="../images/avantgosubscribe.gif" width="110" height="31" border="0"></a> 
                </b></p>
              <p><!-- ******************************************************************************************************************************************** --> 
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

