<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#survey.php
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

include '../inc/asp.php';
include '../inc/db.php';

$GLOBALS['mainmenu'] = "SURVEY";
$GLOBALS['submenu'] = "";

if (!db_connect())
	die();

$email = "";
if (isset($_POST['email']))
	$email = $_POST["email"];

if ($email != ""){
/*
	$conn  $execute["SELECT TOP 1 * FROM [survey].[dbo].[survey1]"];
	if ($err)
	{
	$dberror$err.$description." [".$err.$number."]";
	} 
	$on$error$goto0;
	$sql_t="";
	$sql_v="";
	for ($j=1; $j<=$rs.$fields.$count-1; $j=$j+1)
	{
	
	$lbl=$rs.$fields[$j].$name;
	if ($lbl=="created")
	{
	
	$val=strftime("%m/%d/%Y %H:%M:%S %p")();
	}
	else
	{
	
	$val=str_replace("'","''",$HTTP_POST_VARS[$lbl]);
	} 
	
	$sql_t=$sql_t.$lbl.",";
	$sql_v=$sql_v."'".$val."',";
	
	} 
	
	$sql="INSERT INTO [survey].[dbo].[survey1] (".substr($sql_t,0,strlen($sql_t)-1).") values (".substr($sql_v,0,strlen($sql_v)-1).")";
	//response.write (sql)
	$connexecute[$sql];
	$rs.$close;
	//body = "Thank you very much for responding to our survey." & vbCrLf
	//body = body & "Please visit http://bookmarksync.com/syncitshuttle.php for your paper airplane." & vbCrLf
	//body = body & "" & vbCrLf
	//body = body & "We appreciate your support!" & vbCrLf
	//body = body & "Best Regards," & vbCrLf
	//body = body & "" & vbCrLf
	//body = body & "Michael Berneis" & vbCrLf
	//body = body & "" & vbCrLf
	//body = body & "CEO" & vbCrLf
	//body = body & "CEO@SyncIT.com" & vbCrLf
	//body = body & "" & vbCrLf
	//body = body & "Tell your friends about BookmarkSync, the award-winning" & vbCrLf
	//body = body & "bookmark and favorite places synchronization service from SyncIT.com" & vbCrLf
	//body = body & "http://bookmarksync.com/refer.php" & vbCrLf
	//domail "support@bookmarksync.com",email,"Your Paper Airplane from SyncIT.com",body
*/
} 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">
<meta http-equiv="Content-Language" content="en-us">
<title>Survey</title>
<link rel="StyleSheet" href="syncit.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#660066" vlink="#990000" alink="#CC0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<?php include '../inc/bmenu.php'; ?>
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" bgcolor="#6633FF" width="503"><a href="../bms/default.php"><img src="../images/horbtn_bmup.gif" width="120" height="18" border="0" alt="BookmarkSync"></a><a href="../collections/default.php"><img src="../images/horbtn_collup.gif" width="147" height="18" border="0" alt="MySync Collections"></a><img src="../images/horbtn_newsup.gif" width="124" height="18" border="0" alt=""><img border="0" src="../images/horbtn_exup.gif" width="112" height="18" alt=""></td>
          <td rowspan="2" width="10" valign="top"><img src="../images/rightbar.gif" width="10" height="55" alt=""></td>
        </tr>
        <tr>
          <td colspan="2" width="503" height="37" bgcolor="#000066"><img src="../images/heading_survey.gif" width="503" height="37" alt="SyncIT Survey"></td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br><h2>Thank you for making us #1</h2>
<?php
if ($email != ""){
?>
            <h4>We have received your survey results.</h4>
            <p>Thank you for you participation.&nbsp;</p>
            <p><b>If you have nor received the famous SyncIT Shuttle you can get
            it <a href="syncitshuttle.php">NOW</a>!&nbsp;</b></p>
<?php
}
else {
?>
<script language="JavaScript"><!--
function validate(theForm)
{

  if (theForm.compusers_weekly.selectedIndex == 0)
  {
    alert("The first 'Weekly use' option is not a valid selection.  Please choose one of the other options.");
    theForm.compusers_weekly.focus();
    return (false);
  }

  if (theForm.total_computers.selectedIndex < 0)
  {
    alert("Please select one of the 'Total Computers' options.");
    theForm.total_computers.focus();
    return (false);
  }

  if (theForm.total_computers.selectedIndex == 0)
  {
    alert("The first 'Total Computers' option is not a valid selection.  Please choose one of the other options.");
    theForm.total_computers.focus();
    return (false);
  }

  if (theForm.gender.selectedIndex < 0)
  {
    alert("Please select one of the 'Gender' options.");
    theForm.gender.focus();
    return (false);
  }

  if (theForm.gender.selectedIndex == 0)
  {
    alert("The first 'Gender' option is not a valid selection.  Please choose one of the other options.");
    theForm.gender.focus();
    return (false);
  }
  return (true);
}
//--></script>
		<form method="POST" action="survey.php" onsubmit="return validate(this)">

            <p> A
            free service of SyncIT.com, BookmarkSync is the most popular
            bookmark service available on the web - and we want you to tell us
            how we can stay #1.<br>Please fill out the survey below. We look
            forward to your feedback.&nbsp;</p>
            <h4>
            <img height="10" src="../images/psep.gif" width="491" alt=""><b><br>
            Please
            rate BookmarkSync usability:</b></h4>
            <table border="0" width="491">
              <tr>
                <td width="50%" colspan="5">Easy
                  to use</td>
                <td width="50%" colspan="5" align="right">Difficult</td>
              </tr>
              <tr>
                <td width="10%" align="center">10<input type="radio" value="10" name="usability">

                </td>
                <td width="10%" align="center">9<input type="radio" value="9" name="usability"></td>
                <td width="10%" align="center">8<input type="radio" value="8" name="usability"></td>
                <td width="10%" align="center">7<input type="radio" value="7" name="usability"></td>
                <td width="10%" align="center">6<input type="radio" value="6" name="usability"></td>
                <td width="10%" align="center">5<input type="radio" value="5" name="usability"></td>
                <td width="10%" align="center">4<input type="radio" value="4" name="usability"></td>
                <td width="10%" align="center">3<input type="radio" value="3" name="usability"></td>
                <td width="10%" align="center">2<input type="radio" value="2" name="usability"></td>
                <td width="10%" align="center">1<input type="radio" value="1" name="usability"></td>
              </tr>
            </table>
            &nbsp;
            <h4>
            <img height="10" src="../images/psep.gif" width="491" alt=""><b><br>
            Were
            downloading instructions easy to understand?</b></h4>
            <table border="0" width="100%">
              <tr>
                <td width="50%">
               Yes<input type="radio" name="download_Instruction" value="yes" checked>
               No
               <input type="radio" name="download_Instruction" value="no">
               &nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="50%" align="right">
               <b>Comments</b>:</td>
              </tr>
              <tr>
                <td width="100%" colspan="2">
 <input class="longbox" type="text" name="download_issues" size="30"></td>
              </tr>
            </table>
            <h4>
            <img height="10" src="../images/psep.gif" width="491" alt=""><b><br>
            Have you
            encountered any issues with our service?<br>
            </b><textarea class="longbox" rows="3" name="other_issues" cols="31"></textarea></h4>
            <h4>
            <img height="10" src="../images/psep.gif" width="491" alt=""><b><br>
            Would you recommend
            BookmarkSync to your friends? Why or why not?&nbsp;<br>
            If so - please do! We need your help to get the word out to friends,
            colleagues and relatives about our free service.<br>
            </b><textarea class="longbox" rows="3" name="recommendation" cols="31"></textarea></h4>
            <h4><img height="10" src="../images/psep.gif" width="491" alt=""><b><br>
            What are your top
            reasons for using our service?
            </b></h4>
            <table border="0">
             <tr><td width="18"><input type="checkbox" name="use_travel" value="yes"></td>
                 <td>Travel frequently</td></tr>
             <tr><td width="18"><input type="checkbox" name="usemanybookmarks" value="yes"></td>
                 <td>Use many bookmarks</td></tr>
             <tr><td width="18"><input type="checkbox" name="usepublications" value="yes"></td>
                 <td>Use
                  BookmarkSync publications frequently</td></tr>
             <tr>
              <td width="18"><input type="checkbox" name="usemultiplecomputers" value="yes"></td>
                 <td>Use multiple computers</td>
             </tr>
             <tr><td width="18"><input type="checkbox" name="usemultiplebrowsers" value="yes"></td>
                 <td>Use multiple
                  browsers (specify)</td></tr>
             <tr><td width="18"><input type="checkbox" name="usemultipleos" value="yes"></td>
                 <td>Use multiple Operating Systems</td></tr>
             <tr><td width="18"></td><td>Comments:</td></tr>
            </table>
            <textarea class="longbox" rows="3" name="whyuse_other" cols="31"></textarea>
            <h4><img height="10" src="../images/psep.gif" width="491" alt=""><b><br>
            BookmarkSync will be
            supported entirely by advertising and e-commerce linkages. What
            services would you want readily available through advertising or for
            discount purchase from our web site?&nbsp;
            </b>
            </h4>
            <table border="0">
             <tr>
              <td><input type="checkbox" name="buytravel" value="yes"></td>
                 <td>Travel services
                  ( vacation packages, airlines, other)</td>
             </tr>
             <tr><td><input type="checkbox" name="buyleisure" value="yes"></td>
                 <td>Leisure
                  goods and services (sports, books, toys)</td></tr>
             <tr><td><input type="checkbox" name="buybiz" value="yes"></td>
                 <td>Business-related (office supplies, industry news sources, conferences and trade shows)</td></tr>
             <tr><td><input type="checkbox" name="buytech" value="yes"></td>
                 <td>Technology (computer software and hardware, links to related web sites, custom home page design,
                E-mail and ISP hosting services)</td></tr>
             <tr><td><input type="checkbox" name="nobuy" value="yes"></td>
                 <td>No ads,
                  please.</td></tr>
             <tr><td></td><td>Other
                goods or services:</td></tr>
            </table>
            <textarea class="longbox" rows="3" name="whybuy_other" cols="31"></textarea>
            <h4><img height="10" src="../images/psep.gif" width="491" alt=""><b><br>
            Tell us about
            yourself. All name and address information will be kept strictly
            confidential, in accordance with our Internet <a href="policy.php">privacy policy</a>.
            Demographic information will be used for online advertising and
            e-commerce purposes.
            </b></h4>
            <table border="0" width="491">
              <tr>
                <td width="50%" align="right">Name</td>
                <td width="50%"><input class="shortbox" type="text" name="name" size="20" value="<?php if (isset($_COOKIE['name'])) echo $_COOKIE["name"]; ?>"></td>
              </tr>
              <tr>
                <td width="50%" align="right">E-Mail</td>

                <td width="50%"><input class="shortbox" type="text" name="email" size="20" value="<?php if (isset($_COOKIE['email'])) echo $_COOKIE["email"]; ?>"></td>
              </tr>
              <tr>
                <td width="50%" align="right"># of
                  computers you use weekly</td>
                <td width="50%"><select class="shortbox" size="1" name="compusers_weekly">
                    <option>Please pick...</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option value="5">5 or more</option>
                  </select></td>
              </tr>
              <tr>
                <td width="50%" align="right"># of
                  computers you own</td>
                <td width="50%"><select class="shortbox" size="1" name="total_computers">
                    <option>Please pick...</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option value="5">5 or more</option>
                  </select></td>
              </tr>
              <tr>
                <td width="50%" align="right">Title</td>
                <td width="50%"><input class="shortbox" type="text" name="title" size="20"></td>
              </tr>
              <tr>
                <td width="50%" align="right">Profession</td>
                <td width="50%"><input class="shortbox" type="text" name="profession" size="20"></td>
              </tr>
              <tr>
                <td width="50%" align="right">Company</td>
                <td width="50%"><input class="shortbox" type="text" name="company" size="20"></td>
              </tr>
              <tr>
                <td width="50%" align="right">Office
                  ZIP code</td>
                <td width="50%"><input class="shortbox" type="text" name="office_zip" size="20"></td>
              </tr>
              <tr>
                <td width="50%" align="right">Home ZIP
                  code</td>
                <td width="50%"><input class="shortbox" type="text" name="home_zip" size="20"></td>
              </tr>
              <tr>
                <td width="50%" align="right">Country</td>
                <td width="50%"><input class="shortbox" type="text" name="country" size="20"></td>
              </tr>
              <tr>
                <td width="50%" align="right">Languages
                  you speak</td>
                <td width="50%"><input class="shortbox" type="text" name="Languages" size="20"></td>
              </tr>
              <tr>
                <td width="50%" align="right">Gender</td>
                <td width="50%"><select class="shortbox" size="1" name="gender">
                    <option>Please pick...</option>
<?php
if ($gender == "M")
	echo "<option selected>Male</option>\r\n";
else
	echo "<option>Male</option>\r\n";

if ($gender == "F")
	echo "<option selected>Female</option>\r\n";
else
	echo "<option>Female</option>\r\n";
?>
                  </select></td>
              </tr>
              <!--
              <tr>
                <td width="50%" align="right">Birth-year</td>
                <td width="50%"><input class="shortbox" type="HIDDEN" name="birthyear" size="4"></td>
              </tr>
              -->
              <tr>
                <td width="50%" align="right">Typical
                  online purchases</td>
                <td width="50%"><textarea class="shortbox" rows="3" name="online_purchase" cols="20"></textarea></td>
              </tr>
              <tr>
                <td width="50%" align="right">Publications
                  you read</td>
                <td width="50%"><textarea class="shortbox" rows="3" name="read_publications" cols="20"></textarea></td>
              </tr>
              <tr>
                <td width="50%" align="right">Additional
                  feedback</td>
                <td width="50%"><textarea class="shortbox" rows="4" name="feedback" cols="20"></textarea></td>
              </tr>
            </table>
            <h4><img height="10" src="../images/psep.gif" width="491" alt=""><b><br>
            Last, but not
            least, what other features would you like to see in our product?
            </b></h4>
            <p><textarea rows="3" name="features" cols="31" class="longbox" style="width:491px" style="width:491px" style="width:491px" style="width:491px"></textarea style="width:491px"></p>
              <h3 align="left"><img height="10" src="../images/psep.gif" width="491" alt=""><b><br>
                SUBMIT SURVEY: </b>
                <input border="0" src="../images/btnok.gif" name="I1" type="image" width="62" height="16" alt="OK">
              </h3>
            </form>
<?php
}
?>
            </td>
          <td width="10" valign="top">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php include '../inc/footer.php'; ?>
</body>
</html>

