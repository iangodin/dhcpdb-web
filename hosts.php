
<div class='row-fluid'>
    <div class='input-prepend span6'>
      <button class='btn' data-toggle='tooltip' title='Clear filter' onclick='$("#host_filter").val(""); filterTable( $("#host_filter")[0], $("#host_table")[0] );'><i class='icon-filter'></i></button>
      <input id='host_filter' class='filter' type='text' placeholder='Filter' onkeyup='filterTable(this,$("#host_table")[0])'>
    </div>
	<div class='span6'>
		<button class='btn btn-primary pull-right' onclick='addHost()'><i class='icon-plus'></i> Add Host</button>
	</div>
</div>

<div class='row-fluid '>
	<div class='span3'><strong>IP Address</strong></div>
	<div class='span3'><strong>DNS Address</strong></div>
	<div class='span3'><strong>MAC Address</strong></div>
</div>
<hr>

<div id='host_table' class='table filterable'>

<?php

$options = array();
exec( "dhcpdb list-all", $hosts );

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

?>

</div>

<div id="host_editor" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="hostEditorLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="hostEditorLabel">Host Information</h3>
	</div>
	<div class="modal-body">
		<form id="host_form" class="form-horizontal">
			<input id="host_orig" type="hidden" name="original">
			<div class="control-group">
				<label class="control-label" for="ipaddress">IP Address</label>
				<div class="controls"><input id="host_ipaddress" type="text" name="ipaddress" placeholder="IP Address"></div>
			</div>
			<div class="control-group">
				<label class="control-label" for="macaddress">MAC Address</label>
				<div class="controls"><input id="host_macaddress" type="text" name="macaddress" placeholder="MAC Address"></div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button id="host_save" class="btn btn-primary">Save changes</button>
	</div>
</div>

<div id="host_confirmation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="hostEditorLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="hostEditorLabel">Removing Host</h3>
	</div>
	<div class="modal-body">
		<p id="delete_msg">Deleting</p>
		<p>Are you sure?</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button class="btn btn-danger" id="host_delete">Remove</button>
	</div>
</div>

