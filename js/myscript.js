
(function($) {
	$.fn.spin = function(opts, color) {
		var presets = {
			"tiny": { lines: 8, length: 2, width: 2, radius: 3 },
			"small": { lines: 8, length: 4, width: 3, radius: 5 },
			"large": { lines: 10, length: 8, width: 4, radius: 8 }
		};
		if (Spinner) {
			return this.each(function() {
				var $this = $(this),
					data = $this.data();
				
				if (data.spinner) {
					data.spinner.stop();
					delete data.spinner;
				}
				if (opts !== false) {
					if (typeof opts === "string") {
						if (opts in presets) {
							opts = presets[opts];
						} else {
							opts = {};
						}
						if (color) {
							opts.color = color;
						}
					}
					data.spinner = new Spinner($.extend({color: $this.css('color')}, opts)).spin(this);
				}
			});
		} else {
			throw "Spinner class not available.";
		}
	};
})(jQuery);

function loadedHosts( responseText, textStatus, request )
{
	var page = $("#hosts");
	if ( page.children().length == 0 )
		page.append( '<div class="alert alert-error"><i class="icon-warning-sign"></i> Could not load list of hosts</div>' );
	updateUI();
};

function loadedOptions( responseText, textStatus, request )
{
	var page = $("#options");
	if ( page.children().length == 0 )
		page.append( '<div class="alert alert-error"><i class="icon-warning-sign"></i> Could not load list of options</div>' );
	updateUI();
};

function loadedLeases( responseText, textStatus, request )
{
	var page = $("#leases");
	if ( page.children().length == 0 )
		page.append( '<div class="alert alert-error"><i class="icon-warning-sign"></i> Could not load list of leases</div>' );
	updateUI();
};

window.onload = function() {
	$("#spinner-holder").spin("small", "#fff" );
	updateUI();
	$("#hosts").load( "hosts.php", loadedHosts );
	$("#options").load( "options.php", loadedOptions );
	$("#leases").load( "leases.php", loadedLeases );
};

function editHost( ip_addr, mac_addr, it ) {
	$("#host_orig").val( ip_addr );
	$("#host_ipaddress").val( ip_addr );
	$("#host_macaddress").val( mac_addr );
	$("#host_save").attr('onclick','').unbind('click');
	$("#host_save").click( function() { saveHostEditor( it ); } );
	$("#host_editor").modal( 'show' );
};

function addHost() {
	$("#host_orig").val( "" );
	$("#host_ipaddress").val( "" );
	$("#host_macaddress").val( "" );
	$("#host_save").attr('onclick','').unbind('click');
	$("#host_save").click( function() { saveHostEditor(); } );
	$("#host_editor").modal( 'show' );
}

function addOption() {
	$("#option_ipfrom").val( "0.0.0.0" );
	$("#option_ipto").val( "255.255.255.255" );
	$("#option_option").val( "" );
	$("#option_save").attr('onclick','').unbind('click');
	$("#option_save").click( function() { saveOptionEditor(); } );
	$("#option_editor").modal( 'show' );
}

function removeHost( ip_addr, it ) {
	$("#delete_msg").html( "Deleting " + ip_addr );
	$("#host_delete").attr('onclick','').unbind('click');
	$("#host_delete").click( function() { reallyRemoveHost( ip_addr, it ); } );
	$("#host_confirmation").modal('show');
}

function reallyRemoveHost( ip_addr, it ) {
	$("#host_confirmation").modal('hide');
	var data = {
		ipaddress: ip_addr
	}
	$.post( "removehost.php", data ).done( function( data, status, xhr ) {
		$('.notifications').notify( { type: 'success', fadeOut: { enabled: true, delay: 10000 }, message: { text: "Host removed" } } ).show();
		$(it).remove();
	} ).fail( function( data, status, xhr ) {
		$('.notifications').notify( { type: 'error', fadeOut: { enabled: false }, message: { text: data } } ).show();
	} );
};

function releaseLease( ip_addr, it ) {
	$("#release_msg").html( "Releasing " + ip_addr );
	$("#lease_delete").attr('onclick','').unbind('click');
	$("#lease_delete").click( function() { reallyReleaseLease( ip_addr, it ); } );
	$("#lease_confirmation").modal('show');
}

function reallyReleaseLease( ip_addr, it ) {
	$("#lease_confirmation").modal('hide');
	var data = {
		ipaddress: ip_addr
	}
	$.post( "releaselease.php", data ).done( function( data, status, xhr ) {
		$('.notifications').notify( { type: 'success', fadeOut: { enabled: true, delay: 10000 }, message: { text: "Lease released" } } ).show();
		$(it).remove();
	} ).fail( function( data, status, xhr ) {
		$('.notifications').notify( { type: 'error', fadeOut: { enabled: false }, message: { text: data } } ).show();
	} );
};


function removeOption( ip_from, ip_to, option, it ) {
	$("#option_delete_msg").html( "Deleting " + ip_from + " - " + ip_to + " " + option );
	$("#option_delete").attr('onclick','').unbind('click');
	$("#option_delete").click( function() { reallyRemoveOption( ip_from, ip_to, option, it ); } );
	$("#option_confirmation").modal('show');
}

function reallyRemoveOption( ip_from, ip_to, option, it ) {
	$("#option_confirmation").modal('hide');
	var data = {
		ipfrom: ip_from,
		ipto: ip_to,
		option: option
	}
	$.post( "removeoption.php", data ).done( function( data, status, xhr ) {
		$('.notifications').notify( { type: 'success', fadeOut: { enabled: true, delay: 10000 }, message: { text: "Option removed" } } ).show();
		$(it).remove();
	} ).fail( function( data, status, xhr ) {
		$('.notifications').notify( { type: 'error', fadeOut: { enabled: false }, message: { text: data } } ).show();
	} );
};

function saveHostEditor( it ) {
	$("#host_editor").modal( 'hide' );
	var data = {
		original: $("#host_orig").val(),
		ipaddress: $("#host_ipaddress").val(),
		macaddress: $("#host_macaddress").val()
	}
	$.post( "edithost.php", data ).done ( function( data, status, xhr ) {
		if ( it )
		{
			$('.notifications').notify( { type: 'success', fadeOut: { enabled: true, delay: 10000 }, message: { text: "Host edited" } } ).show();
			$(it).replaceWith( data );
		}
		else
		{
			$('.notifications').notify( { type: 'success', fadeOut: { enabled: true, delay: 10000 }, message: { text: "Host added" } } ).show();
			$('#host_table').append( data );
		}
	} ).fail( function( data, status, xhr ) {
		$('.notifications').notify( { type: 'error', fadeOut: { enabled: false }, message: { text: data } } ).show();
	} );
};

function saveOptionEditor() {
	$("#option_editor").modal( 'hide' );
	var data = {
		ipfrom: $("#option_ipfrom").val(),
		ipto: $("#option_ipto").val(),
		option: $("#option_option").val()
	}
	$.post( "addoption.php", data ).done( function( data, status, xhr ) {
		$('.notifications').notify( { type: 'success', fadeOut: { enabled: true, delay: 10000 }, message: { text: "Host added" } } ).show();
		$('#option_table').append( data );
	} ).fail( function( data, status, xhr ) {
		$('.notifications').notify( { type: 'error', fadeOut: { enabled: true, delay: 10000 }, message: { text: data } } ).show();
	} );
};

function updateUI()
{
	$(".dnsname").tooltip();
	$(".prettydate").tooltip();
	var hpage = $("#hosts")[0];
	var opage = $("#options")[0];
	var lpage = $("#leases")[0];
	if ( hpage.children.length > 0 && opage.children.length > 0 && lpage.children.length > 0 )
		$("#spinner-holder").data('spinner').stop() 
};

function filterTable(term, table) {
	dehighlight(table);

	var terms = term.value.toLowerCase().split(" ");
	for (var r = 0; r < table.children.length; r++) {
		var display = '';
		for (var i = 0; i < terms.length; i++) {
			if ( ! highlight( terms[i], table.children[r] ) ) {
				display = 'none';
			}
			table.children[r].style.display = display;
		}
	}
}

function dehighlight(container) {
	for ( var i = 0; i < container.childNodes.length; i++ ) {
		var node = container.childNodes[i];

		if ( node.attributes && node.attributes['class'] && node.attributes['class'].value == 'highlighted' ) {
			node.parentNode.parentNode.replaceChild( document.createTextNode( node.parentNode.innerHTML.replace(/<[^>]+>/g, "")), node.parentNode );
			return;
		} else if ( node.nodeType != 3 ) {
			dehighlight( node );
		}
	}
}

function highlight(term, container) {
	if ( term.length == 0 )
		return true;

	var found = false;
	for (var i = 0; i < container.childNodes.length; i++) {
		var node = container.childNodes[i];
		if ( node.nodeName == "BUTTON" ) {
			continue;
		}

		if (node.nodeType == 3) {
			// Text node
			var data = node.data;
			var data_low = data.toLowerCase();
			if (data_low.indexOf(term) >= 0) {
				//term found!
				found = true;
				var new_node = document.createElement('span');

				node.parentNode.replaceChild(new_node, node);

				var result;
				while ((result = data_low.indexOf(term)) != -1) {
					new_node.appendChild(document.createTextNode(
								data.substr(0, result)));
					new_node.appendChild(create_node(
								document.createTextNode(data.substr(
										result, term.length))));
					data = data.substr(result + term.length);
					data_low = data_low.substr(result + term.length);
				}
				new_node.appendChild(document.createTextNode(data));
			}
		} else {
			// Keep going onto other elements
			if ( highlight(term, node) )
				found = true;
		}
	}

	return found;
}

function create_node(child) {
	var node = document.createElement('span');
	node.setAttribute('class', 'highlighted');
	node.attributes['class'].value = 'highlighted';
	node.appendChild(child);
	return node;
}

