<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#asp.php
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

//
// 25th feb 2003 - lauren
//
// we changed this in to a piece of executable code to be inserted into the asp.php file
// so that any entry point into the site will have the reqd session and global vars available
// hopefully it'll work and stop michael moaning at me :)-
//
if (!isset($GLOBALS['_gflag_'])){
	$GLOBALS['SUBMEN'] = false;
	$GLOBALS['MAINMENU'] = false;
	$GLOBALS['mainmenu'] = "";
	$GLOBALS['submenu'] = "";
	$GLOBALS['_gflag_'] = true;
}

// declare all session vars here and register them so its out of the way
if (!isset($_SESSION['_sflag_'])){

	$_SESSION['name'] = "";
	$_SESSION['pass'] = "";
	$_SESSION['email'] = "";
	$_SESSION['partner_id'] = "";
	$_SESSION['token'] = "";
	$_SESSION['license'] = "";
	$_SESSION['daysregistered'] = "";
	$_SESSION['popup'] = "";
	$_SESSION['ID'] = "";
	$_SESSION['partnerurl'] = "";
	$_SESSION['partnerlogo'] = "";
	$_SESSION['partnerpub'] = "";
	$_SESSION['ad'] = "";
	$_SESSION['curcol'] = "";
	$_SESSION['target'] = "";
	$_SESSION['RID'] = "";
	$_SESSION['mac_license'] = "";
	$_SESSION['pc_license'] = "";
	$_SESSION['payid'] = "";
	$_SESSION['seed'] = "";
	$_SESSION['aid'] = "";
	$_SESSION['_sflag_'] = true;
}


//-----------------------------------------------
// replacement for the standard my_addslashes()
// function that checks for the magic_quotes
// thingy and does the right thing
//-----------------------------------------------
function my_addslashes($text)
{
	if (get_magic_quotes_gpc() == 0)
		$text = my_addslashes($text);

	return $text;
}


//-----------------------------------------------
// replacement for the standard my_stripslashes()
// function that checks for the magic_quotes
// thingy and does the right thing
//-----------------------------------------------
function my_stripslashes($text)
{
	if (get_magic_quotes_gpc() == 0)
		$text = my_stripslashes($text);

	return $text;
}


//-----------------------------------------------
// logging function to output debug data
//-----------------------------------------------
function debug_clear()
{
	unlink("_debug_info.log");
}

function debug_dump($str)
{
	$fp = fopen("_debug_info.log","a");
	fputs($fp,$str . "\r\n");
	fclose($fp);
}


//-----------------------------------------------
// simulate the asp request thing by trying
// various sources for the requested
// variable returning empty string if
// not found
//-----------------------------------------------
function request ($varname)
{
	if (isset($_GET[$varname]))
		return my_stripslashes($_GET[$varname]);

	if (isset($_POST[$varname]))
		return my_stripslashes($_POST[$varname]);

	if (isset($_SESSION[$varname]))
		return $_SESSION[$varname];

	if (isset($_COOKIE[$varname]))
		return $_COOKIE[$varname];

	return "";
}


function OnTransactionAbort()
{
  print "Our website experiences temporary problems.<br>The site administrator has been notified.<hr>";
  print "Please try again shortly...";
} 


function BrowserType()
{
  $userAgent = $_SERVER['HTTP_USER_AGENT'];

	if (stristr($userAgent,"Opera"))
		return "op";
	else if (stristr($userAgent,"MSIE"))
		return "ie";

	return "ns";
} 


//********************************************
//*** Some useful functions...
//********************************************

function htmltxt($h)
{
	$hx = $h;
	$hx = str_replace("<p>","\r\n\r\n",$hx);
	$hx = str_replace("<br>","\r\n",$hx);
	$hx = str_replace("<hr>","\r\n--------------------------------------------------\r\n",$hx);
	$h = strip_tags($hx);
	return $hx;
} 


function y2k($MyDate)
{
	return $MyDate;
} 


function strip($txt)
{
	return str_replace("'","\\'",$txt);
} 


function strip2($txt)
{
	$s = str_replace("_","[_]",$txt);
	$s = str_replace("%","[%]",$s);
	$s = str_replace("'","''",$s);
	return $s;
} 


function prep($s)
{
	$t = str_replace("\\","%_",$s);
	$t = str_replace("%","%%",$t);
	return $t;
} 


function Unprep($s)
{
	$t = str_replace("%%","%",$s);
	$t = str_replace("%_","\\",$t);
	return $t;
} 


function preps($s)
{
	$t = str_replace("\\","%_",$s);
	$t = str_replace("%","%%",$t);
	$t = str_replace("'","''",$t);
	return $t;
} 


function Unpreps($s)
{
	$t = str_replace("%%","%",$s);
	$t = str_replace("%_","\\",$t);
	$t = str_replace("'","''",$t);
	return $t;
} 


function syncit_crypt($x)
{
	$len = strlen($x);
	$s = "";

	for ($i = 1; $i <= $len; $i++)
		$s .= dechex(ord(substr($x,$i-1,1))-30+$i);
	return $s;
}


function syncit_decrypt($x)
{
	$s="";
	$k=30;
	$len = strlen($x);

	for ($i = 1; $i <= $len; $i += 2){
		$h = hexdec(substr($x,$i-1,2));
		$k--;
		$s .= chr($h+$k);
	} 
	return $s;
}


function syncit_ncrypt($x)
{
	return syncit_crypt(intval($x)*18); 
}


function syncit_ndecrypt($x)
{
	if ($x == "")
		return 0;
	else {
		$ntemp = intval(syncit_decrypt($x));
//		if ($err)
//			$ntemp = -1234;

		$ntemp2 = intval($ntemp/18);
		if ($ntemp2 * 18 == $ntemp)
			return $ntemp2;
		else
			return 0;
	} 
} 


function nohack($s)
{
	$t = str_replace("<","&lt;",$s);
	$t = str_replace(">","&gt;",$t);
	return $t;
} 


function nojhack($s)
{
	$t = str_replace("/","-",$s);
	$t = str_replace("/","-",$t);
	$t = str_replace("\"","",$t);
	$t = str_replace("|","",$t);
	return $t;
} 


function xormail($s)
{
  $x=0;
  for ($i=1; $i<=strlen($s); $i=$i+1)
  {

    $x=$x^ord(substr($s,$i-1,1));

  } 

  $function_ret=$hex[$x];
  if (strlen(xormail())==1)
  {
    $function_ret="0".xormail();
  } 
  return $function_ret;
} 

// MenuItem(mtitle, murl, mimages)
//
// Show a single line of a menu.
// The mtitle parameter can be "-", then the output is "<BR>"
// The mtitle parameter can be a single top-level menu.
//     If it is equal to the global menuitem variable, then
//     mimages(0) is shown, otherwise mimages(1) is shown.
// The mtitle parameter can be a two-level menu separated by VBAR |
//     If the part after the | is equal to the global submenu variable,
//     then mimages(2) is shown, otherwise mimages(3) is shown.
// If murl is not empty, then a link is generated
//
function MenuItem($mtitle,$murl,$mimages)
{
	$b = strpos($mtitle,"|");
	if ($GLOBALS['SUBMEN'] == true || $b == 0){

		if ($mtitle != "-"){
			echo "<img ";
			if ($b > 0){
				$mtitle = substr($mtitle,strlen($mtitle)-(strlen($mtitle)-$b - 1));
				if ($mtitle == $GLOBALS['submenu']){
					echo $mimages[2];
					$murl = "";
				}
				else
					echo $mimages[3];
			}
			else if ($mtitle == $GLOBALS['mainmenu']){
				echo $mimages[0];
				$GLOBALS['SUBMEN'] = true;
			}
			else {
				echo $mimages[1];
				$GLOBALS['SUBMEN'] = false;
			}

			echo ">&nbsp;&nbsp;";

			if ($murl == "")
				echo $mtitle;
			else {
				if ($mtitle == "HELP")
					echo "<a style='cursor:help' href='" . $murl . "'>" . $mtitle . "</a>";
				else
					echo "<a href='" . $murl . "'>" . $mtitle . "</a>";
			} 
		} 

		echo "<br>\r\n";
	}
} 

// ShowMenu(menu, mimages)
//
// Show a menu.  The menu parameter is an array of
// title, url values.  The mimages parameter is an
// array of 4 images (top level current, top level,
// submenu current, submenu).
//
function ShowMenu($menu,$mimages)
{
	$count = count($menu);

	for ($i = 0; $i < $count; $i += 2)
		MenuItem($menu[$i],$menu[$i+1],$mimages);

	if ($_SESSION['ID'] == "" || $_SESSION['ID'] == "0")
		MenuItem("LOG IN","../common/login.php",$mimages);
	else
		MenuItem("LOG OUT","../common/login.php?logout=true",$mimages);
} 


//-----------------------------------------
// chk email addr is maybe valid
//-----------------------------------------
function is_email_valid($address)
{
	if (ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $address))
		return true;
	else 
		return false;
}

?>