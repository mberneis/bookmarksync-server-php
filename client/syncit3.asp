<% Response.ContentType = "text/plain"

'*****************************************************************
'*
'* SYNCIT.php
'*
'* Last Modified: 10/2/99
'*
'* Revision History
'* 17/11/98	mb	Added Comments
'* 18/11/98	tw	Changed subscription loop (remove unnecessary
'*         		test) and put email address on subscription name
'* 29/12/98     tw      Removed *M, changed *V for 0.15
'* 10/2/99	mb	Changes for Publisher/Subscriptions Model
'*			Locking changed
'*			Links get expiration
'* 10/3/99	tw	create/remove directories, allow same path,
'*			different URLs for expired bookmarks
'*****************************************************************

'*** Will be set to true if at least one delete or add statement
changed = false 



'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
'* parses bookmarklist line, processes Adds and Deletes
function parseline ()
	cmd = left(bm_row,1) '*** first char is command
	bm_row = right(bm_row,len(bm_row) -3) ' *** strip 1st token
	l = instr(bm_row,""",") '*** find "
        tpath = left(bm_row,l-1) ' *** get path
	path = replace(tpath,"'","''") ' *** SQL escape single quotes
	on error resume next
	if cmd = "A" then ' *** Add Bookmark
		bm_row = right(bm_row,len(bm_row) - 3 - len(tpath))
		l = instr(bm_row,"""")
		url = left(bm_row,l-1)
		stamp = Now() ' Now server-generated stamp...
		conn.execute ("Insert into bookmarks (url) Values ('" & url & "')")	
		set bs = conn.execute ("Select bookid from bookmarks where url='" & url & "'")
		bid = bs("bookid")
		bs.close
		sql = "Insert into link (expiration,person_id,access,path,book_id) Values (Null," & ID & ",'" & stamp & "','" & path & "'," & bid & ")"
		conn.execute (sql)
		if Err then ' Bookmark exists already - but expired?: Unexpire!
			sql = "Update link set expiration = Null, book_id = " & bid & " where person_id = " & ID & " and path = '" & path & "'"
			conn.execute (sql)
		end if
	elseif cmd = "D" then '*** Delete it = Set expiration
		sql = "Update link set expiration = '" & Now() & "' where path = '" & path & "' and person_id = " & ID
		conn.execute (sql)
	elseif cmd = "M" then '*** MKDIR create directory
		stamp = Now() ' Now server-generated stamp...
		sql = "Insert into link (expiration,person_id,access,path) Values (Null," & ID & ",'" & stamp & "','" & path & "')"
		conn.execute (sql)
		if Err then ' Bookmark exists already - but expired?: Unexpire!
			sql = "Update link set expiration = Null, book_id = Null where person_id = " & ID & " and path = '" & path & "'"
			conn.execute (sql)
		end if
	elseif cmd = "R" then '*** RMDIR remove directory
		sql = "Update link set expiration = '" & Now() & "' where path = '" & path & "' and person_id = " & ID
		conn.execute (sql)
	else
		response.write ("*E"  & vbCrLf & "Invalid Bookmark Command: " & cmd & vbCrLf)
		parseline = true '** error
		exit function
	end if
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
Set conn = Server.CreateObject("ADODB.Connection")
conn.open "bm","websync",""

' *** check email address ***
set ps = conn.execute ("select personid,token,pass from person where email='" & email & "'")
if ps.eof then
	response.write ("*N" & vbCrLf) '*** Unknown User
	response.write ("*Z" & vbCrLf)
	conn.close
	response.end
else
	ID = ps("personid")
	stoken = CLng(ps("token"))
end if
' *** check password ***
if ps("pass") <> pass then 
	response.write ("*P" & vbCrLf)
	response.write ("*Z" & vbCrLf)
	conn.close
	response.end
end if

response.write("*S,Root,""http://" & Request.ServerVariables("LOCAL_ADDR") & "/""" & vbCrLf)

'set bs = conn.execute("SELECT machine, sharename, username, password FROM netuse, netshare WHERE person_id = " & ID & " AND shareid = share_id")
'while not bs.eof
'	response.write("*D,""\\" & bs("machine") & "\" & bs("sharename"),*," & bs("username") & "," & bs("password") & vbCrLf)
'	bs.movenext
'	wend
'bs.close

' *** compare tokens ***
if stoken > ctoken then ' return bookmarklist
        sql = "SELECT path, url, o.src AS io, c.src AS ic FROM link"
        sql = sql & " LEFT JOIN images AS o ON o.imgid = openimg_id"
        sql = sql & " LEFT JOIN images AS c ON c.imgid = closeimg_id, bookmarks"
	sql = sql & " WHERE bookid=book_id and person_id=" & ID
	sql = sql & " AND expiration is Null ORDER BY path"

	set bs = conn.execute (sql)
	response.write ("*T," & stoken & vbCrLf)
	response.write ("*B" & vbCrLf)
	while not bs.eof
		response.write("""" & bs("path") & """,""" & bs("url") & """," & bs("io") & "," & bs("ic") & vbCrLf)
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
				conn.close
				response.end
			end if
			content = right(content,len(content) - i -1)
		loop
		'conn.BeginTrans
		conn.execute "UPDATE person SET token = token+1, lastchanged=getdate() WHERE personid=" & ID
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
        if left(ss("title"), 7) = "Gartner" then
           response.write ("*R," & rid & ",""" & ss("title") & """," & rtoken & ",icons/gartner.bmp" & vbCrLf)
        else
           response.write ("*R," & rid & ",""" & ss("title") & """," & rtoken & vbCrLf)
        end if


        sql = "SELECT path, url, o.src AS io, c.src AS ic FROM link"
        sql = sql & " LEFT JOIN images AS o ON o.imgid = openimg_id"
        sql = sql & " LEFT JOIN images AS c ON c.imgid = closeimg_id, bookmarks"
	sql = sql & " WHERE bookid=book_id and person_id=" & ss("user_id")
	sql = sql & " AND (path LIKE '\" & ss("path") & "\%') AND expiration IS NULL ORDER BY path"

	   set bs = conn.execute (sql)
	   while not bs.eof
	      path=bs("path")
		   response.write("""" & right(path,len(path)-plen) & """,""" & bs("url") & """," & bs("io") & "," & bs("ic") & vbCrLf)
		   bs.Movenext
   	Wend
   	bs.close		
   end if
	ss.movenext
wend
ss.close

'*** Close up
response.write ("*Z" & vbCrLf)
conn.close
response.end
%>
