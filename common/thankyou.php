<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#thankyou.php
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
  session_register("seed_session");
  session_register("license_session");
  session_register("email_session");
?>
<!-- #include file = "../inc/asp.inc" -->
<!-- #include file = "../inc/db.inc" -->
<!-- #include file = "../inc/mail.inc" -->
<? 
$mainmenu="PURCHASE";
$submenu="";

function cbinvalid($seed,$cbpop)
{
  global extract($GLOBALS);


  $secretkey="sdfasdfasd";
// $validator is of type "KV.Validator"

  $function_ret=(0=$validator.$Valid[$seed][$cbpop][$secretkey]);
  $validator=null;

  return $function_ret;
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>Purchase Confirmation</title>
<link rel="StyleSheet" href="syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#660066" vlink="#990000" alink="#CC0099">
<!-- #include file = "../inc/header.inc" -->
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<!-- #include file = "../inc/bmenu.inc" -->
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><a href="../news/"><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt="QuickSync News"></a><a href="../express/"><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt="SyncIT Express"></a></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_registration.gif" width="503" height="37" alt="SyncIT Purchase Confirmation"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br><h2>Purchase Confirmation</h2>
<p>
<? 
$errmsg="";
$oldseed=$seed_session;
$newseed=${"seed"};
$cbpop=${"cbpop"};
$cbreceipt=${"cbreceipt"};
$pid=$syncit_ndecrypt[${"pid"}];
$sale=${"s"}+0;

//if oldseed<>newseed then
//	errmsg = "Bad seed: " & oldseed & "|" & newseed
//	errmsg = errmsg & "Q:" & request.querystring()
//end if
if ($errmsg=="")
{

  if ($pid==0)
  {

    $errmsg="Bad User ID"."\r\n";
    $errmsg=$errmsg."Q:".$HTTP_GET_VARS[];
  } 

} 

if ($errmsg=="")
{

  if (cbinvalid($newseed,$cbpop))
  {

    $errmsg="Invalid seed decode for user #".$pid."\r\n";
    $errmsg=$errmsg."Seed = ".$newseed." | cbpop=".$cbpop." | check=".cbinvalid($newseed,$cbpop)."\r\n";
    $errmsg=$errmsg."Q:".$HTTP_GET_VARS[];
  } 

//errmsg="X"
} 

if ($errmsg=="")
{

  $on$error$resume$next;
$conn  $execute["select * from cblog where receipt='".$cbreceipt."'"];
  if ($err)
  {
    $dberror$err.$description." [".$err.$number."]";
  } 
  $on$error$goto0;
  if (!$rs$eof)
  {

    $errmsg="Known receipt ".$cbreceipt." purchased from ".$rs["person_id"]." at ".$rs["purchased"]."\r\n";
    $errmsg=$errmsg."Q:".$HTTP_GET_VARS[];
  } 

  $rs.$close;
} 

if ($errmsg=="")
{
// Finally - move to stored procedure
} 
$sql="Insert into cblog (person_id,receipt,seed,purchased,amount,query) values (";
$sql=$sql.$pid.",";
$sql=$sql."'".$cbreceipt."',";
$sql=$sql."'".$newseed."',";
$sql=$sql."getdate(),";
switch ($sale)
{
  case 1:
    $sql=$sql."40,";
    break;
  case 2:
    $sql=$sql."20,";
    break;
  case 3:
    $sql=$sql."50,";
    break;
  default:
    $sql=$sql.$sale.",";
    break;
} 
$sql=$sql."'".$HTTP_GET_VARS[]."')";
//response.write sql
$connexecute[$sql];
$conn$execute["select name,email from person where personid=".$pid];
$name=$rs["name"];
$email=$rs["email"];
$rs.$close;
$x=${"x"}+0;
$mailbody="Congratulations ".$name."!<br>";
if (($x && 1)==1)
{

  $connexecute["update person set pc_license=GetDate() where personid=".$pid];
  $mailbody=$mailbody."You have purchased a PC license.<br>";
} 

if (($x && 2)==2)
{

  $connexecute["update person set mac_license=GetDate() where personid=".$pid];
  $mailbody=$mailbody."You have purchased a MacOS license.<br>";
} 

$mailbody=$mailbody."<br>Your account has been activated. If you have not done so already please <b><a href=\"../download/default.php\">download</a></b> the client software from our site.<br>";
$mailbody=$mailbody."<BR><B>Your credit card statement will show a charge from ClickBank/Keynetics.<hR>Contact Information:</b><br><BR>SyncIt.com<br>315 7th Avenue, #21-D<br>New York, NY 10001<br>Tel: (212) 242-5442<br>";
$Mailbody=$mailbody."<hr><b>Your receipt# is ".$cbreceipt."</b>";
$license_session=true;
$domail"sales@syncit.com"$email//SyncIt License Sales Receipt",htmltxt(MailBody)
$domail"sales@syncit.com"//syncitlicense@berneis.com","SyncIt License Sales Receipt",htmltxt(MailBody)
		
	if errmsg <> "" then
		errmsg = Now() & ": Purchase Error"  & vbCrLf & errmsg
		response.write "<p><b><font color='red'>An error has occured with your transaction</font></b></p>"
		response.write "The error response is <hr>" & replace(errmsg,vbCrLf,"<br>") & "<hr>"
		response.write "An email has been sent to the SyncIt system administrators<br>"
		response.write "You will be contacted shortly at your email: <a href=""mailto:" & Session("email") & """>" & Session("email") & "</a><br>"
		response.write "If your email account is not valid please contact SyncIT.com with your receipt number (" & cbreceipt & ") at <a href=""mailto:sales@syncit.com"">sales@syncit.com</a>"
		domail "license@syncit.com","license@berneis.com","Transaction Error with UserID " & pid,htmltxt(errmsg)
	else
		response.write mailbody				
	end if
%>	
</p>
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

