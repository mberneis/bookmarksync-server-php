<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#cmenu.php
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

      <table width="119" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="8" valign="top"> <img src="../images/leftbar.gif" width="8" height="56" alt=""><br>
              <br><br><br>
            <br>
          </td>
          <td width="111" background="../images/vermenu.gif" valign="top" bgcolor="#FF9933"><img src="../images/black.gif" width="111" height="1" alt=""><br>
            <div class="colldiv<? echo BrowserType(); ?>">
              <p class="menub">
                
<? 
  $cmenu = array(
    "HOME","../collections/default.php",
    "PUBLISHED","../collections/publication.php",
    "PUBLISHED|VIEW","../tree/cview.php?ref=PUBLISHED",
    "PUBLISHED|INVITE","../collections/invite.php?ref=PUBLISHED",
    "PUBLISHED|MODIFY","../collections/editpub.php?ref=PUBLISHED",
    "ADD NEW","../collections/addpub.php",
    "SUBSCRIBED","../collections/subscription.php",
    "SUBSCRIBED|VIEW","../tree/cview.php?ref=SUBSCRIBED",
    "SUBSCRIBED|INVITE","../collections/invite.php?ref=SUBSCRIBED",
    "-","-",
    "POPULAR","../collections/popular.php",
    "POPULAR|VIEW","../tree/cview.php?ref=POPULAR",
    "POPULAR|INVITE","../collections/invite.php?ref=POPULAR",
    "POPULAR|SUBSCRIBE","../collections/subscription.php?addid=-1",
    "RECENT","../collections/recent.php",
    "RECENT|VIEW","../tree/cview.php?ref=RECENT",
    "RECENT|INVITE","../collections/invite.php?ref=RECENT",
    "RECENT|SUBSCRIBE","../collections/subscription.php?addid=-1",
    "BROWSE","../collections/showcategory.php",
    "BROWSE|VIEW","../tree/cview.php?ref=BROWSE",
    "BROWSE|INVITE","../collections/invite.php?ref=BROWSE",
    "BROWSE|SUBSCRIBE","../collections/subscription.php?addid=-1",
    "SEARCH","../collections/searchcol.php",
    "SEARCH|VIEW","../tree/cview.php?ref=SEARCH",
    "SEARCH|INVITE","../collections/invite.php?ref=SEARCH",
    "-","-",
    "PROFILE","../common/profile.php",
    "-","-");

//PARTNERSHIP",		"../common/partner.php",	_

  $cimages=array(
    "src='../images/yomark.gif' width='17' height='15' align='absmiddle' alt='*'",
    "src='../images/omark.gif' width='17' height='15' align='absmiddle' alt='&gt;'",
    "src='../images/cdot_on.gif' width='33' height='10' align='absmiddle' alt='*'",
    "src='../images/cdot_off.gif' width='33' height='10' align='absmiddle' alt='o'"
	);
 


ShowMenu($cmenu,$cimages);
?>
              </p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
            <p><br>
            </p>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" width="119" valign="top"><img src="../images/flag.gif" width="119" height="78" alt=""></td>
        </tr>
      </table>

