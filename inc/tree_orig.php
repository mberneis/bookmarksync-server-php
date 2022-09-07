<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#tree_orig.php
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
	$tmp = array();
	$myurl = array_pad($tmp,32,"");

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
		$_path = "\\" . $data['path'] . "%";
	 
		$sql = "select link.path,link.book_id,bookmarks.url,o.src as osrc,c.src as csrc from bookmarks right join link on bookmarks.bookid = link.book_id 
			left join images as o on o.imgid = link.openimg_id left join images as c on c.imgid = link.closeimg_id 
			where link.person_id = " . $_userid . " and link.expiration is null and link.path like " . $_path . " order by link.path";
	} 

	$res = mysql_query($sql);
	if (!$res)
		dberror("Cannot retrieve data in tree.php");

	$delim = "";
	$showit = true;
	$level = 1;
	$foldernum = 0;
	if ($pubid > 0){
		if ($uid == $newsid){
			if (substr(strtolower($title),0,5)=="news\\")
				$title = substr($title,strlen($title)-(strlen($title)-5));
			echo "<H2>" . $title . "</H2>";
		}
		else
			echo "<H2>" . $title . "</H2><H4>" . $desc . "</H4>";
	} 

//response.write "vpath=" & vpath & " vlen=" & len(vpath) & "<hr>"
//@@@response.write "<ul>"
	while($data = mysql_fetch_assoc($res)){
//		echo $data['path'] . /*"&nbsp;&nbsp" . $data['url'] .*/ "<br>";
//	}
//	die();

		$p = $data["path"];
		if ($vlen > 0)
			$p = substr($p,strlen($p)-(strlen($p)-$vlen));

		if ($delim == ""){
			$delim = substr($p,0,1);
			$prefix = $delim;
		}

		if ($delim != substr($p,0,1))
			$delim = substr($p,0,1);

	    while (strtolower(substr($p,0,strlen($prefix))) != strtolower($prefix)){

			echo $myurl[$level];
			$level--;
			//@@@response.write "</ul>"	& vbCrLf
			echo "</div>\r\n";
			do {
				if (strlen($prefix) == 0){
					$prefix = $delim;
					$level++;
					//@@@response.write "<ul>"	& vbCrLf
					echo "<div>\r\n";
				}
				else
					$prefix = substr($prefix,0,strlen($prefix)-1);

				if (substr($prefix,strlen($prefix)-1) == $delim)
					break;
			} while (true); // do loop
		} // while loop

		do {
			$i = strpos($p,$delim,strlen($prefix)+1);
			if ($i === false || $i == 0)
			  break;

			$f = unprep(substr($p,strlen($prefix),$i-strlen($prefix)));
			$fm = trim(substr($p,0,$i));
			$foldernum++;
			if ($MSIE){
				if ($doedit)
					echo "<div id='fx' class='fi'><a href='conf.php?f=" . rawurlencode($fm) . "'><img src='g.gif' border=0></a><img src='h.gif' height=14 width=" . ($level*15) . "><img id='fx1' src='f.gif'>" . $f . "</div>\r\n";
				else
					echo "<div id='fx' class='fi'><img src='s.gif' width='0'><img src='s.gif' width='0'><img src='s.gif' height=10 width=" . ($level*15) . "><img id='fx1' src='f.gif'>" . $f . "</div>\r\n";
				echo "<div id='fl' style='display:none' style=&{head};>\r\n";
			}
			else {
				if ($NS6){
					if ($doedit)				
						echo "<div id='fx' class='fi'><a href='conf.php?f=" . rawurlencode($fm) . "'><img src='g.gif' border=0></a><img src='h.gif' height=14 width=" . ($level*15) . "><img id='fx1' src='f.gif'>" . $f . "</div>\r\n";
					else
						echo "<div id='fx' class='fi'><img src='s.gif' width='0'><img src='s.gif' width='0'><img src='s.gif' height=10 width=" . ($level*15) . "><a href='javascript:nchange(this);'><img border=0 id='fx1' src='f.gif'>" . $f . "</a></div>\r\n";
					echo "<div id='fl' style='display:none' style=&{head};>\r\n";
					//response.write "<div id=""fl"" style=&{head};>" & vbCrLf
				}
				else {
					if ($doedit)
						echo "<div id='fx' class='fi'><a href='conf.php?f=" . rawurlencode($fm) . "'><img src='g.gif' border=0></a><img src='h.gif' height=14 width=" . (($level-1)*15) . "><img id='fx1' src='o.gif'>" . $f . "</div>\r\n";
					else
						echo "<div id='fx' class='fi'><img src='s.gif' width='0'><img src='s.gif' width='0'><img src='s.gif' height=10 width=" . (($level-1)*15) . "><img id='fx1' src='o.gif'>" . $f . "</div>\r\n";
					echo "<div id='fl' style=&{head};>\r\n";
				}
			} 

			$level++;
			$myurl[$level] = "";
			$prefix = substr($p,0,$i);
		} while (true);

		$url = $data["url"];

		if (strpos($url,":") === false && $url != "")
			$url = "http://" . $url;

		$mytitle = substr($p,strlen($p)-(strlen($p)-strlen($prefix)));
		$mytitle = str_replace("<","&lt;",$mytitle);
		$mytitle = str_replace(">","&gt;",$mytitle);
		$mytitle = unprep($mytitle);

		if ($MSIE){
			if ($doedit){
				if ($url != "")
					$myurl[$level] .= "<div class='bi'><a href='conf.php?p=" . rawurlencode($p) . "'><img src='g.gif' border=0></a><img src='h.gif' height=14 width=" . ($level*15) . "><img src='b.gif'><a target='" . $target . "' href='" . $url . "'>" . $mytitle . "</a></div>\r\n";
			}
			else {
				if ($url != "")
					$myurl[$level] .= "<div class='bi'><img src='s.gif' width='0'><img src='s.gif' height=10 width=" . ($level*15) . "><img src='a.gif'><a target='" . $target . "' href='" . $url . "'>" . $mytitle . "</a></div>\r\n";
			} 
		}
		else {
			if ($doedit){
				if ($url != "")
					$myurl[$level] .= "<div class='bi'><a href='conf.php?p=" . rawurlencode($p) . "'><img src='g.gif' border=0></a><img src='h.gif' height=14 width=" . ($level*15) . "><img src='b.gif'><a target='" . $target . "' href='" . $url . "'>" . $mytitle . "</a></div>\r\n";
			}
			else {
				if ($url != "")
					$myurl[$level] .= "<div class='bi'><img src='s.gif' width='0'><img src='s.gif' height=10 width=" . ($level*15) . "><img src='a.gif'><a target='" . $target . "' href='" . $url . "'>" . $mytitle . "</a></div>\r\n";
			} 
		} 
	}

	if (!empty($myurl)){
		while($level > 0){
			echo $myurl[$level] . "</div>";
			$level--;
		}
	}
} 
?>