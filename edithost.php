<?php

$orig = $_POST["original"];
$ipaddr = $_POST["ipaddress"];
$macaddr = $_POST["macaddress"];

if ( $orig == "" )
	exec( "dhcpdb add-host " . $ipaddr . " " . $macaddr, $hosts, $retval );
else
	exec( "dhcpdb replace-host " . $orig . " " . $ipaddr . " " . $macaddr, $hosts, $retval );

if( $retval == 0 )
{
	header( "Status: 201 Created" );
	foreach ( $hosts as $host )
	{
		list( $ip, $name, $mac ) = explode( "\t", $host, 3 );
		echo "<div><div class='row-fluid'>";
			echo "<div class='span3'>" . $ip . "</div>";
			echo "<div class='span3'>" . $name . "</div>";
			echo "<div class='span3' style='font-family: Fixed, monospace;'>" . $mac . "</div>";
			echo "<div class='span3 btn-group pull-right'>";
				echo "<button onclick='editHost( \"" . $name . "\", \"" . $mac . "\", this.parentNode.parentNode.parentNode )' class='btn'><i class='icon-edit'></i> Edit</button>";
				echo "<button onclick='removeHost( \"" . $name . "\", this.parentNode.parentNode.parentNode )' class='btn btn-danger'><i class='icon-trash'></i> Remove</button>";
			echo "</div>";
		echo "</div><hr></div>";
	}
}
else
{
	if ( $orig == "" )
		echo "Error adding host (already exists?)";
	else
		echo "Error editing host (was removed?)";
}

?>
