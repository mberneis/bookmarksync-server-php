<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#nettree.php
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

<? 

$agent=${"HTTP_USER_AGENT"};

// 1 - Netscape
// 2 - MSIE
// 3 - Other?

if ((strpos($agent,"compatible") ? strpos($agent,"compatible")+1 : 0)==0)
{

  $b_type=1;
}
  else
if ((strpos($agent,"MSIE") ? strpos($agent,"MSIE")+1 : 0)>0)
{

  $b_type=2;
}
  else
{

  $b_type=3;
} 

?>

<script language="JavaScript">
<!--
function sendmail(email) {
	var em = window.open ("sendmail.php?email=" + email,"popup","height=470,width=550,top=0,left=0,resizable=1,scrollbars=1,statusbar=0");
}

if (navigator.userAgent.indexOf('Opera') > 0) {
	Opera = true;
} else {
	Opera = false;
}
if (navigator.userAgent.indexOf('MSIE') > 0) {
	MSIE = true;
} else {
	MSIE = false;
}
function dof(n,f) {
	if (MSIE)  {
		document.write ('<img border="0" src="o.gif"><font  face="MS Sans Serif,Helvetica,Sans-serif"><span id=Q'  + n + ' class="fi">' + f + '</span></font><dl>');
	} else {
		document.write ('<img src="o.gif"><span id=Q'  + n + ' class="fi"><font face="MS Sans Serif,Helvetica,Sans-serif">' + f + '</font></span><dl>');
	}

	if (Opera) {
		document.write ('<div id=Q' + n + 'd><blockquote>');
	} else {
		document.write ('<div id=Q' + n + 'd style="display:None;">');
	}
}


var head="display:''"
img1=new Image()
img1.src="../tree/f.gif"
img2=new Image()
img2.src="../tree/o.gif"

function change(){
   if(!document.all)
      return;
   var noff,soff,myid;
   myid=event.srcElement.id;
   noff=5;soff=4;
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

<? 
function tree($pubid,$doedit)
{
  global extract($GLOBALS);



  $MSIE=(strpos(${"HTTP_USER_AGENT"},"MSIE") ? strpos(${"HTTP_USER_AGENT"},"MSIE")+1 : 0)>0;
  $pubid=$syncit_ndecrypt[$pubid];
  if ($pubid==0)
  {

    $sql="{ call showbookmarks(".$ID.") }";
  }
    else
  {

    $sql="Select User_ID,Path,Title, category_id, Description from publish where (PublishID = ".$pubid.")";
    $on$error$resume$next;
$conn    $execute[$sql];
    if ($err)
    {
      $dberror$err.$description." [".$err.$number."]";
    } 
    $on$error$goto0;
    if (!$vs$eof)
    {

      $vpath=$vs["path"];
      $catid=$vs["Category_ID"];
      $title=$vs["Title"];
      $desc=$vs["Description"];
      $uid=$vs["User_ID"];
      $xpath=$vpath;
      do
      {
        $i=(strpos($xpath,"\") ? strpos($xpath,"\")+1 : 0);
        if ($i==0)
        {
          break;
        } 

        $xpath=substr($xpath,strlen($xpath)-(strlen($xpath)-$i));
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

        $f=substr($p,strlen($prefix)+1-1,$i-strlen($prefix)-1);
//fm = left(p,i)
        $foldernum=$foldernum+1;
//if MSIE then
        if ($doedit)
        {

          print "<div id=\"fx\" class=\"fi\"><a href=\"conf.php?p=".rawurlencode($fm)."\"><img src=\"g.gif\" border=0></a><img src=\"h.gif\" height=14 width=".$level*15."><img id=\"fx1\" src=\"f.gif\">".$f."</div>"."\r\n";
        }
          else
        {

          print "<div id=\"fx\" class=\"fi\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" height=10 width=".$level*15."><img id=\"fx1\" src=\"f.gif\">".$f."</div>"."\r\n";
        } 

//else
//if doedit then
//response.write "<div id=""fx"" class=""fi""><a href=""conf.php?p=" & Server.UrlEncode(fm) & """><img src=""g.gif"" border=0></a><img src=""h.gif"" height=14 width=" & (level-1)*15 & "><img id=""fx1"" src=""o.gif"">" & f & "</div>" & vbCrLf
//else
//response.write "<div id=""fx"" class=""fi""><img src=""s.gif"" width=""0""><img src=""s.gif"" width=""0""><img src=""s.gif"" height=10 width=" & (level-1)*15 & "><img id=""fx1"" src=""o.gif"">" & f & "</div>" & vbCrLf
//end if
//end if
        print "<div id=\"fl\" style=\"display:none\" style=&{head};>"."\r\n";

        $level=$level+1;
        $myurl[$level]="";
        $prefix=substr($p,0,$i);
      } while (!($url==$rs["url"].""));

      $mytitle=substr($p,strlen($p)-(strlen($p)-strlen($prefix)));
      $mytitle=str_replace("<","&lt;",$mytitle);
      $mytitle=str_replace(">","&gt;",$mytitle);
      if ($MSIE)
      {

        if ($doedit)
        {

          if ($url!="")
          {
            $myurl[$level]=$myurl[$level]."<div class=\"bi\"><a href=\"conf.php?p=".rawurlencode($p)."\"><img src=\"g.gif\" border=0></a><img src=\"h.gif\" height=14 width=".$level*15."><img src=\"b.gif\"><a href=\"".$url."\" target="'_content'">".$mytitle."</a></div>"."\r\n";
          } 
        }
          else
        {

          if ($url!="")
          {
            $myurl[$level]=$myurl[$level]."<div class=\"bi\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" height=10 width=".$level*15."><img src=\"a.gif\"><a href=\"".$url."\" target=\"_content\">".$mytitle."</a></div>"."\r\n";
          } 
        } 

      }
        else
      {

        if ($doedit)
        {

          if ($url!="")
          {
            $myurl[$level]=$myurl[$level]."<div class=\"bi\"><a href=\"conf.php?p=".rawurlencode($p)."\"><img src=\"g.gif\" border=0></a><img src=\"h.gif\" height=14 width=".$level*15."><img src=\"b.gif\"><a href=\"".$url."\" target="'_content'">".$mytitle."</a></div>"."\r\n";
          } 
        }
          else
        {

          if ($url!="")
          {
            $myurl[$level]=$myurl[$level]."<div class=\"bi\"><img src=\"s.gif\" width=\"0\"><img src=\"s.gif\" height=10 width=".$level*15."><img src=\"a.gif\"><a href=\"".$url."\" target=\"_content\">".$mytitle."</a></div>"."\r\n";
          } 
        } 

      } 

      $rs.$movenext;
    } 
    if ($level==2)
    {
      print $myurl[2]."</div>";    } 

    print $myurl[1];
  } function 
()
  {
    global extract($GLOBALS);

?>    return $function_ret;
  }   return $function_ret;
} 
