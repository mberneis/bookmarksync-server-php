<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#retrieve.php
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
  session_register("syncitexpresspath_session");
  session_register("email_session");
?>
<!-- #include file = "../common/asp.inc" -->
<!-- #include file = "../common/db.inc" -->
<!-- #include file = "../common/mail.inc" -->
<? 

$mainmenu="RETRIEVE";
$submenu="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>SyncIT Express: Retrieve Delivery</title>
<link rel="StyleSheet" href="../common/syncit.css" type="text/css">
</head>
<script language="JavaScript">
<!--
// Validate Form
//~~~~~~~~~~~~~~
function checkit(f) {
	if (f.email.value.indexOf('.') == -1 || f.email.value.indexOf('@') == -1) {
		alert ("Please enter a valid E-mail address");
		f.email.focus();
		return false;
	}

	return true;
}
//-->
</script>

<body bgcolor="#FFFFFF" text="#000000" link="#3300CC" vlink="#990000" alink="#CC0099">
<!-- #include file = "../common/header.inc" -->
<table width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<!-- #include file = "emenu.inc" -->
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
<!-- #include file = "ehead.inc" -->
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br><h2>Retrieve Your File Here</h2>
<? 
if ($HTTP_GET_VARS["err"]=="1")
{

  $action=6;
}
  else
{

  $valfolder="../";
  $action=0;
  $email=$HTTP_POST_VARS["email"];
  if ($email=="")
  {

    $code=$HTTP_GET_VARS["code"];
    $eid=$syncit_ndecrypt[$code];
    $on$error$resume$next;
$conn    $execute["Select distribution,fsize,filename,password from express where expressid=".$eid];
    if ($err)
    {
      $dberror$err.$description." [".$err.$number."]";
    } 
    $on$error$goto0;
    if ($rs$eof)
    {

      $action=1;
    }
      else
    {

      $action=2;
      $distribution=$rs["distribution"];
      $fsize=$rs["fsize"];
      $fp=$rs["filename"];
      do
      {
        $I=(strpos($fp,"\") ? strpos($fp,"\")+1 : 0);
        if ($i==0)
        {
          break;
        } 

        $fp=substr($fp,strlen($fp)-(strlen($fp)-$i));
      } while (!($pass==$rs["password"]));

    } 

    $rs.$close;
  }
    else
  {

    $code=$HTTP_POST_VARS["code"];
    $eid=$syncit_ndecrypt[$code];
    $email=strtolower(trim($HTTP_POST_VARS["email"]));
    $p=trim($HTTP_POST_VARS["pass"]);
    $on$error$resume$next;
$conn    $execute["Select distribution,password,filename,sender_id,title,activity from express where expressid=".$eid];
    if ($err)
    {
      $dberror$err.$description." [".$err.$number."]";
    } 
    $on$error$goto0;
    $dist=strtolower($rs["distribution"]);
    if ((strpos($dist,$email) ? strpos($dist,$email)+1 : 0)==<0)
    {

      $action=3;
    }
      else
    {

      $pass=$rs["password"];
      if ($pass!="" && $p!=$pass)
      {

        $action=4;
      }
        else
      {

        $path=$rs["filename"];
        $fp=$path;
        do
        {
          $I=(strpos($fp,"\") ? strpos($fp,"\")+1 : 0);
          if ($i==0)
          {
            break;
          } 

          $fp=substr($fp,strlen($fp)-(strlen($fp)-$i));
        } while (!($subj=="SyncIT File Delivery Receipt"));

        $on$error$resume$next;
$conn        $execute["Select name,email from person where personid = ".$rs["sender_id"]];
        if ($err)
        {
          $dberror$err.$description." [".$err.$number."]";
        } 
        $on$error$goto0;
        $msg=$ps["name"].","."\r\n";
        $msg=$msg."Your Delivery was retrieved: "."\r\n";
        $msg=$msg."   File: ".$fp."\r\n";
        $msg=$msg."   Time: ".strftime("%m/%d/%Y %H:%M:%S %p")()."\r\n";
        $msg=$msg."   Recipient: ".$email."\r\n";
        $msg=$msg."-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._.-._."."\r\n";
        $msg=$msg."Please keep in touch to let us know what you think of our service."."\r\n"."\r\n";
        $msg=$msg."Your BookmarkSync support team."."\r\n";
        $msg=$msg."support@bookmarksync.com";
        $domail"support@bookmarksync.com"        $ps["email"]        $subj        $msg;
        $title=$rs["title"];
        $activity=$rs["activity"]."<br>Downloaded at ".strftime("%m/%d/%Y %H:%M:%S %p")()." from ".$email;
        $sql="update express set activity = '".$activity."' where expressid=".$eid;
//response.write (sql)
        $connexecute[$sql];
        $ps.$close;
        $action=5;
        $rs.$close;
        $syncitexpresspath_session=$path;
      } 

    } 

  } 

} 

if ($email=="")
{
  $email=$email_session;
} 
if ($email=="")
{
  $email=$HTTP_COOKIE_VARS["email"];
} 

if ($action==1)
{

  if ($code!="")
  {

    print "<h4><font color=\"#FF0000\">No delivery available.</font></h4>"."\r\n";
    print "<p>The delivery might have been expired or the tracking number might be invalid.<br>"."\r\n";
    print "Please contact the original sender.";
  } 

}
  else
if ($action==2)
{

  print "<h4>Please fill out the form to retrieve your delivery.</h4>"."\r\n";
}
  else
if ($action==3)
{

  print "<h4><b><font color=\"#FF0000\">Your e-mail address does not match</font></b></h4>"."\r\n";
}
  else
if ($action==4)
{

  print "<h4><b><font color=\"#FF0000\">Your password does not match</font></b></h4>"."\r\n";
}
  else
if ($action==5)
{

  print "<h3><b>Thank you for using SyncIT Express.</b></h3>"."\r\n";
  print "<p><b>Retrieve your document here: <a href=\"download.php\">";
  print $title;
  print "</a></p>"."\r\n";
}
  else
if ($action==6)
{

  print "<h4><b><font color=\"#FF0000\">The delivery does not exist anymore</font></b></h4>"."\r\n";
} 

if ($action<5)
{
?>
            <form method="post" action="retrieve.php" name="frmupload" onsubmit="return checkit(this)">
            <table border="0">
              <tr>
                <td  class="menub" align="right">Tracking #</td>
                <td class="register"><input type="text" name="code" size="30" class="register" value="<?   echo $code; ?>"></td>
              </tr>
              <tr>
                <td class="menub" align="right">Your E-mail</td>
                <td class="register"><input type="text" name="email" size="30" class="register" value="<?   echo $email; ?>"></td>
              </tr>
<?   if ($pass!="" || $action==1)
  {
?>
              <tr>
                <td class="menub" align="right">Password</td>
                <td class="register"><b><input type="password" name="pass" size="20" class="register"></b></td>
              </tr>
<?   } ?>
              <tr>
                <td>&nbsp;</td>
                <td><input border="0" src="../images/btnok.gif" name="I1" type="image" width="62" height="16" alt="OK"></td>
              </tr>
            </table>
	</form>
<? } ?>
            </td>
          <td width="10" valign="top">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<!-- #include file = "../common/footer.inc" -->
</body>
</html>















