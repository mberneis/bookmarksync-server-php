<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#purchase.php
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

$ID = intval($_SESSION['payid']);
if ($ID == 0)
	exit();

$tmpname = tempnam("/tmp","foo");
$strtemp = basename($tmpname);
$seed = substr($strtemp,strlen($strtemp)-(strlen($strtemp)-3));
$strtemp = basename($tmpname);
$seed .= substr($strtemp,strlen($strtemp)-(strlen($strtemp)-3));

$_SESSION['seed'] = $seed;
$pc_license = ($_SESSION['pc_license'] != "");
$mac_license = ($_SESSION['mac_license'] != "");

// 1 = $35: First License
// 2 = $15: Additional License
// 3 = $50: Both Licenses
$pcarg = (request("pc") == 1);
$macarg = (request("mac") == 1);

$sale = 0;
$url = "";
if (($pcarg && !($mac_license)) || ($macarg && !($pc_license)))
	$sale = 1;
else
	$sale = 2;

if ($pcarg && $macarg)
	$sale = 3;

switch ($sale){
  case 1:
    $url="1/Single_license";
    break;
  case 2:
    $url="2/Additional_license";
    break;
  case 3:
    $url="3/Combo_license";
    break;
}

if ($pcarg && !$macarg)
	$url .= "_PC";

if (!$pcarg && $macarg)
	$url .= "_MacOS";

if ($pcarg && $macarg)
	$url .= "_PC,MacOS";

$x = 0;
if ($pcarg)
	$x += 1;

if ($macarg)
	$x += 2;

header("Location: http://www.clickbank.net/sell.cgi?link=syncit/" . $url . "&x=" . $x . "&s=" . $sale . "&seed=" . $seed . "&pid=" . syncit_ncrypt($ID));
?>
