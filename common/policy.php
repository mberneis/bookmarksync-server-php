<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#policy.php
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

$mainmenu="PRIVACY";
$submenu="";

$referer = $_SERVER['HTTP_REFERER'];
if ($referer == "")
	$referer = "../default.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>SyncIT License Agreement</title>
<link rel="StyleSheet" href="syncit.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#0000CC" vlink="#0000FF" alink="#CC0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<?php include '../inc/bmenu.php'; ?>
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt=""><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt=""></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_policy.gif" width="503" height="37" alt="SyncIT License Agreement"></td>
        </tr>
        <tr>
          <td width="12"><img src="../images/tpix.gif" width="12" height="10" alt=""></td>
          <td width="491" valign="top"><br>
          <!--
            <p><a href="https://www.truste.org/validate/2725"><img src="../images/ClickSeal.gif" width="91" height="73" border="0" align="right" alt="Click to verify TRUSTe statement"></a>
            </p> -->
              <pre class="policy">


       <b><big>SYNCIT PRIVACY POLICY</big></b>
      <a href="policy.php#">http://www.syncit.com/common/policy.php</a> 
  <br clear="all">
                                          last updated on 1 August 2001

    <b>Privacy Policy</b>
    This statement discloses the privacy practices 
    for the BookMarkSync Web site.  

    Questions regarding this statement should be directed to 
    SyncIT.com by e-mail: <a href="mailto:privacy@bookmarksync.com">privacy@syncit.com</a>
     phone: +1 (212) 242-5442
       fax: +1 (646) 349-1213

      mail: 315 7th Avenue, Suite 21-D
            New York, NY  10001
            USA


   1. <b>Description of Service</b>
      BookmarkSync (<a href="http://www.bookmarksync.com">www.bookmarksync.com</a>) is a paid service
      synchronizing &quot;Bookmarks&quot; (also called &quot;Favorites&quot; or just
      &quot;Links&quot;) across browsers on one or several computers connected to
      the Internet.

   2. <b>Notification</b>
      SyncIT will notify you via e-mail and on the front page of any
      changes to this Privacy Policy.

   3. <b>Personal information</b>
      There are three types of registration information collected by
      SyncIT:
      a. Your name -- this is used to identify yourself to other
         SyncIT members, if you choose to publish bookmarks.

         <b>If you do not publish any bookmarks, no one can see any
         details about you.</b>

         You may use a nickname or alias if you wish.

      b. Your e-mail address -- this is your unique user name or ID.
         We have a strict anti-SPAM policy, see item 6 below.

      c. Profile information -- this includes your mailing address,
         phone number, age, and gender.  You do not need to specify
         this information.  If you do enter this information, it will
         be used internally for statistic purposes. We will not pass 
         this information to other parties.

      Under no circumstances will SyncIT allow outside access to your
      private information, unless SyncIT is legally obligated to.  

   4. <b>Bookmarks</b>
      Your bookmarks are private - If you publish certain sub-sets of
      your bookmarks, these bookmarks become available to other
      BookmarkSync users only if you choose to do so.

   5. <b>Security</b>
      All of our servers are running in a tier one data-center with 24
      hour security.  Only SyncIT staff are authorized to access these
      machines.  All data used by BookmarkSync is kept on a dedicated
      database server removed from the Internet.  Keep in mind that data
      transmitted across the Internet is inherently insecure.

   6. <b>No Spam!</b>
      SyncIT will *not* release your e-mail address to any outside
      agency, unless SyncIT is legally obligated to.

      <b>*** Your e-mail address is not for sale. ***</b>

   7. <b>Update</b>
      Our site provides you the ability to change and modify information 
      you've previously provided.

      <b>Visit </b><a href="profile.php">http://www.syncit.com/common/profile.php</a>
<b>         to change your profile.
      Visit </b><a href="removeuser.php">http://www.syncit.com/common/removeuser.php</a>
<b>         to remove all your information from this system.</b>

   8. <b>No hidden functionality!</b>
      SyncIT products do exactly what they say they do, and no more. Our
      bookmark synchronizer will NOT access any other information on
      your computer. 

  9. <b>Cookies</b>
      A cookie is a small data file that certain Web sites write to your
      hard drive when you visit them.  A cookie can't read data off your
      hard disk or read cookie files created by other sites.  SyncIT
      uses permanent cookies in only two instances, and then only if you 
      are a registered user: we store your email address to track your 
      session, and, if you allow us to, we store your password to make 
      logging in easier.
  	  
  10. <B>Notification of changes</B>
      If, in the future, we change our privacy policy with respect to 
      the way that we use the <font color=#CC0000>Personally Identifiable Information</font> that 
      we collect from you, we will notify you by email of these changes.  
      You can always check our privacy statement for any future changes.

</pre>
              <p><a href="<? echo $referer; ?>" onclick="history.back();"><img border="0" src="../images/btnback.gif" alt="Back to previous page" width="62" height="16"></a></p>
            </td>
          <td width="10" valign="top">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
</html>

