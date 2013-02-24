
<div class='row-fluid'>
	<div class='input-prepend span6'>
		<button class='btn' data-toggle='tooltip' title='Clear filter' onclick='$("#option_filter").val(""); filterTable( $("#option_filter")[0], $("#option_table")[0] );'><i class='icon-filter'></i></button>
		<input id='option_filter' class='filter' type='text' placeholder='Filter' onkeyup='filterTable(this,$("#option_table")[0])'>
	</div>
	<div class='span6'>
		<button class='btn btn-primary pull-right' onclick='addOption()'><i class='icon-plus'></i> Add Option</button>
	</div>
</div>

<div class='row-fluid'>
	<div class='span4'><strong>IP Range</strong></div>
	<div class='span5'><strong>Option</strong></div>
</div>
<hr>

<div id='option_table' class='table filterable'>

<?php

$options = array();
exec( "dhcpdb options", $options );

foreach ( $options as $option )
{
	list( $ip_from, $ip_to, $opt ) = explode( "\t", $option, 3 );
	echo "<div><div class='row-fluid'>";
	echo "<div class='span2'>" . $ip_from . "</div>";
	echo "<div class='span2'>" . $ip_to . "</div>";
	echo "<div class='span5'>" . $opt . "</div>";
	echo "<div class='pull-right span3 btn-group'>";
		echo "<button onclick='removeOption( \"" . $ip_from . "\", \"" . $ip_to . "\", \"" . $opt . "\", this.parentNode.parentNode.parentNode )' class='btn btn-danger'><i class='icon-trash'></i> Remove</button>";
	echo "</div>";
	echo "</div><hr></div>";
}

?>

</div>

<div id="option_editor" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="optionEditorLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="optionEditorLabel">Host Information</h3>
	</div>
	<div class="modal-body">
		<form id="option_form" class="form-horizontal">
			<div class="control-group">
				<label class="control-label" for="ipfrom">IP From</label>
				<div class="controls"><input id="option_ipfrom" type="text" name="ipfrom" placeholder="IP Address"></div>
			</div>
			<div class="control-group">
				<label class="control-label" for="ipto">IP To</label>
				<div class="controls"><input id="option_ipto" type="text" name="ipto" placeholder="IP Address"></div>
			</div>
			<div class="control-group">
				<label class="control-label" for="">Option</label>
				<div class="controls"><input id="option_option" type="text" name="option" placeholder="Option"></div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button id="option_save" class="btn btn-primary">Add option</button>
	</div>
</div>

<div id="option_confirmation" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="optionEditorLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="optionEditorLabel">Removing Option</h3>
	</div>
	<div class="modal-body">
		<p id="option_delete_msg">Deleting</p>
		<p>Are you sure?</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button class="btn btn-danger" id="option_delete">Remove</button>
	</div>
</div>

