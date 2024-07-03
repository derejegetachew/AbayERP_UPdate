
		
<?php $position_html = "<table cellspacing=3>" . 		"<tr><th align=right>" . __('Name', true) . ":</th><td><b>" . $position['Position']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>" . __('Grade', true) . ":</th><td><b>" . $position['Grade']['name'] . "</b></td></tr>" . 
		"<tr><th align=right>Is Managerial:</th><td><b>" . $position['Position']['is_managerial'] . "</b></td></tr>" . 
		"<tr><th align=right>Classification:</th><td><b>" . $position['Position']['classification'] . "</b></td></tr>" . 
		"<tr><th align=right>Requirements:</th><td><b>" . $position['Position']['requirements'] . "</b></td></tr>" . 
"</table>"; 
?>
		var position_view_panel_1 = {
			html : '<?php echo $position_html; ?>',
			frame : true,
		}
		var position_view_panel_2 = new Ext.TabPanel({
			activeTab: 0,
			anchor: '100%',
			height:190,
			plain:true,
			defaults:{autoScroll: true},
			items:[
						]
		});

		var PositionViewWindow = new Ext.Window({
			title: '<?php __('View Position'); ?>: <?php echo $position['Position']['name']; ?>',
			width: 500,
			height:345,
			minWidth: 500,
			minHeight: 345,
			resizable: false,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'center',
                        modal: true,
			items: [ 
				position_view_panel_1
			],

			buttons: [{
				text: '<?php __('Close'); ?>',
				handler: function(btn){
					PositionViewWindow.close();
				}
			}]
		});
