<?php
$ipaddr = $_POST["ipaddress"];

exec( "dhcpdb release-lease " . $ipaddr, $output, $retval );
if( $retval == 0 )
{
	header( "Status: 201 Created" );
}
else
{
	echo "Error releasing lease";
}

?>
