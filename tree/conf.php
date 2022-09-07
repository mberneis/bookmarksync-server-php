<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#conf.php
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

header("Expires: -1");

restricted("../tree/conf.php");

$ID = $_SESSION['ID'];
$GLOBALS['mainmenu'] = "EDIT";
$GLOBALS['submenu'] = "";

$argpath = "\\";
$flist = "";
$addfolder = "";

if (!db_connect())
	die();

if (isset($_POST['addfolder']))
	$addfolder = strip(my_stripslashes($_POST["addfolder"]));


if ($addfolder != ""){
	$addfolder = $_POST["tree"] . $addfolder . "\\ ";
//	echo ("insert into link (person_id,path,access) values (" . $ID . ",'" . my_addslashes($addfolder) . "',now())");
	$res = mysql_query("insert into link (person_id,path,access) values (" . $ID . ",'" . my_addslashes($addfolder) . "',now())");
	if (!$res)
		mysql_query("update link set access = now(),expiration=NULL where person_id=" . $ID . " and path ='" . prep($addfolder) . "'");
}

$parg = request("p");
$farg = request("f");

if ($farg != ""){
	$mytitle = "Folder";
	$path = $farg;
	$foldertitle = "Below";
	$xpath = $farg;
}
else {
	$mytitle = "Bookmark";
	$path = $parg;
	$foldertitle = "In Folder";
	$xpath = $parg;
}

//response.write path & "<hr>"
function makefolderlist()
{
	global $farg;
	global $parg;
	global $argpath;
	global $flist;
	$selected = false;
	$done_selected = false;
	$cur_path = "";

	$flist = "<option ";
	if ($argpath == "\\")
		$flist .= " selected ";
	$flist .= " value='\\'>[Root]</option>\r\n";

	$res = mysql_query("select path from link where person_id=" . $_SESSION['ID'] . " and expiration is null order by path");
	while ($data = mysql_fetch_assoc($res)){

		$dpath = "";

		if ($done_selected == false && $argpath != "\\" && $argpath == substr($data['path'],0,strlen($argpath)))
			$selected = true;

		$line = explode("\\",substr($data['path'],1));
		$items = count($line);

		if ($items > 1){
			for ($i=0; $i<$items-2; $i++)
				$dpath .= "- ";

			$dpath .= $line[$items-2];

			if ($dpath != $cur_path){
				$flist .= "<option ";
				if ($selected){
					$flist .= "selected ";
					$done_selected = true;
				}
				$flist .= "value='" . $data['path'] . "'>" . $dpath . "</option>\r\n";
				$cur_path = $dpath;
			}
		}
		$selected = false;
	}
}

include '../inc/tree.php';
?>
<html>
<head>
<title>BookmarkSync - Edit <?php echo $mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta http-equiv="Content-Language" content="en-us">
<link rel="StyleSheet" href="../inc/syncit.css" type="text/css">
</head>
<script language="javascript">
<!--
function delit(x) {
	if (x > 0) {
		if (confirm ('Deleting this folder also deletes all the folders and bookmarks contained within it.\nDo you want to proceed?')) {
			location.href='edit.php?delpath=<?       echo rawurlencode($xpath); ?>';
		} else {
			return false;
		}
	} else {
		location.href='edit.php?delpath=<?       echo rawurlencode($xpath); ?>';
	}
	return true;
}
//-->
</script>
<body bgcolor="#FFFFFF" text="#000000" link="#3300CC" vlink="#990000" alink="#CC0099">
<?php include '../inc/header.php'; ?>
<table align="center" width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117" valign="top">
<?php include '../inc/ymenu.php'; ?>
    </td>
    <td width="513" valign="top">
      <table width="513" border="0" cellspacing="0" cellpadding="0">
<?php
include '../inc/yhead.php';

if ($path != ""){
	echo "<tr><td width='12'>&nbsp;</td><td width='491' valign='top'><br>";
	if ($addfolder != "")
		echo "<p><font color='#FF0000'><b>Folder " . $addfolder . " added</b></font></p>";

	echo "<h2>Edit " . $mytitle . "</h2>";

	$tmp = explode("\\",$path);
	if ($tmp[count($tmp)-1] == ""){
		$tp = $tmp[count($tmp)-2];
		$argpath = substr($path,0,strlen($path)-strlen($tp)-1);
	}
	else {
		$tp = $tmp[count($tmp)-1];
		$argpath = substr($path,0,strlen($path)-strlen($tp));
	}
	$path = $tp;
	?>
	<form method="post" action="edit.php">
	<input type="hidden" name="old" value="<?php echo $argpath . $path; ?>">
	<input type="hidden" name="mytitle" value="<?php echo $mytitle; ?>">
	<table border="0" cellpadding="2" cellspacing="0">
	<tr>
	<td width=80 height="19">Name</td>
	<td height="19">
	<input type="text" name="path" size=30 style="{width:400px;}" value="<?php echo unprep($path); ?>">
	</td>
	</tr>
	<tr>
	<td><?php echo $foldertitle; ?></td>
	<td> 
	<select style="{width:400px;}" name="tree" class="register">
	<?php
	makefolderlist();
	echo $flist;
	?>
	</select>
	</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	<td> 
	<input type="button" name="btnBack" value="Back" class="pbutton" onClick="location.href='edit.php';">
	<input type="reset" name="btnReset" value="Reset" class="pbutton">
	<input type="submit" name="btnSubmit" value="Modify" class="pbutton">
	<input type="button" name="btnDelete" value="Delete" class="pbutton" onClick="return delit(<?php echo strlen($farg); ?>);">
	</td>
	</tr>
	</table>
	<input type="hidden" name="arg" value="<?php echo $mytitle; ?>">
	</form>
	</td>
	<td width="10" valign="top">&nbsp;</td>
	</tr>
	<tr>
	<td width="12">&nbsp;</td>
	<td ><p>&nbsp;</p><hr size=2 noshade color="#990099"></td>
	<td width="10" valign="top">&nbsp;</td>
	</tr>
<?php
}

else

	makefolderlist();
?>        
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br>
            <h3>Add Folder</h3>
              <form method="POST" action="conf.php">
              	<input type="hidden" name="p" value="<?php echo $parg; ?>">
              	<input type="hidden" name="f" value="<?php echo $farg; ?>">
                <table border="0" cellpadding="2" cellspacing="0">
                  <tr>
                    <td height="19">Name</td>
                    <td height="19">
                      <input type="text" name="addfolder" size=30 style="{width:400px;}" value="">
                    </td>
                  </tr>
                  <tr>
                    <td width=80>Below</td>
                    <td> 
                    <select style="{width:400px;}" name="tree" class="register">
					<?php echo $flist; ?>
                    </select>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td> 
                      <input type="button" name="btnBack" value="Back" class="pbutton" onClick="location.href='edit.php';">
                      <input type="submit" name="btnSubmit" value="Add" class="pbutton">
                    </td>
                  </tr>
                </table>
                <input type="hidden" name="arg" value="<?php echo $mytitle; ?>">
              </form>
          </td>
          <td width="10" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="12">&nbsp;</td>
          <td width="491" valign="top">
            <br>
            <h3>Add Bookmark (Or use <a href="../bms/quickadd.php">Quick Add</a>)</h3>
              <form method="POST" action="edit.php">
              	<input type="hidden" name="p" value="<?php echo $parg; ?>">
              	<input type="hidden" name="f" value="<?php echo $farg; ?>">
                <table border="0" cellpadding="2" cellspacing="0">
                  <tr>
                    <td height="19">Title</td>
                    <td height="19">
                      <input type="text" name="newtitle" size=30 style="{width:400px;}" value="">
                    </td>
                  </tr>
                  <tr>
                    <td height="19">URL</td>
                    <td height="19">
                      <input type="text" name="newurl" size=30 style="{width:400px;}" value="">
                    </td>
                  </tr>
                  <tr>
                    <td width="80">In Folder</td>
                    <td> 
                    <select style="{width:400px;}" name="tree" class="register">
					<?php echo $flist; ?>
                    </select>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td> 
                      <input type="button" name="btnBack" value="Back" class="pbutton" onClick="location.href='edit.php';">
                      <input type="submit" name="btnSubmit" value="Add" class="pbutton">
                    </td>
                  </tr>
                </table>
                <input type="hidden" name="arg" value="<?php echo $mytitle; ?>">
              </form>
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
