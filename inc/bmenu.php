<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#bmenu.php
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
          <td width="18" valign="top" class="bgmenu"><img src="../images/leftbar1.gif" width="18" height="56" alt=""></td>
          <td width="99" valign="top" class="menulist" background="../images/menu_bluebg.gif" bgcolor="#6633FF"><img src="../images/black.gif" width="99" height="1" alt=""><br>
            <div class="commondiv<? echo BrowserType(); ?>">
              <p class="menuw">
          
<? 
  $bmenu = array(
    "PROFILE","../common/profile.php",
    "PROFILE|REMOVE ME","../common/removeuser.php",
    "-","-",
    "ABOUT US","../common/aboutus.php",
    "-","-");

//ABOUT US|PARTNER",	"../common/partner.php",		_
//ABOUT US|ADVERTISE",	"../common/advertise.php",		_



  $bimages = array(
    "src='../images/ybmark.gif' width='9' height='15' align='absmiddle' alt='*'",
    "src='../images/bmark.gif' width='9' height='15' align='absmiddle' alt='&gt;'",
    "src='../images/bdot_on.gif' width='26' height='10' align='absmiddle' alt='*'",
    "src='../images/bdot_off.gif' width='26' height='10' align='absmiddle' alt='o'"
	);

ShowMenu($bmenu,$bimages);
?>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2" width="117" valign="top"><img src="../images/flagblue.gif" width="117" height="89" alt=""></td>
        </tr>
      </table>

