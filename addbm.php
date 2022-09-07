<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#addbm.php
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

include 'inc/asp.php';
include 'inc/db.php';

$AID = request("AID");
$path = request("path");
$url = request("url");
$title = request("title");

echo $path . "<br>";
echo $url . "<br>";
echo $title . "<br>";

if ($title == "")
	$title = $url;

$email = "";
if (isset($_POST['email']))
	$email = strip($_POST["email"]);

$pass = "";
if (isset($_POST['pass']))
	$pass = strip($_POST["pass"]);

if (!db_connect())
	die();

if ($AID == "" && $email != "" && $pass != ""){

	$res = mysql_query("select personid from person where email = '" . $email . "' and pass = '" . $pass . "'");
	if (!$res)
		dberror("Cannot retrieve data 1 in addbm.php");

	$data = mysql_fetch_assoc($res);
	if ($data){
		$AID = $data["personid"];
		$_SESSION['AID'] = $AID;
	}
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<title>Add Page to BookmarkSync</title>
<link rel="StyleSheet" href="common/syncit.css" type="text/css">
</head>

<body text="#000000" link="#000066" vlink="#800000" alink="#FFFFFF" bgcolor=#FFFFFF>
<img border="0" src="images/logo1.gif" width="113" height="52">
<?php
if ($AID == ""){
?>
	<p><b>Log In</b></p>
	<form method="POST" action="addbm.php">
	<input type="hidden" name="title" value="<? echo $title; ?>">
	<input type="hidden" name="url" value="<? echo $url; ?>">
	
	  <table border="0">
	    <tr>
	      <td align="right"><font face="Arial,Helvetica,Sans Serif" size="2">E-Mail:</font></td>
	      <td><input type="text" name="email" size="20" style="width:300px;"></td>
	    </tr>
	    <tr>
	      <td align="right"><font face="Arial,Helvetica,Sans Serif" size="2">Password:</font></td>
	      <td><input type="password" name="pass" size="20" style="width:300px;"></td>
	    </tr>
	    <tr>
	      <td align="right"></td>
	      <td><input type="submit" value="Log in" name="B1" class="pbutton"></td>
	    </tr>
	  </table>
	</form>
<?php
}

else {
	if ($path != ""){
		if ($path != "\\")
			$path = "\\" . $path . "\\";
	
		//$res = mysql_query
		echo("select distinct bookid from bookmarks where url = '" . my_addslashes($url) . "'");
	die();
		$data = mysql_fetch_assoc($res);
		if (!$data){
			mysql_query("insert into bookmarks (url) values ('" . my_addslashes($url) . "')");
			$book_id = mysql_insert_id();
		}
		else
			$book_id = $data['bookid'];
	
		mysql_query("update link set expiration = null, book_id=" . $book_id . " where person_id=" . $AID . " and path='" . my_addslashes($path) . "'");
		if (mysql_affected_rows() == 0)
			mysql_query("insert into link (expiration,person_id,book_id,access,path) values (null," . $AID . "," . $book_id . ",now(),'" . my_addslashes($path) . my_addslashes($title) . "')");
	
		mysql_query("update person set token = token + 1, lastchanged=now() where personid=" . $AID);
		mysql_query("update publish set token = token + 1 where user_id=" . $AID);
?>
		<p><b>The bookmark has been added.<br></b>
		You can <a href="javascript:top.close();">close</a> the window now.</p>

<?php
	}
	else {
?>
		<form method="POST" action="addbm.php">
		<input type="hidden" name="AID" value="<?   echo $AID; ?>">
		<table border="0">
		<tr>
		<td align="right"><font face="Arial,Helvetica,Sans Serif" size="2">Title:</font></td>
		<td><input type="text" name="title" size="40" value="<?   echo $title; ?>"></td>
		</tr>
		<tr>
		<td align="right"><font face="Arial,Helvetica,Sans Serif" size="2">URL:</font></td>
		<td><input type="text" name="url" size="40" value="<?   echo $url; ?>"></td>
		</tr>
		<tr>
		<td align="right"><font face="Arial,Helvetica,Sans Serif" size="2">Folder:</font></td>
		<td><select size="1" name="path">
		<option value="\">TOPLEVEL</option>
<?php

		$ID = $AID;
		$res = mysql_query("select link.path,bookmarks.url from bookmarks right join link on bookmarks.bookid = link.book_id where link.person_id=" . $ID . " and link.expiration is null order by link.path");
		if (!$res)
			dberror("Cannot retrieve data 3 in addbm.php");

		$cur_path = "";
		$items = 0;
		while($data = mysql_fetch_assoc($res)){

			// lauren new code
			$dpath = "";
			$vpath = "";
			$line = explode("\\",substr($data['path'],1));
			$items = count($line);

			if ($items > 1){
				for ($i=0; $i<$items-2; $i++)
					$dpath .= "-";
				$dpath .= $line[$items-2];
				$vpath = $line[$items-2];
				if ($dpath != $cur_path){
					echo "<option value='" . $vpath . "'>" . $dpath . "</option>\r\n";
					$cur_path = $dpath;
				}
			}
		}
	}
?>
	</select>&nbsp;</td>
	</tr>
	<tr>
	<td align="right">&nbsp;</td>
	<td>&nbsp;<input type="submit" value="Add Bookmark" name="B1" class="pbutton"></td>
	</tr>
	</table>
	</form>
<?php
}
?>
</body>
</html>

