<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#cview.php
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
  session_register("ID_session");
  session_register("curcol_session");
?>
<!-- #include file = "../inc/asp.inc" -->
<!-- #include file = "../inc/db.inc" -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<? 

$checkuser[];
$ID=$ID_session;
$submenu="VIEW";
$invite=$HTTP_GET_VARS["invite"];
if ($invite!="")
{

  $ref="BROWSE";
  $pid=$syncit_ndecrypt[$invite];
}
  else
{

  $ref=$HTTP_GET_VARS["ref"];
  $pubid=$HTTP_GET_VARS["pid"];
  $pid=$syncit_ndecrypt[$pubid];
} 

if ($ref!="")
{
  $mainmenu=$ref;
} 
if ($pid==0)
{
  $pid=$curcol_session;
} 
if ($pid==0)
{
  $myRedirect[${"HTTP_REFERER"}];
} 
$curcol_session=$pid;

$referer=${"HTTP_REFERER"};
if ($referer=="")
{
  $referer="../collections/default.php";
} ?>
<!-- #include file = "../inc/tree.inc" -->
<html>
<head>
<title>BookmarkSync - My Bookmarks</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#3300CC" vlink="#990000" alink="#CC0099">
<!-- #include file = "../inc/header.inc" -->
<table width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<!-- #include file = "../inc/cmenu.inc" -->
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
<!-- #include file = "../inc/chead.inc" -->
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br>
            <? if ($invite!="")
{
?>
            <h3><font color="#FF0000">You have been invited to <a href="../collections/subscription.php?addid=<?   echo $invite; ?>">subscribe</a> to this collection.</font></h3>
           <? 
  $tree$syncit_ncrypt[$pid]  $false;
}
  else
{

  $tree$syncit_ncrypt[$pid]  $false;
?>
            <h3><font color="#FF0000">Would you like to <a href="../collections/subscription.php?addid=<?   echo $pubid; ?>">subscribe</a> to this collection?</font></h3>
           <? } 

?>
			<a href="<? echo $referer; ?>" onclick="history.back();"><img border="0" src="../images/btnback.gif" alt="Back to previous page" width="62" height="16"></a>
          </td>
          <td width="10" valign="top">&nbsp;</td>
        </tr>
      </table>

    </td>
  </tr>
</table>
<!-- #include file = "../inc/footer.inc" -->
</body>

</html>

