<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#frame.php
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

restricted("../bms/frame.php");

$ID = $_SESSION['ID'];

$_SESSION['target'] = "bmtarget";
$GLOBALS['mainmenu'] = "VIEW";
$GLOBALS['submenu'] = "FRAME";
?>
<script language="javascript">
<!--
var bp = 0;

//if (parent.location.href != window.location.href) {
if (parent.bp == 1) {
	bp = 0;
	parent.location.href='../bms/default.php';
} 
else {
	bp = 1;
	document.writeln ('<frameset cols="30%,*">');
	document.writeln ('<frame src="../tree/remote.php" name="bmremote" target="bmtarget">');
	document.writeln ('<frame src="../bms/default.php" name="bmtarget">');
	document.writeln ('</frameset>');
	document.writeln ('<noframes>' + window.location.href + '</noframes>');
}
//-->
</script>




