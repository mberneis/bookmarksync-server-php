<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#syncit1.php
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
  session_register("bm_conn_session");
?>
<? header("Content-type: "."text/plain");

//*****************************************************************
//*
//* SYNCIT.php
//*
//* Last Modified: 10/2/99
//*
//* Revision History
//* 17/11/98	mb	Added Comments
//* 18/11/98	tw	Changed subscription loop (remove unnecessary
//*         		test) and put email address on subscription name
//* 29/12/98     tw      Removed *M, changed *V for 0.15
//* 10/2/99	mb	Changes for Publisher/Subscriptions Model
//*			Locking changed
//*			Links get expiration
//*
//*****************************************************************

//*** Will be set to true if at least one delete or add statement
$changed=false;



//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//* parses bookmarklist line, processes Adds and Deletes
function parseline()
{
  global extract($GLOBALS);


  $cmd=substr($bm_row,0,1); //*** first char is command
$bm_row=substr($bm_row,strlen($bm_row)-(strlen($bm_row)-3)); // *** strip 1st token
$l=(strpos($bm_row,"\",") ? strpos($bm_row,"\",")+1 : 0); //*** find "
$path=substr($bm_row,0,$l-1); // *** get path
$on$error$resume$next;
  if ($cmd=="A")
  {
// *** Add Bookmark
  } 
  $bm_row=substr($bm_row,strlen($bm_row)-(strlen($bm_row)-3-strlen($path)));
  $l=(strpos($bm_row,"\"") ? strpos($bm_row,"\"")+1 : 0);
  $url=substr($bm_row,0,$l-1);
  $stamp=strftime("%m/%d/%Y %H:%M:%S %p")(); // Now server-generated stamp...
$conn.$execute["Insert into bookmarks (url) Values ('".$url."')"];
$conn  $execute["Select bookid from bookmarks where url='".$url."'"];
  $bid=$bs["bookid"];
  $bs.$close;
  $sql="Insert into link (expiration,person_id,access,path,book_id) Values (Null,".$ID.",'".$stamp."','".$path."',".$bid.")";
  $conn.$execute[$sql];
  if ($Err)
  {
// Bookmark exists already - but expired?: Unexpire!
  } 
  $sql="Update link set expiration = Null where person_id = ".$ID." and path = '".$path."' and book_id = ".$bid;
  $conn.$execute[$sql];
  return $function_ret;
} 
}
  else
if ($cmd=="D")
{
//*** Delete it = Set expiration
$sql="Update link set expiration = '".strftime("%m/%d/%Y %H:%M:%S %p")()."' where path = '".$path."' and person_id = ".$ID;
$conn.$execute[$sql];
}
  else
{

print "*E"."\r\n"."Invalid Bookmark Command: ".$cmd."\r\n";
$function_ret=true; //** error
$exit$function;
	changed = true
	on error goto 0
	parseline = false '** success
end function

'*********************************************** MAIN PROGRAM *********************************************

'*** Get Parameter
email = trim(request.form("Email"))
pass = trim(request.form("Pass"))
version = trim(request.form("Version"))
content = request.form("Contents")
ctoken = CLng(request.form("Token"))

'* Open Database
If IsObject(Session("bm_conn")) Then
    Set conn = Session("bm_conn")
Else
    Set conn = Server.CreateObject("ADODB.Connection")
    conn.open "bm","websync",""
    Set Session("bm_conn") = conn
End If

' *** check email address ***
set ps = conn.execute ("select personid,token,pass from person where email='" & email & "'")
if ps.eof then
	response.write ("*N" & vbCrLf) '*** Unknown User
	response.write ("*Z" & vbCrLf)
	response.end
else
	ID = ps("personid")
	stoken = CLng(ps("token"))
end if
' *** check password ***
if ps("pass") <> pass then 
	response.write ("*P" & vbCrLf)
	response.write ("*Z" & vbCrLf)
	response.end
end if

' *** compare tokens ***
if stoken > ctoken then ' return bookmarklist
	sql = "SELECT path, url, link.access as bmdate FROM link, bookmarks"
	sql = sql & " WHERE bookid=book_id and person_id=" & ID
	sql = sql & " AND expiration is Null ORDER BY path"
	set bs = conn.execute (sql)
	response.write ("*T," & stoken & vbCrLf)
	response.write ("*B" & vbCrLf)
	while not bs.eof
		response.write("""" & bs("path") & """,""" & bs("url") & """,""" & bs("bmdate") & """" & vbCrLf)
		bs.Movenext
	Wend
	bs.close

else
	'*** Bookmarklist seems uptodate - lets process A/D directives now
	if len(Trim(content)) > 0 then
		changed = false
		do
			'*** Go through the A/D commandlist extract line by line and call parseline
			i = instr(content,vbCrLf)
			if i = 0 then exit do
			bm_row = left(content,i-1)
			if parseline() then 
				response.write ("*Z" & vbCrLf)
				response.end
			end if
			content = right(content,len(content) - i -1)
		loop
		'conn.BeginTrans
		conn.execute "UPDATE person SET token = token+1 WHERE personid=" & ID
		set rs = conn.execute("SELECT token from person where personid=" & ID)
		stoken = rs("token")
		rs.close
		'conn.CommitTrans
		if changed then
			'*** Mark all publications with current token
			sql = "UPDATE publish set token = " & stoken & " WHERE user_id=" & ID 
			conn.execute (sql)
		end if	
	end if
	'*** Return new token
	response.write ("*T," & stoken & vbCrLf)
end if

' Return Subscriptions
sql = "select publishID, title, user_id, path, token from publish, subscriptions where subscriptions.person_id=" & id & " and subscriptions.publish_id=publish.PublishID order by title"
set ss = conn.execute (sql)
while not ss.eof
   rtoken = ss("token")
   rid    = ss("publishID")
   plen   = len(ss("path"))+1 ' will add leading backslash soon
   if Request.Form("token" & rid).Count = 1 and CLng(Request.Form("token" & rid)) = rtoken then
   	response.write ("*Q," & rid & ",""" & ss("title") & """," & rtoken & vbCrLf)
   else
   	response.write ("*R," & rid & ",""" & ss("title") & """," & rtoken & vbCrLf)
      sql = "select path, url from bookmarks, link where (link.book_id=bookmarks.bookid) and (link.person_id=" & ss("user_id") & ") and (path like '\" & ss("path") & "\%') and (expiration is null) order by path"
	   set bs = conn.execute (sql)
	   while not bs.eof
	      path=bs("path")
		   response.write("""" & right(path,len(path)-plen) & """,""" & bs("url") & """" & vbCrLf)
		   bs.Movenext
   	Wend
   	bs.close		
   end if
	ss.movenext
wend
ss.close

'*** Close up
response.write ("*Z" & vbCrLf)
response.end
%>

