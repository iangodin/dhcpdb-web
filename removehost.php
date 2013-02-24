<?php
$ipaddr = $_POST["ipaddress"];

exec( "dhcpdb remove-host " . $ipaddr, $output, $retval );
if( $retval == 0 )
{
	header( "Status: 201 Created" );
}
else
{
	echo "Error removing host";
}

?>
