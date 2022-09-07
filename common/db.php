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

<?
  session_name("syncitmain");
	session_start();
  session_register("ID_session");
  session_register("name_session");
  session_register("email_session");
  session_register("partner_id_session");
?>
<? 

if (RunningLocal())
{

  $NewsID=2;
}
  else
{

  $NewsID=694;
} 


function RunningLocal()
{
  global extract($GLOBALS);



  if (!$DoUpload)
  {
    $testip=substr(${"REMOTE_ADDR"},0,3);
  } 
  $function_ret=($testip="10."|$testip="127");
  return $function_ret;
} 


// myredirect(url)
//
// Close the database connection, then redirect to 
// another page.
// 
function myredirect($url)
{
  global extract($GLOBALS);


  $on$error$resume$next;
  $conn.$close;
  $conn=null;

  header("Location: ".$url);
  exit();

  return $function_ret;
} 

// MD5Pwd()
//
// The MD5Pwd() function returns the base-64 encoded MD5 hash
// of the user's e-mail address and password combined with a
// site-specific hash.
//
function MD5Pwd($email,$pass)
{
  global extract($GLOBALS);



// $md5 is of type "FishX.MD5"

  $md5.$Init[];
  $md5.$Update["syncit.com"]; // site-specific salt
$md5.$Update[$email];
  $md5.$Update[$pass];

  $function_ret=$md5.$Final;

  $md5=null;

  return $function_ret;
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
  global extract($GLOBALS);



  $id=intval(("0".$ID_session));

  if ($id==0)
  {

    $email=$HTTP_COOKIE_VARS["email"];
    $pass=$HTTP_COOKIE_VARS["md5"];
    if ($pass!="")
    {

$conn      $execute["SELECT pass, personid, name, partner_id FROM person WHERE email='".$email."'"];

      if (!$rs$eof)
      {

        if ($pass==MD5Pwd($email,$rs["pass"]))
        {

          $id=$rs["personid"];
          $ID_session=$id;
          $name_session=$rs["name"];
          $email_session=$email;
          $partner_id_session=$rs["partner_id"]."";
        } 

      } 


      $rs.$close;
      $rs=null;

    } 

  } 


  $function_ret=$id;
  return $function_ret;
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
  global extract($GLOBALS);


  $ID=GetID();
  return $function_ret;
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
  global extract($GLOBALS);


  $ID=GetID();

  if ($ID==0)
  {

    myredirect("../common/login.php?refer=".$url);
  } 

  return $function_ret;
} 

function dberror($errstr)
{
  global extract($GLOBALS);


  print "Our database is experiencing temporary problems.<br>The site administrator has been notified.<hr>";
  print "Please try again shortly...";
  print "<br><h6><font color=#FFFFFF>".$errstr."</font></h6>";
  // Unknown response object on line 93
$errstr;
  $conn.$close;
  $conn=null;

//response.status = "500 Database error"
  exit();

  return $function_ret;
} 

function connexecute($sql)
{
  global extract($GLOBALS);


  $on$error$resume$next;
$conn  $execute[$sql];
  if ($err)
  {
    dberror($err.$description." [".$err.$number."]");  } 

  $on$error$goto0;
  return $function_ret;
} 

//********************************************
//* Actual Code to run
//********************************************
$on$error$resume$next;
// $conn is of type "ADODB.Connection"

$conn=mysql_connect("localhost","","");
mysql_select_db("",$conn);
//websync",""
if ($err)
{

  print "Our database is temporarily down. <br>The site administrator has been notified.<hr>";
  print "Please try again shortly...<br><h6><font color=#FFFFFF>".$err.$description." [".$hex[$err.$number]."]</font></h6>";
  // Unknown response object on line 113
$err.$description." [".$hex[$err.$number]."]";
  mysql_close($conn);
  $conn=null;

  header("Status: "."500 Database error");
  exit();

} 

$on$error$goto0;
checkuser();
?>

