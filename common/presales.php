<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#presales.php
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

header("Expires: -1");
$GLOBALS['mainmenu'] = "PURCHASE";
$GLOBALS['submenu'] = "";
$_SESSION['popup'] = true;
$expired = "";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>Purchase Client License</title>
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
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt="QuickSync News"><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt="SyncIT Express"></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_registration.gif" width="503" height="37" alt="SyncIT Lifetime Subscription"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br><h2>License SyncIT Client</h2>
            <? 
if (request("expired") != "")
  print "<h3><font color='red'>*** YOUR ACCOUNT HAS EXPIRED ***</font></h3>";

?>
            <p>
            In the five years since we launched BookmarkSync.com, we have built a solid 
user base, earned rave reviews, and even weathered the dotcom crash. 
Now, it is time to take our flagship product even further. 
BookmarkSync deserves more features, better support, no ads, and enhanced privacy. 
</p><p>
To deliver these features, however, we need to start charging a fee. 
</p><p>
Starting November 1, 2001, BookmarkSync will be available for a one-time fee 
of $50. Paid customers will receive the software and unlimited, ad-free 
access to our web services for life. 
</p>
<p>
And thank you for making us one of the most highly rated web services! 
            </p>
            <a name=faq>
            <center>
            <form action="http://www.bookmarksync.com/common/sales.php?<? echo $_GET; ?>"><input type=submit value="CLICK HERE TO PURCHASE LICENSE NOW" class="pbutton">
            <br><small>[You might have to log in again with your account information]</small></form></center>
            <hr size=1>
            <H2>FAQ</h2>
            <ul>
            <li><b>Do I need a separate license for each computer?</b><br>
            No. Your license is valid per account (bookmarkset) and OS family.<br>
            If you are using different operating systems (PC, Mac) against the same account, you can aquire an additional license for the other operating system at a 50% discount.
            <br>&nbsp;</li>
            <li> <b>What future developments and features can I expect with the licensed version?</b><br>
            Depending on the number of licenses we sell, we will allocate the funds for the following (listed by priority):<br>&nbsp;
            <ol>
            <li>Web Server and Database Hosting and Administration</li>
            <li>Customer Support and Product Maintanance</li>
            <li>Opera Browser Support</li>
            <li>Netscape6 and Mozilla Browser Support</li>
            <li>Development of MacOSX client</li>
            <li>Development of Linux client</li>
            <li>Marketing</li>
            </ol><br>
            </li>
            <!--
            <li> <b>What happens to my license if you guys go out of business?</b><br>
            In case we have to shut down our web services we will hand all code (plus database shema, client server-protocol etc.) over to the public domain at 
            <a target=_blank href="http://sourceforge.net">SourceForge (http://sourceforge.net)</a>. <br>            
            </li>
			-->
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

