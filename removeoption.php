<?php
$ipfrom = $_POST["ipfrom"];
$ipto = $_POST["ipto"];
$option = $_POST["option"];

exec( "dhcpdb remove-option " . $ipfrom . " " . $ipto . " \"" . $option . "\"", $output, $retval );
error_log( "./dhcpdb remove-option " . $ipfrom . " " . $ipto . " \"" . $option . "\"" );
if( $retval == 0 )
{
	header( "Status: 201 Created" );
}
else
{
	echo "Error removing option";
}

?>
