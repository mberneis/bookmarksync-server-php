<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#header.php
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

if (isset($_SESSION['ad']))
	$_SESSION['ad'] = $_SESSION['ad'] + 1;

$partner_id = "";
$partnerlogo = "";
$partnerurl = "";

if (isset($_GET['sp']))
	$partner_id = $_GET['sp'];

if ($partner_id == "")
	$partner_id = $_SESSION['partner_id'];
else
	$_SESSION['partner_id'] = $partner_id;

if ($partner_id == "")
	$partner_id = 0;

switch ($partner_id){
  case 2:
// Jurisline
    $partnerlogo = "partners/jurisline/logo.gif";
    $partnerurl = "http://www.jurisline.com";
    $_SESSION['partnerpub'] = "712382";
    break;
  case 3:
// Hieros Gamos
    $partnerlogo = "partners/hierosgamos/logo.gif";
    $partnerurl = "http://www.hg.org";
    $_SESSION['partnerpub'] = "716817";
    break;
  case 4:
// doct.org
    $partnerlogo = "partners/doct.org/logo.gif";
    $partnerurl = "http://www.doct.org";
    $_SESSION['partnerpub'] = "716260";
    break;
  case 5:
// Tailwind
    $partnerlogo = "partners/tailwind/logo.gif";
    $partnerurl = "http://www.tailwind.com";
    $_SESSION['partnerpub'] = "716457";
    break;
  case 6:
// MusicPlay
    $partnerlogo = "partners/musicplay/logo.gif";
    $partnerurl = "http://www.musicplay.de";
    $_SESSION['partnerpub'] = "718693";
    break;
  case 7:
// Oktoberfest
    $partnerlogo = "icons/octoberfest.gif";
    $partnerurl = "http://germannews.com/oktoberfest/";
    $_SESSION['partnerpub'] = "719518";
    break;
  default:
    $_SESSION['partner_id'] = 0;
    $_SESSION['partnerpub'] = "";
    break;
}

$_SESSION['partnerlogo'] = $partnerlogo;
$_SESSION['partnerurl'] = $partnerurl;
?>

<!--
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="130" align="center"><a target="_top" href="../"><img src="../images/logo1.gif" width="113" height="52" xvspace="7" hspace="9" border="0" alt="SyncIT.com"></a>
    <? if ($partnerlogo!="")
{
  print "<br><a href=\"".$partnerurl."\"><img border=0 src=\"/".$partnerlogo."\"></a>";} 

?>
    </td>
    <td width="500" align="center">
<? if ($mainmenu=="PRIVACY")
{

  print "<img src=\"../images/oldbanner.gif\">";
}
  else
{

  mt_srand((double)microtime()*1000000);
//randid = 100000 + int(rnd (1) * 1000000)
  $randid=123456; // for now... - experiment with random values later
; ?>
<IFRAME WIDTH=468 HEIGHT=60 SRC="http://ad-adex7.flycast.com/server/iframe/SyncITcom/runofsite/<?   echo $randid; ?>" scrolling="no" marginwidth=0 marginheight=0 frameborder=0 vspace=0 hspace=0>
<A target="_top" HREF="http://ad-adex7.flycast.com/server/click/SyncITcom/runofsite/<?   echo $randid; ?>"><IMG BORDER=0 WIDTH=468 HEIGHT=60 SRC="http://ad-adex7.flycast.com/server/img/SyncITcom/runofsite/<?   echo $randid; ?>"></A>
</IFRAME>

<? } ?>     

 
  </td></tr>
  <tr><td colspan=2><img src="../images/tpix.gif" width="630" height="5" alt=""></td></tr>
</table>
-->

