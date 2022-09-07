<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#session_vars.php
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

//
// 25th feb 2003 - lauren
//
// we changed this in to a piece of executable code to be inserted into the asp.php file
// so that any entry point into the site will have the reqd session and global vars available
// hopefully it'll work and stop michael moaning at me :)-
//

// declare globals here
//$GLOBALS['app'] = "";
if (!isset($GLOBALS['SUBMEN'])){
	$GLOBALS['SUBMEN'] = false;
	$GLOBALS['MAINMENU'] = false;
	$GLOBALS['mainmenu'] = "";
	$GLOBALS['submenu'] = "";
}

// declare all session vars here and register them so its out of the way
if (!isset($_SESSION['name'])){
	$name = "";
	$pass = "";
	$email = "";
	$partner_id = "";
	$token = "";
	$license = "";
	$daysregistered = "";
	$popup = "";
	$ID = "";
	$partnerurl = "";
	$partnerlogo = "";
	$partnerpub = "";
	$ad = "";
	$curcol = "";
	$target = "";
	$RID = "";
	$mac_license = "";
	$pc_license = "";
	$payid = "";
	$seed = "";
	$aid = "";
	
	session_register("name");
	session_register("pass");
	session_register("email");
	session_register("partner_id");
	session_register("token");
	session_register("license");
	session_register("daysregistered");
	session_register("popup");
	session_register("ID");
	session_register("partnerurl");
	session_register("partnerlogo");
	session_register("partnerpub");
	session_register("ad");
	session_register("curcol");
	session_register("target");
	session_register("RID");
	session_register("mac_license");
	session_register("pc_license");
	session_register("payid");
	session_register("seed");
	session_register("aid");
}


?>

