<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#redir2.php
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
// Option $explicit;


// $conn is of type "ADODB.Connection"

$conn=mysql_connect("localhost","","");
mysql_select_db("",$conn);
//websync", ""

$u=$HTTP_GET_VARS["u"];
$b=$HTTP_GET_VARS["b"];
$p=$HTTP_GET_VARS["p"];

$rs_query=mysql_query(("Select url from bookmarks where bookid=".$b),$conn);
$rs=mysql_fetch_array($rs_query);
if (!($rs==0))
{
  $url=$rs["url"];
} 

if ($p==709920)
{
// log
} 
$sql="Insert into buttugly_redir (person_id,publish_id,book_id,access) Values (".$u.",".$p.",".$b.",getDate())";
mysql_query(($sql),$conn);conn.close
set conn=Nothing
if p = 709920 then 
	response.write "<script>top.location.href='" + url + "';</script>"
	response.end
end if
response.redirect url
%>

