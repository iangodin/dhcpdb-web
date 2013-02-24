<?php

$ipfrom = $_POST["ipfrom"];
$ipto = $_POST["ipto"];
$option = $_POST["option"];

exec( "dhcpdb add-option " . $ipfrom . " " . $ipto . " \"" . $option . "\"", $output, $retval );

if( $retval == 0 )
{
	header( "Status: 201 Created" );
	foreach ( $output as $option )
	{
		list( $ip_from, $ip_to, $opt ) = explode( "\t", $option, 3 );
		echo "<div><div class='row-fluid'>";
		echo "<div class='span2'>" . $ip_from . "</div>";
		echo "<div class='span2'>" . $ip_to . "</div>";
		echo "<div class='span5'>" . $opt . "</div>";
		echo "<div class='pull-right span3 btn-group'>";
			echo "<button onclick='removeOption( \"" . $ip_from . "\", \"" . $ip_to . "\", \"" . $opt . "\", this.parentNode.parentNode.parentNode )' class='btn btn-danger'><i class='icon-trash'></i> Remove</button>";
		echo "</div>";
		echo "</div><hr/></div>";
	}
}
else
{
	foreach ( $output as $line )
	{
		echo $line;
		error_log( $line );
	}
}

?>
