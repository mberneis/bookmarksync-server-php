<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#remote.php
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
  session_name("syncitmain");
	session_start();
  session_register("target_session");
  session_register("RID_session");
?>
<!-- #include file = "../inc/asp.inc" -->
<? header("Expires: ".-1);
?>
<!-- #include file = "../inc/db.inc" -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<!-- #include file = "../inc/tree.inc" -->
<html>
<head>
<title>SyncIT Remote</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
<base target="bmtarget">
</head>

<body bgcolor="#FFFFFF">
<? 

$pubid=$HTTP_GET_VARS["pubid"];
$target=$target_session;

if ($target=="")
{
  $target="_blank";
} 

$ID=$RID_session+0;
if ($ID==0)
{

  $email=$HTTP_POST_VARS["email"];
  $pass=$HTTP_POST_VARS["pass"];

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
        $RID_session=$rs["personid"];
      } 
    } 

    $rs.$close;
  }
    else
  {

    $email=$HTTP_COOKIE_VARS["email"];
  } 


  $ID=$RID_session+0;
} 


if ($ID==0)
{

  $on$error$resume$next;
$conn  $execute["SELECT name, email FROM person WHERE personid = ".$ID];
  if ($err)
  {
    $dberror$err.$description." [".$err.$number."]";
  } 
  $on$error$goto0;
  if (!$rs$eof)
  {

    $RID_session=$ID;
  } 


  $rs.$close;
} 


if ($ID==0)
{

?>
<table>
  <tr align="center">
    <td><img src="../images/logo1.gif" width="112" height="52" alt="SyncIT.com"></td>
  </tr>
</table>
<form method="POST" action="remote.php" target="_self">
  <span class="menub">E-MAIL:</span><br>
                    <input type="text" name="email" class="login" size="12" maxlength="50" value="<?   echo $email; ?>">
                  <br>
  <span class="menub">PASSWORD:</span><br>
                    <input type="password" name="pass" class="login" size="12" maxlength="50">

  <p><input border="0" src="../images/btnlogin.gif" name="I1" type="image" width="53" height="16" alt="Login"></p>
</form>
<? }
  else
{
?>
<form method="GET" action="remote.php" name="frmsel">
<table>
  <tr align="center">
    <td><a target="<?   echo $target; ?>"><img src="../images/logo1.gif" width="112" height="52" border="0" alt="SyncIT.com"></a></td>
  </tr>
</table>
<script language="JavaScript">
<!--
function newtree(f) {
	document.location ='remote.php?pubid=' + f.pubid.options[f.pubid.selectedIndex].value;
}
//-->
</script>
<br>
<select size="1" class="f11" name="pubid" onchange="newtree(this.form);">
	<? 

  print "<option value=0";
  if ($syncit_ndecrypt[$pubid]==0)
  {
    print " selected";  } 

  print ">My Bookmarks</option>";
  $sql="SELECT publish.PublishID, publish.Title FROM subscriptions,publish where publish.PublishID = subscriptions.publish_id and (subscriptions.person_id)=".$ID;
  $on$error$resume$next;
$conn  $execute[$sql];
  if ($err)
  {
    $dberror$err.$description." [".$err.$number."]";
  } 
  $on$error$goto0;
  while(!$rs$eof)
  {


    print "<option";
    $pid=$syncit_ncrypt[$rs["publishid"]];
    if ($pid==$pubid)
    {
      print " selected";    } 

    print " value=\"".$pid."\">".$rs["title"]."</option>"."\r\n";
    $rs.$movenext;
  } 

  print "</select><br></form>"."\r\n";

  $tree$pubid  $false;
} 


$conn.$close;
$conn=null;

?>
</body>





