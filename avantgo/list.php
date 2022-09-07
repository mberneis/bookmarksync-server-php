<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#list.php
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
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
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
//	Description: Server code the syncit client communicates with 
//	for Bookmark synchronization
//	
//	Author:      Michael Berneis, Terence Way, Lauren Roberts
//	Created:     July 1998
//	Modified:    9/22/2003 by Michael Berneis
//	E-mail:      mailto:opensource@syncit.com
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
include '../inc/asp.php';
include '../inc/db.php';

$uid = "";
$license = "";

if (isset($_COOKIE['avantgoid']))
	$uid = $_COOKIE["avantgoid"];

if ($uid == "")
	$uid = request("uid");

if ($uid == ""){
	header("Location: default.php");
	die();
}

if (!db_connect())
	die();
?>
<html>
<head>
<title>BookmarkSync - List URLs</title>
<META name="HandheldFriendly" content="true"> 
</head>
<body bgcolor=#FFFFFF>
<center><img src="smalllogo.gif" width="56" height="26"></center>
<?php
$spath = "";
$bmstr = "";
$olddir = "";

if (isset($_GET['p']))
	$spath = $_GET['p'];

if ($spath == "")
	$spath = "\\";

if ($spath != "\\"){
	$bmstr = substr($spath,0,strlen($spath)-1);
	while(strlen($bmstr) > 0 && substr($bmstr,strlen($bmstr)-1) != "\\")
		$bmstr = substr($bmstr,0,strlen($bmstr)-1);

	echo "<big><b><a href='list.php?p=" . $bmstr . "'>" . $spath . "</a></b></big><hr>";
}

$bmstr = "";
$res = mysql_query("select link.path,bookmarks.url from bookmarks right join link on bookmarks.bookid = link.book_id where link.person_id=" . $uid . " and link.expiration is null order by link.path");
if (!$res)
	echo "Database retrieval problem - Please try again later.";

else {

	while($data = mysql_fetch_assoc($res)){

		$p = $data["path"];
		if (strtolower(substr($p,0,strlen($spath))) == strtolower($spath)){
			$p = substr($p,strlen($p)-(strlen($p)-strlen($spath)));
			$i = strpos($p,"\\");
			if ($i > 0){
				$dir = substr($p,0,$i);
				if (strtolower($dir) != strtolower($olddir)){
					$olddir = $dir;
					echo "<b>[<a href='list.php?uid=" . $uid . "&p=" . rawurlencode($spath.$dir) . "\\'>" . $dir . "</a>]</b><br>";
				}
			} 

			$i = strpos($p,"\\");
			$u = $data["url"];
			if ($i === false && $u != "")
				$bmstr .= "<nobr><input type='image' src='a.gif' onClick=\"alert('" . str_replace("\"","\'",str_replace("'","\'",$u)) . "')\">" . $p . "<br>";
		} 
	} 
} 

echo $bmstr;

echo "<hr><center>";
echo "<a href='add.php?uid=" . $uid . "'><img border=0 src='add.gif'></a>&nbsp;&nbsp;<a href='default.php?uid=" . $uid . "'><img border=0 src='home.gif'></a>&nbsp;&nbsp;<a href='default.php?logoff=true'><img src='logoff.gif' border=0></a></center>";
?>
</body>
</html>

