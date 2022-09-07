<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#searchbm.php
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

//set_time_limit(1000);

$GLOBALS['mainmenu'] = "SEARCH";
$GLOBALS['submenu'] = "";

restricted("../bms/searchbm.php?" . $_GET);

$cnt = 0;
$searchstr = request("searchbm");
$sherlock = request("sherlock");
$checkold = request("checkold");

if ($sherlock != "")
	$searchstr = $sherlock;

$cntmax = request("cnt");
if ($cntmax = "")
	$cntmax=20;

$showhelp = "No Records found";
$idx = request("idx");
if ($idx == "")
	$idx = 0;

$oidx = $idx;
$ID = $_SESSION['ID'];
if (!db_connect())
	die();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync - Search</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../common/syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#330099" vlink="#990000" alink="#CC0099" onLoad="document.searchfrm.searchbm.focus();document.searchfrm.searchbm.select()">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<?php include '../inc/ymenu.php'; ?>
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
<?php include '../inc/yhead.php'; ?>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top"> <!-- * -->
            <img src="../images/icon_searchbm1.gif" width="104" height="56" align="right" vspace="10" alt="Search for Bookmarks"><br>
            <h2>Search Your Bookmarks</h2>
            <p class="menul">[<a href="../collections/searchcol.php">Want to
            search inside publications? Click here!</a>]
            </p>
            <p>You can search for any web-page that you have bookmarked.
            
            </p>
            <form method="get" action="searchbm.php" name="searchfrm">
              <span class="menub"> &nbsp;ENTER SEARCH TERM</span><br>
              <input type="text" name="searchbm" class="register" size="30" value="<? echo $searchstr; ?>">
              <input type="image" border="0" name="imageField" src="../images/btnok.gif" width="62" height="16" align="absmiddle" alt="OK">
              <br><input type=checkbox name="checkold" value="X" <?php if ($checkold != "") echo "CHECKED"; ?>><span class="menub"> &nbsp;Search also previously deleted bookmarks</span>
            </form>
<?php

if ($searchstr != ""){

	$sql = "select bookid,path as title,url,expiration from bookmarks,link where person_id = " . $ID . " and bookid = book_id";
	if ($idx != "")
		$sql .= " and bookid < " . $idx;
	if ($checkold == "")
		$sql .= " and expiration is null";

	$sql .= " and (link.path like '%" . $searchstr . "%' or bookmarks.url like '%" . $searchstr . "%') ORDER by bookid DESC";
	$res = mysql_query($sql);
	if (!$res)
		dberror("Cannot search bookmarks in searchbm.php");

	else if ($data = mysql_fetch_assoc($res)){

		$cnt = 0;
		$lasturl = "";
		$firstid = $data["bookid"];
		do {
			$surl = $data["url"];
			if (substr($surl,strlen($surl)-(1)) == "/")
				$surl = substr($surl,0,strlen($surl)-1);
			$spath = trim($data["title"]."");

			if (substr($surl+"xxxxx",0,5) != "file:" && $surl != $lasturl){
				if (strlen($spath) > 62)
					$spath = substr($spath,0,60) . "...";
				$spath = str_replace("<","&lt;",$spath);
				$spath = str_replace(">","&gt;",$spath);
				$showhelp = "";
				if ((""==("" . $data["expiration"])))
					$bpic="a";
				else
					$bpic="r";
				if ($sherlock!="")
					echo "<!-- item_start --><a href=" . $surl . ">" . $spath . "</a><!-- item_end --><br>\r\n";
				else {
					$expiration = trim($data["expiration"]);
					if ($expiration == "")
						echo "<img src='../tree/a.gif' alt=''><span class='tlist'><a target=_blank href=" . $surl . ">" . $spath . "</a><br></span>\r\n";
					else
						echo "<img src='../tree/r.gif' alt=''><span class='tlist'><a target=_blank href=" . $surl . ">" . $spath . "</a> <small>[" . $expiration . "]</small><br></span>\r\n";
				} 
			
				$cnt++;
				$lasturl = $surl;
			}
			
			$idx = $data["bookid"];
		} while ($data = mysql_fetch_assoc($res) && $cnt <= $cntmax);
	}
    else
		echo "<b><font color='#FF0000'>Nothing found.</font></b>";
}
?>
	</td>
	<td width="10" valign="top">&nbsp;</td>
	</tr>
	</table>
	<p class="menul">
<?php
if ($oidx != ""){
	echo "<a href='javascript:history.back()'>";
	echo "&lt;&lt;&lt; Prev</a>";
}

if ($oidx != "" && $cnt > $cntmax)
	echo " || ";

if ($cnt > $cntmax){
	echo "<a href='searchbm.php?";
	echo "searchbm=" . rawurlencode($searchstr) . "&cnt=" . $cntmax . "&idx=" . $idx . "&checkold=" . $checkold;
	echo "'>Next &gt;&gt;&gt;</a>";
} 
?>      
      </p>
    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
</html>

