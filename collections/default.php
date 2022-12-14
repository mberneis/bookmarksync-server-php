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
include '../inc/asp.php';
include '../inc/db.php';

$mainmenu="HOME";
$submenu="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync Collections</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#3333FF" vlink="#990099" alink="#CC0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="111" valign="top">
<?php include '../inc/cmenu.php'; ?>
<!-- <p><a href="../inc/partner.php"><img border="0" src="../images/btnpartner.gif" width="116" height="31" alt="Partner with SyncIT"></a> -->
    </td>
    <td width="511" valign="top">
      <table width="511" border="0" cellspacing="0" cellpadding="0">
<?php include '../inc/chead.php'; ?>
          <td width="10">&nbsp;</td>
          <td width="491" valign="top">
            <p><map name="FPMap0">
            <area href="searchcol.php" alt="Search for collections" shape="rect" coords="350, 154, 450, 226">
            <area href="publication.php" alt="Your published collections" shape="rect" coords="16, 147, 107, 236">
            <area href="publication.php" alt="Invite friends to a collection" shape="rect" coords="117, 185, 216, 263">
            <area href="publication.php" alt="Get the word out!" shape="rect" coords="332, 47, 488, 148">
            <area href="showcategory.php" alt="Subscribe to a collection" shape="rect" coords="223, 184, 335, 259">
            <area href="addpub.php" alt="Create collections of bookmarks" shape="rect" coords="144, 3, 327, 130"></map><img src="../images/coll_illustration.gif" width="491" height="264" alt="Share your collections of favorite sites or bookmarks on any subject with your friends, colleagues or the entire World Wide Web." usemap="#FPMap0" border="0"><br>
            </p>
            <table width="491" border="0" cellspacing="1" cellpadding="2">
              <tr>
                <td align="right" width="100" valign="top">
                  <div class="collabel1"><a href="addpub.php">Create</a> </div>
                </td>
                <td width="191"> your own collection and add it&nbsp; to the MySync community. </td>
                <td nowrap valign="top" align="center" width="200" rowspan="5">
                  <div class="collabel2">&nbsp;CHECK&nbsp;OUT&nbsp;MySync&nbsp;Examples:&nbsp;</div>
                  <p><a href="../tree/cview.php?ref=SEARCH&amp;pid=141A17"><b><br>
                  Web&nbsp;Development</b></a><b><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14141D16">Child&nbsp;Care</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161D16191D191A">Travel</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161C1D1F1D1F1A">College</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161C1F181F1C20">Finance
                  (UK)</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14141E1C1C181920">Magic&nbsp;&amp;&nbsp;Illusions</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=181419">Linux</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161C1C191C1F22">Firewire</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161D16191D221A">Real
                  Estate</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161D16191C211C">134
                  Health Sites</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161D16191D1E1E">Job
                  </a>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161D16191D1E1E">Resources</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161D16191D1A22">Parenting</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161D16191E2222">TV
                  and Radio</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161D16191F1E1C">Homework
                  Help</a><br>
                  <a href="../tree/cview.php?ref=BROWSE&amp;pid=14161D18191E1F1A">Free Sheet Music</a><br>
                    </b> </p>
                </td>
              </tr>
              <tr>
                <td align="right" width="100" valign="top">
                  <div class="collabel1"><a href="publication.php">Invite</a> </div>
                </td>
                <td width="191">friends, family, colleagues or all <b>SyncIT </b>members
                  to subscribe.</td>
              </tr>
              <tr>
                <td align="right" width="100" valign="top">
                  <div class="collabel1"><a href="searchcol.php">Search</a> </div>
                </td>
                <td width="191">other members' <b>MySync</b> links by subject or
                  area of interest.<br>
                  <b>MySync</b> members guide you to the best of the Internet!<br>
                </td>
              </tr>
              <tr>
                <td align="right" width="100" valign="top">
                  <div class="collabel1"><a href="showcategory.php">Subscribe</a> </div>
                </td>
                <td width="191" valign="top">to other <b>MySync</b> Collections</td>
              </tr>
              <tr>
                <td align="right" width="100" valign="top">
                  <div class="collabel1"><a href="publication.php">Get The <br>
                    Word Out!</a> </div>
                </td>
                <td width="191" valign="top">View your published collections and encourage others to sign up for your published bookmarks</td>
              </tr>
              <tr>
                <td align="right" width="100" valign="top">
                  <img border="0" src="../images/tpix.gif" width="100" height="5" alt>
                </td>
                <td width="191" valign="top"></td>
              </tr>
              <tr>
                <td colspan="3"><img src="../images/tpix.gif" width="100" height="5" alt></td>
              </tr>
            </table>
            </td>
          <td width="10" valign="top">&nbsp;</td>
      </table>
    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>

</html>

