<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#syncitshuttle.php
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

$GLOBALS['mainmenu'] = "TELL A FRIEND";
$GLOBALS['submenu'] = "SHUTTLE";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>SyncIT Shuttle</title>
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
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><a href="../news/"><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt=""><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt=""></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_shuttle.gif" width="503" height="37" alt="SyncIT Shuttle"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top" height="5">
            <br>
            <h2>How to build your shuttle</h2>
            <ul class="shuttle">
            <li>Download the color or grayscale version<br>
              (Right-click on the image and select &quot;Save as...&quot;<br>
              <br>
              <a href="../images/syncit_shuttle_color.gif"><img border="0" src="../images/shuttleiconc.gif" width="100" height="140"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="../images/syncit_shuttle_bw.gif"><img border="0" src="../images/shuttleiconb.gif" width="100" height="140"></a><br>
            <li>Print and cut out<br>
            <li>Fold along line [1] up&nbsp;<br>
              (colored sides touch each other)<br>
            <li>Fold [2] and [3] up<br>
            <li>Fold [4] and [5] down<br>
            <li>Fold [6] and [7] down<br>
              <li><img border="0" src="../images/shuttle1.gif" width="159" height="76" align="right" vspace="5">
                Your airplane should look now like this:<br clear=all>
              <li><img border="0" src="../images/shuttle2.gif" width="152" height="75" align="right" vspace="5">
                Cut along green line [8] and fold tail inside out:<br clear=all>
            <li><img border="0" src="../images/shuttle3.gif" width="82" height="31" align="right">
		Use a paperclip at the nose to stabilize.<br clear=all>
            </ul>
            <h3>You're done! - Have fun!
            </h3>
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

