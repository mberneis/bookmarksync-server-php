<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#ymenu.php
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

<script language=javascript>
<!--
function showremote() {
	var uagent=navigator.userAgent;
	var tempIndex = uagent.indexOf("MSIE");
	if(tempIndex != -1){
		bVer = parseInt(uagent.charAt(tempIndex + 5));
		if (bVer > 5) {
			open ("../tree/remote.php?target=_main","_search");
			return;
		}
	} 
	window.open("../tree/remote.php","sremote","width=300,height=screen.availHeight,menubar=0,toolbar=0,resizable=1,scrollbars=1");
}
//-->
</script>
      <table width="117" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="18" valign="top"><img src="../images/leftbar1.gif" width="18" height="56" alt=""></td>
          <td width="99" valign="top" background="../images/menu_bmbg.gif" bgcolor="#FFCC00" height="1" class="menub">
            <div class="bmdiv<? echo BrowserType(); ?>"><img src="../images/black.gif" width="99" height="1" alt=""><br>
              <p class="menub">
          
<?php
  $ymenu = array(
    "HOME","../bms/default.php",
    "VIEW","../tree/view.php",
    "VIEW|FRAME","../bms/frame.php",
    "VIEW|REMOTE","# target='sremote' onclick='showremote();'",
    "EDIT","../tree/edit.php",
    "UTILITIES","../bms/util.php",
    "UTILITIES|QUICK ADD","../bms/quickadd.php",
    "UTILITIES|AVANTGO","../bms/avantgo.php",
    "UTILITIES|EXPORT","../bms/export.php",
    "UTILITIES|UNDELETE","../bms/undelete.php",
    "UTILITIES|DUPLICATES","../bms/duplicate.php",
    "SEARCH","../bms/searchbm.php",
    "-","-",
    "DOWNLOAD","../download/default.php",
    "-","-",
    "PROFILE","../common/profile.php",
	);

//PARTNERSHIP",		"../common/partner.php",	_

  $yimages = array(
    "src='../images/rmark.gif' width='9' height='13' align='absmiddle' alt='*'",
    "src='../images/ymark.gif' width='9' height='13' align='absmiddle' alt='&gt;'",
    "src='../images/yydot_on.gif' width='23' height='8' align='absmiddle' alt='*'",
    "src='../images/yydot.gif' width='23' height='8' align='absmiddle' alt='o'"
	);


ShowMenu($ymenu,$yimages);

?>
              </p>
            <p>&nbsp;</p>
            <p><br>
            </p>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" width="117" valign="top"><img src="../images/flagbm.gif" width="117" height="47" alt=""></td>
        </tr>
      </table>
     

