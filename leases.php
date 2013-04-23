
<div class='row-fluid'>
	<div class='input-prepend span6'>
		<button class='btn' onclick='$("#lease_filter").val(""); filterTable( $("#lease_filter")[0], $("#lease_table")[0] );'><i class='icon-filter'></i></button>
		<input id='lease_filter' class='filter' type='text' placeholder='Filter' onkeyup='filterTable(this,$("#lease_table")[0])'>
	</div>
</div>

<div class='row-fluid '>
	<div class='span2'><strong>IP Address</strong></div>
	<div class='span3'><strong>DNS Address</strong></div>
	<div class='span3'><strong>MAC Address</strong></div>
	<div class='span2'><strong>Expiration</strong></div>
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
	echo "<div class='span2'>";
	if ( $expire < $now )
		echo "<span class='label label-important'>Expired</span> ";
	else
		echo "<span class='label label-success'>Leased</span> ";
   	echo $ip . "</div>";
	echo "<div class='span3'>" . $name . "</div>";
	echo "<div class='span3' style='font-family: Fixed, monospace;'>" . $mac . "</div>";
	echo "<div class='span2'>" . $expire->format( "M jS Y h:iA" ) . "</div>";
	echo "<div class='span2 btn-group pull-right'>";
		echo "<button onclick='releaseLease( \"" . $name . "\", this.parentNode.parentNode.parentNode)' class='btn btn-danger'><i class='icon-trash'></i> Release</button>";
	echo "</div>";
	echo "</div><hr/></div>";
}

?>

</div>

<div id="lease_confirmation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="leaseEditorLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="leaseEditorLabel">Releasing Lease</h3>
	</div>
	<div class="modal-body">
		<p id="release_msg">Releasing</p>
		<p>Are you sure?</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button class="btn btn-danger" id="lease_delete">Release</button>
	</div>
</div>

