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
	$MSIE = strpos($_SERVER['HTTP_USER_AGENT'],"MSIE");
	$NS6 = strpos($_SERVER['HTTP_USER_AGENT'],"Netscape6");
	$NS6 = false;
	$target = $_SESSION['target'];
	if ($target == "")
		$target = "_blank";
	$pubid = syncit_ndecrypt($pubid);
	if ($pubid == 0)
		$sql = "select link.path,bookmarks.url from bookmarks right join link on bookmarks.bookid = link.book_id where (link.person_id=" . $ID . " and (link.expiration is null)) order by link.path");
	else {
	    $sql="select user_id,path,title,category_id,description from publish where publishid = " . $pubid);

	$res = mysql_query($sql);
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
			$i = strpos($xpath,"\");
			if ($i == 0)
				break;
			$xpath = substr($xpath,strlen($xpath)-(strlen($xpath)-$i));
		} while (!($vlen==strlen($vpath)+1) //- len(xpath));
	} 

    $sql="{ call showpublication(".$pubid.") }";
  } 

  $on$error$resume$next;
$conn  $execute[$sql];
  if ($err)
  {
    $dberror$err.$description." [".$err.$number."]";
  } 
  $on$error$goto0;
  $delim="";
  $showit=true;
  $level=1;
  $foldernum=0;
  if ($pubid>0)
  {

    if ($uid==$NewsID)
    {

      if (substr(strtolower($title),0,5)=="news\")
      {
        $title=substr($title,strlen($title)-(strlen($title)-5));
      } 
      print "<H2>".$title."</H2>";
    }
      else
    {

      print "<H2>".$title."</H2><H4>".$desc."</H4>";
    } 

  } 

//response.write "vpath=" & vpath & " vlen=" & len(vpath) & "<hr>"
//@@@response.write "<ul>"
  while(!$rs$eof)
  {

    $p=$rs["path"];
    if ($vlen>0)
    {
      $p=substr($p,strlen($p)-(strlen($p)-$vlen));
    } 
    if ($delim=="")
    {

      $delim=substr($p,0,1);
      $prefix=$delim;
    } 

    if ($delim!=substr($p,0,1))
    {
      $delim=substr($p,0,1);
    } 
    while(strtolower(substr($p,0,strlen($prefix)))!=strtolower($prefix))
    {

      print $myurl[$level];
      $level=$level-1;
//@@@response.write "</ul>"	& vbCrLf
      print "</div>"."\r\n";
      do
      {
        if (strlen($prefix)==0)
        {

          $prefix=$delim;
          $level=$level+1;
//@@@response.write "<ul>"	& vbCrLf
          print "<div>"."\r\n";
        }
          else
        {

          $prefix=substr($prefix,0,strlen($prefix)-1);
        } 

        if (substr($prefix,strlen($prefix)-(1))==$delim)
        {
          break;
        } 

      } while (!($wend));

      do
      {

        $i=(strpos(strlen($prefix)+1,$p,$delim) ? strpos(strlen($prefix)+1,$p,$delim)+1 : 0);
        if ($i==0)
        {
          break;
        } 

        $f=$unprep[substr($p,strlen($prefix)+1-1,$i-strlen($prefix)-1)];
        $fm=trim(substr($p,0,$i));
        $foldernum=$foldernum+1;
        if ($MSIE)
        {

          if ($doedit)
          {

            print "<div id=\"fx\" class=\"fi\"><a href=\"conf.php?f=".rawurlencode($fm)."\"><img src=\"g.gif\" border=0></a><img src=\"h.gif\" height=14 width=".$level*15."><img id=\"fx1\" src=\"f.gif\">".$f."</div>"."\r\n";
          }
            else
          {

            print "<div id=\"fx\" class=\"fi\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" height=10 width=".$level*15."><img id=\"fx1\" src=\"f.gif\">".$f."</div>"."\r\n";
          } 

          print "<div id=\"fl\" style=\"display:none\" style=&{head};>"."\r\n";
        }
          else
        {

          if (($NS6))
          {

            if ($doedit)
            {

              print "<div id=\"fx\" class=\"fi\"><a href=\"conf.php?f=".rawurlencode($fm)."\"><img src=\"g.gif\" border=0></a><img src=\"h.gif\" height=14 width=".($level)*15."><img id=\"fx1\" src=\"f.gif\">".$f."</div>"."\r\n";
            }
              else
            {

              print "<div id=\"fx\" class=\"fi\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" height=10 width=".($level)*15."><a href=\"javascript:nchange(this);\"><img border=0 id=\"fx1\" src=\"f.gif\">".$f."</a></div>"."\r\n";
            } 

            print "<div id=\"fl\" style=\"display:none\" style=&{head};>"."\r\n";
//response.write "<div id=""fl"" style=&{head};>" & vbCrLf
          }
            else
          {

            if ($doedit)
            {

              print "<div id=\"fx\" class=\"fi\"><a href=\"conf.php?f=".rawurlencode($fm)."\"><img src=\"g.gif\" border=0></a><img src=\"h.gif\" height=14 width=".($level-1)*15."><img id=\"fx1\" src=\"o.gif\">".$f."</div>"."\r\n";
            }
              else
            {

              print "<div id=\"fx\" class=\"fi\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" height=10 width=".($level-1)*15."><img id=\"fx1\" src=\"o.gif\">".$f."</div>"."\r\n";
            } 

            print "<div id=\"fl\" style=&{head};>"."\r\n";
          } 

        } 

        $level=$level+1;
        $myurl[$level]="";
        $prefix=substr($p,0,$i);
      } while (!($url==$rs["url"].""));

      if (((strpos($url,":") ? strpos($url,":")+1 : 0)<1) && ($url!=""))
      {
        $url="http://".$url;
      } 
      $mytitle=substr($p,strlen($p)-(strlen($p)-strlen($prefix)));
      $mytitle=str_replace("<","&lt;",$mytitle);
      $mytitle=str_replace(">","&gt;",$mytitle);
      $mytitle=$unprep[$mytitle];
      if ($MSIE)
      {

        if ($doedit)
        {

          if ($url!="")
          {
            $myurl[$level]=$myurl[$level]."<div class=\"bi\"><a href=\"conf.php?p=".rawurlencode($p)."\"><img src=\"g.gif\" border=0></a><img src=\"h.gif\" height=14 width=".$level*15."><img src=\"b.gif\"><a target=\"".$target."\" href=\"".$url."\">".$mytitle."</a></div>"."\r\n";
          } 
        }
          else
        {

          if ($url!="")
          {
            $myurl[$level]=$myurl[$level]."<div class=\"bi\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" height=10 width=".$level*15."><img src=\"a.gif\"><a target=\"".$target."\" href=\"".$url."\">".$mytitle."</a></div>"."\r\n";
          } 
        } 

      }
        else
      {

        if ($doedit)
        {

          if ($url!="")
          {
            $myurl[$level]=$myurl[$level]."<div class=\"bi\"><a href=\"conf.php?p=".rawurlencode($p)."\"><img src=\"g.gif\" border=0></a><img src=\"h.gif\" height=14 width=".$level*15."><img src=\"b.gif\"><a target=\"".$target."\" href=\"".$url."\">".$mytitle."</a></div>"."\r\n";
          } 
        }
          else
        {

          if ($url!="")
          {
            $myurl[$level]=$myurl[$level]."<div class=\"bi\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" height=10 width=".$level*15."><img src=\"a.gif\"><a target=\"".$target."\" href=\"".$url."\">".$mytitle."</a></div>"."\r\n";
          } 
        } 

      } 

      $rs.$movenext;
    } 
    while($level>0)
    {

      print $myurl[$level]."</div>";
      $level=$level-1;
    } 
  } function 
()
  {
    global extract($GLOBALS);

?>    return $function_ret;
  }   return $function_ret;
} 
