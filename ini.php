<?php
$con=mysqli_connect("localhost","root","","app");
if (mysqli_connect_errno())
{
	exit ("Failed to connect to MySQL: " . mysqli_connect_error());
}