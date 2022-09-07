<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#index3.php
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

<!-- #include file = "../inc/asp.inc" -->
<!-- #include file = "../inc/db.inc" -->

<? 

$email=$HTTP_POST_VARS["email"];
$pass=$HTTP_POST_VARS["pass"];
$publication=$HTTP_GET_VARS["publication"];

if ($publication!="")
{



}
  else
if ((($email!="") || (($syncit_ndecrypt[$HTTP_COOKIE_VARS["pid"]]!=0) || ($syncit_ndecrypt[$HTTP_COOKIE_VARS["publication"]]!=0))))
{

  if ($email!="")
  {

    $on$error$resume$next;
$conn    $execute["SELECT personid, pass FROM person WHERE email='".$strip[$email]."'"];
    if ($err)
    {
      $dberror$err.$description." [".$err.$number."]";
    } 
    $on$error$goto0;
    if (!$rs$eof)
    {

      if ($pass==$rs["pass"])
      {

        $person=$rs["personid"];
// must do something here for incorrect password or login	
      }
        else
      {


      } 

    } 

    $rs.$close;
  }
    else
  {

    $person=$syncit_ndecrypt[$HTTP_COOKIE_VARS["pid"]];
    $publication=$syncit_ndecrypt[$HTTP_COOKIE_VARS["publication"]];
    $person=2;
  } 

?>
	<html>
	<head>
	<title>syncit test</title>
	<!--
	<script language="Javascript">
		alert("<?   echo $person; ?>");
	</script>
	-->
	<script language="JavaScript" src="tocTab2.php?person=<?   echo $syncit_ncrypt[$person]; ?>&publication=<?   echo $syncit_ncrypt[$publication]; ?>"></script>
	<script language="JavaScript" src="tocParas.js"></script>
	<script language="JavaScript" src="displayToc3.js"></script>
	<script language="JavaScript">
	<!--
	function newtree(f) {
	//	toc.document.location ='index2.php?pubid=' + f.pubid.options[f.pubid.selectedIndex].value;
		tocTab.length = 0;
		 
	}
	
	document.cookie = "pid=<?   echo $syncit_ncrypt[$person]; ?>";
	document.cookie = "publication=<?   echo $syncit_ncrypt[$publication]; ?>";
	
	function Logout() {
		var yesteryear = new Date();
		yesteryear.setYear(1999);
		parent.document.cookie = "pid=blah;expires=yesteryear.toGMTString";
		parent.document.cookie = "publication=;expires=yesteryear.toGMTString";
		toc.location.href = "index3.php";	
	}
	//-->
	</script>
	<frameset border=0 onload="reDisplay('0',true);">
	<frame src="blank.htm" name="toc">
	</frameset>
	</head>
	
	<? 
// cols="200,*"
//	<br>
//	<form method="GET" action="index2.php" name="someform">
//	<select size="1" class="f11" name="publication" onchange="newtree(this.form);">


//		dim sql

//		response.write "<option value=0"
//		if syncit_ndecrypt(publication) = 0 then response.write " selected"
//		response.write ">My Bookmarks</option>"
//		sql = "SELECT publish.PublishID, publish.Title FROM subscriptions,publish where publish.PublishID = subscriptions.publish_id and (subscriptions.person_id)=" & person
//		on error resume next
//		set rs = conn.execute (sql)
//		if err then dberror err.description & " [" & err.number & "]"
//		on error goto 0
//		while not rs.eof
//			Dim pid
//	
//			response.write "<option"
//			pid = syncit_ncrypt (rs("publishid"))
//			if pid = publication then response.write " selected"
//			response.write " value=""" & pid & """>" & rs("title") & "</option>" & vbCrLf
//			rs.movenext
//		wend
//	
//		response.write "</select><br></form>" & vbCrLf
?>

<? 
}
  else
{

?>
	<html>
	<head>	
	<title>BookmarkSync</title>
	<meta http-equiv="content-type" content="text/html; charset=us-ascii">
	</head>
	<table>
	<tr align="center">
	    <td><img src="../images/logo1.gif" width="112" height="52" alt="SyncIT.com"></td>
	</tr>
	</table>
	<form method="POST" action="index3.php" name=form1>
	<img src="tinyemail.gif"><br>
						<input type="text" name="email" class="login" size="12" maxlength="50">
					<br>
	<img src="tinypass.gif"><br>
						<input type="password" name="pass" class="login" size="12" maxlength="50">
	
	<p><input border="0" src="../images/btnlogin.gif" name="I1" type="image" width="53" height="16" alt="Login"></p>
	</form>
	
<? 
} 

?>

