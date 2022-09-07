<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#receipt.php
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

restricted("../common/receipt.php");

if (!db_connect())
	die();

$res = mysql_query("select name,address1,address2,city,state,zip,country,pc_license,mac_license from person where personid=" . $_SESSION['ID']);
$data = mysql_fetch_assoc($res);

$name = $data["name"];
if (isset($data["address1"]))
	$name .= "<br>" . $data["address1"];

if (isset($data["address2"]))
	$name .= "<br>" . $data["address2"];

if (isset($data["city"]))
	$name .= "<br>" . $data["city"];

$temp = $data["state"] . " " . $data["zip"];
if ($temp != " ")
	$name .= "<br>" . $temp;

if (isset($data["country"]))
	$name .= "<br>" . $data["country"];


$pc_license = $data["pc_license"];
$mac_license = $data["mac_license"];
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>SyncIt Invoice/Receipt</title>
</head>

<body bgcolor="#FFFFFF" text="#000000">
<basefont face="Arial,Helvetica">
<p align="right"><b>SyncIt.com<br>
</b>315 7th Avenue<br>
Suite 21-D<br>
New York, NY 10001</p>
<h1>Invoice/Receipt</h1>
<p><b>To</b>:<br> <? echo $name; ?></p>
<p><b>Ordered services for User #<? echo syncit_ncrypt($_SESSION['ID']); ?>:</b></p>
<table border="1" width="100%" cellspacing="0" bordercolorlight="#000000" bordercolordark="#000000" bordercolor="#000000" cellpadding="3">
<tr><td><b>License</b></td><td><b>Amount</b></td><td><b>Purchased</b></td></tr>
<?php
$pc_price = 50;
$mac_price = 50;

if (!isset($mac_license) && isset($pc_license)){
?>
	<tr>
	<td width="33%" bordercolor="#000000" bordercolorlight="#000000" bordercolordark="#000000">PC
	License&nbsp;&nbsp;&nbsp; </td>
	<td width="33%">US$&nbsp; <?   echo $pc_price; ?></td>
	<td width="34%"><?   echo $pc_license; ?></td>
	</tr>
<?php
} 

if (isset($mac_license) && !isset($pc_license)){
?>
	<tr>
	<td width="33%" bordercolor="#000000" bordercolorlight="#000000" bordercolordark="#000000">MAC
	License&nbsp;&nbsp;&nbsp; </td>
	<td width="33%">US$&nbsp; <?   echo $mac_price; ?></td>
	<td width="34%"><?   echo $mac_license; ?></td>
	</tr>
<?php
} 

if (isset($mac_license) && isset($pc_license)){
?>
	<tr>
	<td width="33%" bordercolor="#000000" bordercolorlight="#000000" bordercolordark="#000000">PC/MAC
	License&nbsp;&nbsp;&nbsp; </td>
	<td width="33%">US$&nbsp; <?   echo $pc_price; ?></td>
	<td width="34%"><?   echo $pc_license; ?></td>
	</tr>
<?php
}
?>
</table>
<p><b>Delivery of service</b>: online</p>
<p><b>Payment terms</b>: Payment received in full.</p>
<hr>
<p>Thank you for your business.</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>SyncIt.com Customer Service</i></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>

