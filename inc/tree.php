<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#tree.php
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
?>
<script language="JavaScript">
<!--
var head="display:''"
img1=new Image()
img1.src="../tree/f.gif"
img2=new Image()
img2.src="../tree/o.gif"

function nchange(f) {
	f1.style.display='';
	return false;
}

function change(){
   if(!document.all) {
      return
     }
   var noff,soff,myid;
   myid=event.srcElement.id;
   noff=5;soff=4;
   //alert (myid);
   if (myid =="fx1") {
   	myid="fx";
   	soff=0;noff=1;
   }
   if (myid=="fx") {
      var srcIndex = event.srcElement.sourceIndex
      var nested = document.all[srcIndex+noff]
      if (nested.style.display=="none") {
         document.all[srcIndex+soff].src="o.gif"
         nested.style.display=''
         //event.srcElement.style.listStyleImage="url(../tree/o.gif)"
      }
      else {
         document.all[srcIndex+soff].src="f.gif"
         nested.style.display="none"
         //event.srcElement.style.listStyleImage="url(../tree/f.gif)"
      }
   }
}

document.onclick=change

//-->

</script>

<?php
function tree($pubid,$doedit)
{
	$vlen = 0;
	$myurl = array();
	$url_idx = 0;
	$last_line = array();
	$last_items = 0;
	$items = 0;

	$ID = $_SESSION['ID'];

	if (!db_connect())
		die();

	$MSIE = strpos($_SERVER['HTTP_USER_AGENT'],"MSIE");
	$NS6 = strpos($_SERVER['HTTP_USER_AGENT'],"Netscape6");
	$NS6 = false;
	$target = $_SESSION['target'];
	if ($target == "")
		$target = "_blank";
	$pubid = syncit_ndecrypt($pubid);
	if ($pubid == 0)
		$sql = "select link.path,bookmarks.url from bookmarks right join link on bookmarks.bookid = link.book_id where link.person_id=" . $ID . " and link.expiration is null order by link.path";
	else {
		$res = mysql_query("select user_id,path,title,category_id,description from publish where publishid = " . $pubid);
		if (!$res)
			dberror("Cannot retrieve data in tree.php");

		if ($data = mysql_fetch_assoc($res)){
			$vpath = $data["path"];
			$catid = $data["category_id"];
			$title = $data["title"];
			$desc = $data["description"];
			$uid = $data["user_id"];
			$xpath = $vpath;
			do {
				$i = strpos($xpath,"\\");
				if ($i === false)
					break;
				$xpath = substr($xpath,strlen($xpath)-(strlen($xpath)-$i));
			} while (true);
	
			$vlen = strlen($vpath) + 1;	// - strlen($xpath);
		}

		$res = mysql_query("select user_id,path from publish where publishid=" . $pubid);
		$data = mysql_fetch_assoc($res);
		$_userid = $data['user_id'];
		$_path = "\\\\\\\\" . $data['path'] . "\\\\\\\\%";
	 
		$sql = "select link.path,link.book_id,bookmarks.url,o.src as osrc,c.src as csrc from bookmarks right join link on bookmarks.bookid = link.book_id 
			left join images as o on o.imgid = link.openimg_id left join images as c on c.imgid = link.closeimg_id 
			where link.person_id = " . $_userid . " and link.expiration is null and link.path like '" . $_path . "' order by link.path";
	} 

	$res = mysql_query($sql);
	if (!$res)
		dberror("Cannot retrieve data in tree.php");

	$delim = "";
	$showit = true;
	$level = 1;
	$foldernum = 0;
	if ($pubid > 0){
/*		if ($uid == $newsid){
			if (substr(strtolower($title),0,5)=="news\\")
				$title = substr($title,strlen($title)-(strlen($title)-5));
			echo "<H2>" . $title . "</H2>";
		}
		else
*/
			echo "<H2>" . $title . "</H2><H4>" . $desc . "</H4>";
	} 

	// if its a publication skip the folder name - kludge i know but it works :)-
	if ($pubid > 0)
		$data = mysql_fetch_assoc($res);

	while($data = mysql_fetch_assoc($res)){

		$is_folder = false;
		if (!isset($data['url']))
			$is_folder = true;

		$line = explode("\\",substr($data['path'],1));
		$items = count($line);

		if ($is_folder == true){

			if ($items > $last_items){
				for ($idx = 0; $idx < $items-1; $idx++){
					if (!isset($last_line[$idx]) || $line[$idx] != $last_line[$idx]){
						if ($doedit)
							echo "<div id='fx' class='fi'><a href='conf.php?f=" . rawurlencode($data['path']) . "'><img src='g.gif' border=0></a><img src='h.gif' height=14 width=" . (($idx+1)*15) . "><img id='fx1' src='f.gif'>" . $line[$idx] . "</div>\r\n";
						else
							echo "<div id='fx' class='fi'><img src='s.gif' width='0'><img src='s.gif' width='0'><img src='s.gif' height=10 width=" . ($idx*15) . "><img id='fx1' src='f.gif'>" . $line[$idx] . "</div>\r\n";
						echo "<div id='fl' style='display:none' style=&{head};>\r\n";
					}
				}
			}

			else if ($items <= $last_items){
				for ($idx = 0; $idx < $last_items - $items +1; $idx++)
					echo "</div>\r\n";

				for ($idx = 0; $idx < $items-1; $idx++){
					if ($last_line[$idx] != $line[$idx]){
						if ($doedit)
							echo "<div id='fx' class='fi'><a href='conf.php?f=" . rawurlencode($data['path']) . "'><img src='g.gif' border=0></a><img src='h.gif' height=14 width=" . (($idx+1)*15) . "><img id='fx1' src='f.gif'>" . $line[$idx] . "</div>\r\n";
						else
							echo "<div id='fx' class='fi'><img src='s.gif' width='0'><img src='s.gif' width='0'><img src='s.gif' height=10 width=" . ($idx*15) . "><img id='fx1' src='f.gif'>" . $line[$idx] . "</div>\r\n";
						echo "<div id='fl' style='display:none' style=&{head};>\r\n";
					}
				}
			}

			$last_line = $line;
			$last_items = $items;
		}

		// else we differ on the link only so add a link in the current folder
		else {
			if ($items > 1){
				if ($doedit)
					echo "<div class='bi'><a href='conf.php?p=" . rawurlencode($data['path']) . "'><img src='g.gif' border=0></a><img src='h.gif' height=14 width=" . (($idx+1)*15) . "><img src='b.gif'><a target='" . $target . "' href='" . $data['url'] . "'>" . $line[$items-1] . "</a></div>\r\n";
				else
					echo "<div class='bi'><img src='s.gif' width='0'><img src='s.gif' height=10 width=" . (($items-1)*15) . "><img src='a.gif'><a target='" . $target . "' href='" . $data['url'] . "'>" . $line[$items-1] . "</a></div>\r\n";
			}
			else {
				if ($doedit)
					$myurl[$url_idx++] = "<div class='bi'><a href='conf.php?p=" . rawurlencode($data['path']) . "'><img src='g.gif' border=0></a><img src='h.gif' height=14 width=" . ($items*15) . "><img src='b.gif'><a target='" . $target . "' href='" . $data['url'] . "'>" . $line[0] . "</a></div>\r\n";
				else
					$myurl[$url_idx++] = "<div class='bi'><img src='s.gif' width='0'><img src='s.gif' height=10 width=" . (($items-1)*15) . "><img src='a.gif'><a target='" . $target . "' href='" . $data['url'] . "'>" . $line[0] . "</a></div>\r\n";
			}
		}
	}

	for ($idx = 0; $idx < $items; $idx++)
		echo "</div>\r\n";

	echo "</div>\r\n";

	if ($url_idx > 0){
		for ($idx = 0; $idx < $url_idx; $idx++)
			echo $myurl[$idx];
	}
} 
?>