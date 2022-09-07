<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#emenu.php
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

      <table width="117" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="18" valign="top" class="bgmenu"><img src="../images/leftbar1.gif" width="18" height="56" vspace=5 alt=""></td>
          <td width="99" valign="top" bgcolor="#33FF00" background="../images/menu_express.gif"><img vspace=0 src="../images/expresslogo.gif" width="99" height="103" alt="">
            <div class="exdiv<? echo $BrowserType[]; ?>">
              <p class="menub">
                <br>
<? 
  $emenu=array(
    "HOME","../express/default.php",
    "DELIVER","../express/deliver.php",
    "RETRIEVE","../express/retrieve.php",
    "ACTIVITY","../express/activity.php",
    "-","-",
    "PROFILE","../common/profile.php",
    "PRIVACY","../common/policy.php",
    "HELP","javascript:showhelp(7)",
    "-","-");

//PARTNERSHIP",		"../common/partner.php",	_

  $eimages=array(
    "src='../images/yemark.gif' width='9' height='15' align='absmiddle' alt='*'",
    "src='../images/emark.gif' width='9' height='15' align='absmiddle' alt='&gt;'",
    "src='../images/edot_on.gif' width='26' height='10' align='absmiddle' alt='*'",
    "src='../images/edot_off.gif' width='26' height='10' align='absmiddle' alt='o'"
	);

ShowMenu($emenu,$eimages;);

?>
              </p>
            </div></td>
        </tr>
        <tr>
          <td colspan="2" width="117" valign="top"><img src="../images/flagexpress.gif" width="117" height="84" alt=""></td>
        </tr>
      </table>

