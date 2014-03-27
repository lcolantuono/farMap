<?php    
/*
 * PHP QR Code encoder
*
* Exemplatory usage
*
* PHP QR Code is distributed under LGPL 3
* Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
* Lesser General Public License for more details.
*
* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

include "qrlib.php";
if (isset($_REQUEST['data'])) {

	//it's very important!
	if (trim($_REQUEST['data']) == '')
		die('data cannot be empty! <a href="?">back</a>');

	// user data
       // print_r($_SERVER);exit;
	$data='http://'.$_SERVER['SERVER_NAME'].'/farMap/index.php?id='.$_REQUEST['data'];
	QRcode::png($data);
        
} else {
    QRcode::png('google.com');

}

QRtools::timeBenchmark();