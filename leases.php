
<div class='row-fluid'>
	<div class='input-prepend span6'>
		<button class='btn' onclick='$("#lease_filter").val(""); filterTable( $("#lease_filter")[0], $("#lease_table")[0] );'><i class='icon-filter'></i></button>
		<input id='lease_filter' class='filter' type='text' placeholder='Filter' onkeyup='filterTable(this,$("#lease_table")[0])'>
	</div>
</div>

<div class='row-fluid '>
	<div class='span3'><strong>IP Address</strong></div>
	<div class='span3'><strong>DNS Address</strong></div>
	<div class='span3'><strong>MAC Address</strong></div>
	<div class='span3'><strong>Expiration</strong></div>
</div><hr/>

<div id='lease_table' class='table filterable'>

<?php

$leases = array();
exec( "dhcpdb leases", $leases );

$now = date_create( "now" );

foreach ( $leases as $lease )
{
	list( $ip, $name, $mac, $date ) = explode( "\t", $lease, 4 );
	$expire = date_create( $date );

	echo "<div><div class='row-fluid'>";
	echo "<div class='span3'>";
	if ( $expire < $now )
		echo "<span class='label label-important'>Expired</span> ";
	else
		echo "<span class='label label-success'>Leased</span> ";
   	echo $ip . "</div>";
	echo "<div class='span3'>" . $name . "</div>";
	echo "<div class='span3' style='font-family: Fixed, monospace;'>" . $mac . "</div>";
	echo "<div class='span3'>" . $expire->format( "M jS Y h:iA" ) . "</div>";
	echo "</div><hr/></div>";
}

?>

</div>

