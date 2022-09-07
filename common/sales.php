<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#sales.php
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
include '../inc/db.php';

$email = request("email");
$_SESSION['popup'] = "true";
$expired = (request("expired") != "");

if (!db_connect())
	die();

if ($email != ""){
	$res = mysql_query("select personid from person where email='" . $email . "'");
	$data = mysql_fetch_assoc($res);
	if (!$data)
		$ID = 0;
	else
		$ID = $data["personid"];
}
else
  $ID = GetID();


if ($ID == 0)
	myredirect("login.php?refer=sales.php");


$GLOBALS['mainmenu'] = "PURCHASE";
$GLOBALS['submenu'] = "";

$res = mysql_query("select name,token,pc_license,mac_license from person where personid=" . $ID);
$data = mysql_fetch_assoc($res);
$token = $data["token"];
$pc_license = $data["pc_license"];
$mac_license = $data["mac_license"];
$_SESSION['mac_license'] = $mac_license;
$_SESSION['pc_license'] = $pc_license;
$name = $data["name"];
$_SESSION['payid'] = $ID;
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
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><a href="../news/"><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt="QuickSync News"></a><a href="../express/"><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt="SyncIT Express"></a></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_registration.gif" width="503" height="37" alt="SyncIT Lifetime Subscription"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top"><blockquote>
            <br><h2>License SyncIT Client</h2>
            
            <p><b><? echo $name; ?>, you have synchronized your bookmarks <? echo $token; ?> times since you registered.</b></p>
            <p>
<?php
if ($expired != ""){
?>
	<p>Your trial account allows 20 free synchronizations.</p>
	<p>To continue using our service please purchase one of the clients below:</p>
<?php
} 

if (!isset($pc_license)){
	if (!isset($mac_license)){
		echo "<li><a href='purchase.php?pc=1'><b>Purchase PC License for $50</a></b></li>";
		$pc_price="50.00";
	}
	else {
		echo "<li><a href='purchase.php?pc=1'><b>Purchase additional PC License for $25</a></b></li>";
		$pc_price="25.00";
	}
}
else
	echo "<li><b>PC License purchased at " . $pc_license . "</li>";


if (!isset($mac_license)){
	if (!isset($pc_license)){
		echo "<li><a href='purchase.php?mac=1'><b>Purchase MacOS License for $50</a></b></li>";
		$mac_price="50.00";
	}
	else {
		echo "<li><a href='purchase.php?mac=1'><b>Purchase additional MacOS License for $25</a></b></li>";
		$mac_price="25.00";
	}
}
else
	echo "<li>MacOS License purchased at " . $mac_license . "</li>";


echo "</ul><p><font color=#333399 size=+2>These licenses do not expire!</font></p>";

if ($expired == "true")
	echo "<hr size=1>If you like to remove your account please go <a href='removeuser.php'>here </a>";
?>
	</p><p><b><a href="../download/default.php">Download the latest client software</a></b> 
	</p>
	<p>We cover Visa, Mastercard, American Express, Discover, Eurocard, and Visa-Debit, MasterCard-Debit, and Novus cards</p>
	</blockquote>
	<hr size=2 noshade color="#000099">
	<H3>Alternate Payment Methods</H3>
<!-- Begin PayPal Logo -->
<table border=0 width="100%"><tr><td>
<?php
if (!isset($pc_license)){
?>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">PC License $<?   echo $pc_price; ?><br><br>
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="paypal@syncit.com">
	<input type="hidden" name="item_name" value="PC License">
	<input type="hidden" name="item_number" value="1|<?   echo $ID; ?>">
	<input type="hidden" name="amount" value="<?   echo $pc_price; ?>">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="return" value="http://www.bookmarksync.com/common/paypal.php">
	<input type="image" src="http://images.paypal.com/images/x-click-but01.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
	</form>
<?php
}
?>
</td><td>
<?php
if (!isset($mac_license)){
?>	
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">Mac License $<?   echo $mac_price; ?><br><br>
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="business" value="paypal@syncit.com">
	<input type="hidden" name="item_name" value="Mac License">
	<input type="hidden" name="item_number" value="2|<?   echo $ID; ?>">
	<input type="hidden" name="amount" value="<?   echo $mac_price; ?>">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="return" value="http://www.bookmarksync.com/common/paypal.php">
	<input type="image" src="http://images.paypal.com/images/x-click-but01.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
	</form>
<?php
}
?>
</td></tr></table>
<!-- End PayPal Logo -->				
<pre></b>
If you can not pay with the above options see below:

If you have a US bank account you can send a check to

  SyncIt.com
  315 7th Avenue
  Suite 21-D
  New York, NY 10001

If you can not send a US check you might try a bank transfer:

  Rounting ABA# 021 000 021
  Account# 4555-0125-8865
  Account Holder: SyncIt.com.
  Bank: Chase Manhattan Bank
  305 7th Avenue
  New York, NY 10001
  USA
 
In any case please don't forget to note the email address the license 
should be registered for as well as the type of license</pre>						
<hr size=2 noshade color="#000099">
			<p><b><a href="presales.php#faq">More questions? Read the FAQ at our resale page</a></b></p>
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

