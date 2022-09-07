<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#invite.php
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
include '../inc/mail.php';

restricted("../collections/invite.php?");

$GLOBALS['mainmenu']="PUBLISHED";
$GLOBALS['submenu'] = "INVITE";

$ref = "";
$pubid = "";
$allemail = "";
$fromemail = "";
$fromname = "";
$comments = "";
$pubtitle = "";
$MyMsg = "";

if (isset($_GET['ref']) && $_GET['ref'] != ""){
	$ref = $_GET['ref'];
	$GLOBALS['mainmenu'] = $ref;
}

$ID = $_SESSION['ID'];

$pubid = request("pid");
if ($pubid == "")
	$pubid = syncit_ncrypt($_SESSION['curcol']);

if ($pubid == "")
	myredirect("../collections/default.php");

$pid = syncit_ndecrypt($pubid);
if ($pid == 0)
	myRedirect($_SERVER['HTTP_REFERER']);

if (!db_connect())
	die();

$_SESSION['curcol'] = $pid;

if (isset($_POST['email']))
	$allemail = $_POST['email'];

$fromemail = $_SESSION['email'];
$fromname = $_SESSION['name'];

if ($allemail != ""){
	if (isset($_POST['comments']))
		$comments = $_POST['comments'];
	if (isset($_POST['pubtitle']))
		$pubtitle = $_POST['pubtitle'];
	
	$token=$HTTP_POST_VARS["pid"];
	//		012345678901234567890123456789012345678901234567890123456789012345678901
	$body="It is my pleasure to inform you that your friend " . $fromname;
	$body .= " thought you might like this collection of web sites:";
	$body .= makereply($body);
	$body .= "\r\n";
	$body .= "Collection: ".$pubtitle . "\r\n\r\n";
	if ($comments != "")
	    $body .= makereply($comments) . "\r\n\r\n";

	$body .= "To preview and subscribe to this free invitation visit\r\n";
	$body .= "      http://syncit.com/tree/cview.php?invite=".$token . "\r\n\r\n";
	$body .= "BookmarkSync can keep your browser bookmarks synchronized too,\r\n";
	$body .= "and can make sure you always have an up-to-date copy of the\r\n";
	$body .= "bookmark publication " . $pubtitle . ".\r\n";
	
	$subject="BookmarkSync Invite from " . $fromname;

	do {
		$I = strpos($allemail,"\r\n");
		if ($I == 0)
			break;
		
		$toemail = substr($allemail,0,$I-1);
		$allemail = substr($allemail,strlen($allemail)-(strlen($allemail)-$I));
		if (is_email_valid($toemail))
			domail($fromemail,$toemail,$subject,$body);
		$sql = "Insert into invitations (personid,email,publishid,invited) Values (" . $ID . ",'" . $toemail . "'," . $pid . ",now())";
		mysql_query($sql);
	} while (!($toemail == $allemail));

	if (is_email_valid($allemail))
		domail($fromemail,$toemail,$subject,$body);

	$sql = "Insert into invitations (personid,email,publishid,invited) Values (" . $ID . ",'" . $toemail . "'," . $pid . ",now())";
	mysql_query($sql);

	$MyMsg = "The invitation has been sent to <hr align=left size=1 width='50%'><font color='#770000'>" . str_replace("\r\n","<br>",$_POST['email']) . "</font><hr align=left size=1 width='50%'><br>";
}
else {
	$res = mysql_query("Select person.name,publish.title from person,publish where person.personid = publish.user_id and publishid = " . $pid);
	if (!$res)
		dberror("Cannot retrieve publication in invite.php");
	$data = mysql_fetch_assoc($res);
	$pubtitle = "'" . $data['title'] . "' by " . $data['name'];
} 

if (isset($_GET['addbm']) && $_GET['addbm'] != "")
	$MyMsg = "The collection has been added to your publications<br>Now it's time to invite someone.<br>";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<title>BookmarkSync Invite to Collection</title>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>
<script language="JavaScript">
<!--
function checkit (f) {
	if ((f.email.value == "")) {
		alert ("Please enter one or more E-mail addresses on seperate lines");
		return (false);
	}
	else {
		return true;
	}
}
-->
</script>

<body bgcolor="#FFFFFF" text="#000000" link="#3333FF" vlink="#990099" alink="#CC0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="111" valign="top">
<?php include '../inc/cmenu.php'; ?>
    </td>
    <td width="511" valign="top">
      <table width="511" border="0" cellspacing="0" cellpadding="0">
<?php include '../inc/chead.php'; ?>
          <td width="10">&nbsp;</td>
          <td width="491" valign="top">
            <br><img src="../images/iconinvite.gif" width="87" height="69" align="right" hspace="5" vspace="5" alt="Invite">
           <font color="#FF0000"><b><? echo $MyMsg; ?></b></font>
              <h2>Invite someone</h2>
		Share your collection with your friends. If you set the category
            of your collection as *Private* it will not appear in the public lists.<br>
            You can enter as many e-mail addresses as you like, one per line.<br>
            <br clear="all">
            <form method="POST" action="invite.php" onsubmit="return checkit(this)">
            	<input type="hidden" name="pid" value="<? echo $pubid; ?>">
            	<input type="hidden" name="pubtitle" value="<? echo $pubtitle; ?>">
              <table border="0" cellpadding="2" cellspacing="2">
                <tr><td align="right" class="menub">Collection: </td><td><? echo $pubtitle; ?></td></tr>
                <tr><td align="right" class="menub">From: </td><td><? echo $fromname; ?> [<i><? echo $fromemail; ?></i>]</td></tr>
                <tr>
                  <td align="right" class="menub">E-MAIL: </td>
                  <td>
                    <textarea name="email" rows="6" class="register" cols="30"></textarea>
                  </td>
                </tr>
                <tr>
                  <td align="right" class="menub"> &nbsp;&nbsp;COMMENTS:&nbsp;</td>
                  <td>
                    <textarea name="comments" rows="6" class="register" cols="30"></textarea>
                  </td>
                </tr>
                <tr>
                  <td align="right" class="menub">&nbsp;</td>
                  <td align="right">
                    <input type="image" border="0" name="imageField" src="../images/btninvite.gif" width="62" height="16" alt="Invite">
                  </td>
                </tr>
              </table>
            </form>
            <img src="../images/psep.gif" width="491" height="4" vspace="5" alt><br>
              <img src="../images/iconwordout.gif" width="149" height="81" align="right" alt="Get the word out!">
            <h2>Put your collection on the web.</h2>
            Any visitor to your web site can subscribe to your published collection.
            <br clear="all">
            <form>
            <div class="menub"> &nbsp;Copy the code below to your Web Page </div>
              <textarea name="textfield4" class="longbox" rows="4" cols="30"><a href="http://syncit.com/tree/cview.php?invite=<? echo $pubid; ?>">
<img src="http://syncit.com/images/button4.gif" alt="MySync Bookmark Collection">
</a>
              </textarea>
            </form>
            <a target="_blank" href="../tree/cview.php?invite=<? echo $pubid; ?>">
            <img vspace="5" border="0" src="../images/button4.gif" align="absmiddle" hspace="3" alt="MySync Bookmark Collection" width="88" height="33"></a>&nbsp;&nbsp;
            <b>&lt;--</b> It will appear <a target="_blank" href="../tree/cview.php?invite=<? echo $pubid; ?>">
like this</a>
          </td>
          <td width="10" valign="top">&nbsp;</td>
      </table>
    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
</html>

