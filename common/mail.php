<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#mail.php
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

// reptext(line, prefix)
//
// split a single line on word boundaries.  Lines are as long
// as they can get without exceeding 70 characters.  Lines are
// prefixed with the string specified by the pretxt argument,
// and are suffixed with CR LF.
//
function reptext($iline,$pretxt)
{
  global extract($GLOBALS);



//Split single line on word boundaries
  $cutoff=70;
  $ltxt="";
  while(strlen($iline)>$cutoff)
  {

    $i=$cutoff;
    while($i>0 && substr($iline,$i-1,1)!=" ")
    {

      $i=$i-1;
    } 
    if ($i==0)
    {
      $i=70; //If no space at all then just cut off
$ltxt=$ltxt.$pretxt.substr($iline,0,$i)."\r\n";
    } 
    $iline=substr($iline,strlen($iline)-(strlen($iline)-$i));
  } 
  if ($iline!="\r\n")
  {

    $function_ret=$ltxt.$pretxt.$iline."\r\n";
  }
    else
  {

    $function_ret=$ltxt;
  } 

  return $function_ret;
} 

// makereply(input, prefix)
//
// creates a word-wrapped, prefixed set of lines of text
// based on an input string.  The idea is to create a
// typical e-mail reply.  For instance:
//    makereply("this is a test message.", "> ")
// returns
//    "> this is a test message"
//
// lines are wrapped at 70 characters
//
function makereply($inptxt,$pretxt)
{
  global extract($GLOBALS);



  $outtxt="";
  do
  {
    $i=(strpos($inptxt,"\r\n") ? strpos($inptxt,"\r\n")+1 : 0);
    if ($i==0)
    {
      break;
    } 

    $outtxt=$outtxt.reptext(substr($inptxt,0,$i-1),$pretxt);
    $inptxt=substr($inptxt,strlen($inptxt)-(strlen($inptxt)-$i-1));
  } while (!(makereply(=$outtxt.reptext($inptxt,$pretxt))));

  return $function_ret;
} 

function domail($xfrom,$xto,$xsubj,$xbody)
{
  global extract($GLOBALS);


  if ($RunningLocal[])
  {

    print "<script language=javascript>"."\r\n";
    print "alert(\"From: ".$xfrom."\nTo: ".$xto."\nSubject: ".$xsubj."\nBody: ".str_replace("\r\n","\n",$xbody)."\");"."\r\n";
    print "</script>";
  }
    else
  {


// $ObjMail is of type "CDONTS.NewMail"

;
  }
;
  }
mail(    $objmail=null;
,,,"From: ".$Send);
mail(,,,"From: ".=$xto);
mail(,,,"From: ".$Body=$xbody."\r\n"."-------------------------------------------------------------------------"."\r\n"."Keep all your Browser Bookmarks synchronized - no matter where you are..."."\r\n"."http://www.bookmarksync.com"."\r\n");
mail(,,,"From: ".$Subject=$xsubj);
mail(,,,"From: ".$From=$xfrom);
    ?>  } 
  return $function_ret;
} 
