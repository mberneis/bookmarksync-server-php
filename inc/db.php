<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#db.php
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

$newsid = 694;
if (runninglocal())
	$newsid = 2;



function runninglocal()
{
	$testip = substr($_SERVER['REMOTE_ADDR'],0,3);
	if ($testip == "10." || $testip == "127")
		return true;
	return false;
}


// myredirect(url)
//
// Close the database connection, then redirect to 
// another page.
// 
function myredirect($url)
{
//	mysql_close();
	header("Location: ".$url);
	exit();
} 


// MD5Pwd()
//
// The MD5Pwd() function returns the base-64 encoded MD5 hash
// of the user's e-mail address and password combined with a
// site-specific hash.
//
// $md5 is of type "FishX.MD5"
function MD5Pwd($email,$pass)
{
	return md5($email . $pass);
} 


// GetID()
//
// The GetID function attempts to retrieve the currently logged-in
// user's personid.
//
// If the user is currently logged in and has a current session, then
// the "ID" session variable is returned.
//
// If the user's session has timed out (say, perhaps the user stepped
// away from the computer, or has bookmarked the page), then a log
// in is attempted using the 'email' and 'pass' cookies.  If these
// cookies are present, email is a valid entry in the person table,
// and pass is a valid MD5 hash of the email and *real* password,
// then the personid value is returned.
//
// Otherwise, an empty string is returned.
//
function GetID()
{
	if (!isset($_SESSION['ID']))
		return 0;

	$id = $_SESSION['ID'];

	if ($id == 0){

		if (!isset($_COOKIE['email']) || !isset($_COOKIE['md5']))
			return 0;

		$email = $_COOKIE['email'];
		$pass = $_COOKIE['md5'];
		if ($pass != ""){
			if (!db_connect())
				die();
			$res = mysql_query("select pass,personid,name,partner_id,token from person where email='" . $email . "'");
			if (!$data = mysql_fetch_assoc($res))
				return 0;

			if ($pass == MD5Pwd($email,$data['pass'])){
				$id = $data['personid'];
				$_SESSION['ID'] = $data['personid'];
				$_SESSION['name'] = $data['name'];
				$_SESSION['email'] = $email;
				$_SESSION['partner_id'] = $data['partner_id'];
				$_SESSION['token'] = intval($data['token']);
				$_SESSION['license'] = 1;
				$_SESSION['daysregistered'] = 1;
				if ($_SESSION['license'])
					$_SESSION['popup'] = "true";
			} 
			
		}
	} 

	return $id;
} 


// checkuser()
// Place in front of a web-page that isn't password protected.
//
// This function sets the ID global variable to the personid
// of the logged-in user.  The ID variable is ideally kept in
// a session variable, but if the user's session has timed out
// (say, perhaps the user stepped away from the computer, or
// has bookmarked the page), the the ID variable is retrieved
// if the email, pass cookies are set, and are correct.
//
// The ID variable is set if logged in, or 0 if not.
//
function checkuser()
{
	return GetID();
} 

// restricted(url)
// Place in front of a web page that should be password protected.
// The url parameter is the relative URL of the page being protected.
//
// The basic upshot is that the user is allowed access (the subroutine
// returns normally) if:
// 1) The user is already in a 'session' (the "ID" session variable is
//    currently set; or
// 2) The user has the 'email' and 'pass' cookies set, and they're
//    correct.  The pass is really an MD5 hash of the email and *real*
//    password.
//
// All other conditions (no cookies, email address doesn't refer to a
// person in the BookmarkSync registration db, or the MD5 password is
// incorrect) result in a redirection to login.php, with a parameter
// so login.php can redirect back to the proper page when done.
//
function restricted($url)
{
	if (GetID() == 0)
		myredirect("../common/login.php?refer=" . $url);

	if ($_SESSION['token'] > 20 && $_SESSION['daysregistered'] > 30 && ($_SESSION['license'] == false))
		myredirect("../common/presales.php?expired=true&token=" . $_SESSION['token']);
} 


function dberror($errstr)
{
	echo "Our database is experiencing temporary problems.<br>The site administrator has been notified.<hr>";
	echo "Please try again shortly...";
	echo "<br><h6><font color='#FF0000'>" . $errstr . "</font></h6>";
	exit();
} 


function count_bookmarks($id)
{
//	if (!db_connect())
//		die();

	$res = mysql_query("select bookid from bookmarks inner join link on link.book_id = bookmarks.bookid where link.person_id=" . $id);
	if (!$res){
		dberror("Cannot retrieve bookmark count!");
		return -1;
	}

	$count = mysql_num_rows($res);
	mysql_free_result($res);
	return $count;
}


//-----------------------------------------
// global db connect function
// change username / pw here
//-----------------------------------------
function db_connect()
{

	if (@mysql_connect("yourserver.com","username","password")){
		if (@mysql_select_db("your database name"))
			return true;
	}

	// else we got an error
	echo "Our database is temporarily offline.<br>The site administrator has been notified.<hr>Please try again shortly...";
	echo "<br><font color='#FF0000'><small>and please check u started the database dummy!</small></font>";
	header("Status: 500 Database error");
	return false;
}


//********************************************
//* Actual Code to run
//********************************************

checkuser();
?>