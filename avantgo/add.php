<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#add.php
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
$dolist = "";
$license = "";
$url = "";
$title = "";
$path = "";

if (!db_connect())
	die();

if (isset($_COOKIE['avantgoid']))
	$uid = $_COOKIE["avantgoid"];

if (isset($_COOKIE['avantgolist']))
	$dolist = $_COOKIE["avantgolist"];

if (isset($_COOKIE['license']))
	$license = $_COOKIE["license"];

if ($uid == "")
	$uid = request("uid");

if ($dolist == "" && isset($_POST['dolist']))
	$dolist = $_POST["dolist"];

if ($uid == ""){
	header("Location: default.php");
	die();
} 

if (isset($_POST['url']))
	$url = my_stripslashes($_POST["url"]);

if ($url != "" && $url != "http://www.?.com"){

	if (isset($_POST['title']))
		$title = $_POST["title"];

	if ($title == ""){
		$title = $url;
		if (substr($title,0,7) == "http://")
			$title = substr($title,7);

		if (substr($title,0,4) == "www.")
			$title = substr($title,4);
	
		if (substr($title,strlen($title)-4) == ".com")
			$title = substr($title,0,strlen($title)-4);

	}

	$path = my_stripslashes($_POST["folder"]);

	$res = mysql_query("select distinct bookid from bookmarks where url = '" . my_addslashes($url) . "'");
	$data = mysql_fetch_assoc($res);
	if (!$data){
		mysql_query("insert into bookmarks (url) values ('" . my_addslashes($url) . "')");
		$book_id = mysql_insert_id();
	}
	else
		$book_id = $data['bookid'];

	mysql_query("update link set expiration = null, book_id=" . $book_id . " where person_id=" . $uid . " and path='" . my_addslashes($path) . "'");
	if (mysql_affected_rows() == 0)
		mysql_query("insert into link (expiration,person_id,book_id,access,path) values (null," . $uid . "," . $book_id . ",now(),'" . my_addslashes($path) . my_addslashes($title) . "')");

	mysql_query("update person set token = token + 1, lastchanged=now() where personid=" . $uid);
	mysql_query("update publish set token = token + 1 where user_id=" . $uid);

	mysql_query("update person set token = token + 1, lastchanged=getdate() where personid=" . $uid);
	mysql_query("update publish set token = token + 1 where user_id=" . $uid);

	if (isset($_COOKIE['msg']))
		setcookie("msg",$_COOKIE["msg"] . "Added Bookmark " . $title . "<br>");
} 

?>
<html>
<head>
<title>BookmarkSync - Add URL</title>
<META name="HandheldFriendly" content="true"> 
</head>
<body bgcolor=#FFFFFF>
<center><img border=0 src="smalllogo.gif" width="56" height="26"></center>
<form method="post" action="add.php">
  <b>Add a Bookmark</b><br>
  Title:  <input type="text" name="title" size=18 maxlength=64>
    <br>
    URL: <input type="text" name="url" size=256 value="http://www.?.com">
    <br>
    Folder:    <select name="folder">
      <option value="\" selected>[Top-Level]</option>
<?php
$res = mysql_query("select book_id,path from link where person_id=" . $uid . " and book_id is not null and expiration is null order by path");

$cur_path = "";
$items = 0;
while ($data = mysql_fetch_assoc($res)){

	$dpath = "";
	$vpath = "";
	$line = explode("\\",substr($data['path'],1));
	$items = count($line);

	if ($items > 1){
		for ($i=0; $i<$items-2; $i++)
			$dpath .= "- ";
		$dpath .= $line[$items-2];
		$vpath = $line[$items-2];
		if ($dpath != $cur_path){
			echo "<option value='" . $vpath . "'>" . $dpath . "</option>\r\n";
			$cur_path = $dpath;
		}
	}
} 
?>      
    </select>
    <br>
    <input type="submit" name="Submit" value="Add" 
    onClick="document.forms[0].submitNoResponse('The Bookmark will be added during the next synchronization process',false,true)">
  <br>
  <input type=hidden name="license" value="<?php echo $HTTP_COOKIE_VARS["license"]; ?>">
  <input type=hidden name="uid" value="<?php echo $uid; ?>">
  <input type=hidden name="dolist" value="<?php echo $dolist; ?>">
</form>
<center><a href="default.php?uid=<?php echo $uid; ?>"><img border=0 src="home.gif"></a></center>
</body>
</html>

