<?php
//	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//	#AspUpload.php
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

//	AspUpload Constants Include File

//	Copyright (c) Persits Software, Inc. All rights reserved.



// LogonUser's Type Parameter
$LOGON_INTERACTIVE=2;
$LOGON_NETWORK=3;
$LOGON_BATCH=4;
$LOGON_SERVICE=5;


// Generic Access Types
$GENERIC_ALL=.$H10000000;
$GENERIC_EXECUTE=.$H20000000;
$GENERIC_WRITE=.$H40000000;
$GENERIC_READ=.$H80000000;

// Standard Access Types
$DELETE=.$H00010000;
$READ_CONTROL=.$H00020000;
$WRITE_DAC=.$H00040000;
$WRITE_OWNER=.$H00080000;
$WRITE_SYNCHRONIZE=.$H00100000;


// Specific Access Types for Files

$FILE_GENERIC_READ=.$H120089;
$FILE_GENERIC_WRITE=.$H120116;
$FILE_GENERIC_EXECUTE=.$H1200A0;

$FILE_READ_DATA=.$H0001;
$FILE_WRITE_DATA=.$H0002;
$FILE_APPEND_DATA=.$H0004;
$FILE_READ_EA=.$H0008;
$FILE_WRITE_EA=.$H0010;
$FILE_EXECUTE=.$H0020;
$FILE_READ_ATTRIBUTES=.$H0080;
$FILE_WRITE_ATTRIBUTES=.$H0100;


// File Attributes
$FILE_ATTRIBUTE_READONLY=.$H1;
$FILE_ATTRIBUTE_HIDDEN=.$H2;
$FILE_ATTRIBUTE_SYSTEM=.$H4;
$FILE_ATTRIBUTE_DIRECTORY=.$H10;
$FILE_ATTRIBUTE_ARCHIVE=.$H20;
$FILE_ATTRIBUTE_NORMAL=.$H80;
$FILE_ATTRIBUTE_TEMPORARY=.$H100;
$FILE_ATTRIBUTE_COMPRESSED=.$H800;

// Sort-by Attributes for Directory Collection.
// These are NOT standard Windows NT constants
$SORTBY_NAME=1;
$SORTBY_TYPE=2;
$SORTBY_SIZE=3;
$SORTBY_CREATIONTIME=4;
$SORTBY_LASTWRITETIME=5;
$SORTBY_LASTACCESSTIME=6;

?>

