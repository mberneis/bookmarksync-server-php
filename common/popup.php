<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#popup.php
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
  session_register("popup_session");
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>Purchase Client License</title>
<link rel="StyleSheet" href="../common/syncit.css" type="text/css">
</head>
<script>
function showit() {
	onerror=null;
	creator = window.open ('/common/presales.php','syncitmain');
	creator.focus();
	self.close();
}
</script>
<body bgcolor="#FFFFFF" text="#000000" link="#660066" vlink="#990000" alink="#CC0099" topmargin=8>
<center>
<!--<img src="../images/logo1.gif"><br>--><h2>Important Notice</h2></center>
            <p>
Starting November 1, 2001, BookmarkSync will be available for <B>a one-time fee</B> 
of $50. Paid customers will receive the software and unlimited, ad-free 
access to our web services for life. 
</p>
<p><Font color='red'><b>As several of our clients had problems purchasing a license over last weekend we agreed to extend our deadline till Sunday, Nov 4th.
</b></font></p>
<p>
<b>During this presale you will receive a 20% discount.</b><br>This means 
you pay a one-time $40 charge to receive unlimited 
future access to our service. <br>
<br>
<a href="http://september11fund.org" target=_blank><img alt="September 11 Fund" src="sep11fund.gif" vspace=6 hspace=8 border=0></a>
<br><b>
In addition, during the presale period, we will donate 20% of incoming revenue 
 to the <a href="http://september11fund.org" target=_blank>September 11th Fund</a> to support the victims of the September 11 terrorist attack on the United States.</b>
</p><center>
            <form target=opener action="/common/presales.php"><input onClick="showit()" type=button value="More Information" class="pbutton"></form></center>
</body>
<? $popup_session="true";
?>
</html>
 
