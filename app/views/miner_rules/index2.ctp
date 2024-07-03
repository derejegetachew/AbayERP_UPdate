var store_parent_minerRules = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','mine','tableField','param','value'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentMinerRule() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_minerRule_data = response.responseText;
			
			eval(parent_minerRule_data);
			
			MinerRuleAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the minerRule add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentMinerRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_minerRule_data = response.responseText;
			
			eval(parent_minerRule_data);
			
			MinerRuleEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the minerRule edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewMinerRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var minerRule_data = response.responseText;

			eval(minerRule_data);

			MinerRuleViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the minerRule view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentMinerRule(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'minerRules', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('MinerRule(s) successfully deleted!'); ?>');
			RefreshParentMinerRuleData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the minerRule to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentMinerRuleName(value){
	var conditions = '\'MinerRule.name LIKE\' => \'%' + value + '%\'';
	store_parent_minerRules.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentMinerRuleData() {
	store_parent_minerRules.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('MinerRules'); ?>',
	store: store_parent_minerRules,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'minerRuleGrid',
	columns: [
		{header:"<?php __('mine'); ?>", dataIndex: 'mine', sortable: true},
		{header: "<?php __('TableField'); ?>", dataIndex: 'tableField', sortable: true},
		{header: "<?php __('Param'); ?>", dataIndex: 'param', sortable: true},
		{header: "<?php __('Value'); ?>", dataIndex: 'value', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewMinerRule(Ext.getCmp('minerRuleGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add MinerRule</b><br />Click here to create a new MinerRule'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentMinerRule();
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-minerRule',
				tooltip:'<?php __('<b>Edit MinerRule</b><br />Click here to modify the selected MinerRule'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentMinerRule(sel.data.id);
					};
				}
			}, ' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Delete'); ?>',
				id: 'delete-parent-minerRule',
				tooltip:'<?php __('<b>Delete MinerRule(s)</b><br />Click here to remove the selected MinerRule(s)'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelections();
					if (sm.hasSelection()){
						if(sel.length==1){
							Ext.Msg.show({
									title: '<?php __('Remove MinerRule'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													DeleteParentMinerRule(sel[0].data.id);
											}
									}
							});
						} else {
							Ext.Msg.show({
									title: '<?php __('Remove MinerRule'); ?>',
									buttons: Ext.MessageBox.YESNOCANCEL,
									msg: '<?php __('Remove the selected MinerRule'); ?>?',
									icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
											if (btn == 'yes'){
													var sel_ids = '';
													for(i=0;i<sel.length;i++){
														if(i>0)
															sel_ids += '_';
														sel_ids += sel[i].data.id;
													}
													DeleteParentMinerRule(sel_ids);
											}
									}
							});
						}
					} else {
						Ext.Msg.alert('<?php __('Warning'); ?>', '<?php __('Please select a record first'); ?>');
					};
				}
			}, ' ','-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View MinerRule'); ?>',
				id: 'view-minerRule2',
				tooltip:'<?php __('<b>View MinerRule</b><br />Click here to see details of the selected MinerRule'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						ViewMinerRule(sel.data.id);
					};
				},
				menu : {
					items: [
					]
				}

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_minerRule_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentMinerRuleName(Ext.getCmp('parent_minerRule_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_minerRule_go_button',
				handler: function(){
					SearchByParentMinerRuleName(Ext.getCmp('parent_minerRule_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_minerRules,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-minerRule').enable();
	g.getTopToolbar().findById('delete-parent-minerRule').enable();
        g.getTopToolbar().findById('view-minerRule2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-minerRule').disable();
                g.getTopToolbar().findById('view-minerRule2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-minerRule').disable();
		g.getTopToolbar().findById('delete-parent-minerRule').enable();
                g.getTopToolbar().findById('view-minerRule2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-minerRule').enable();
		g.getTopToolbar().findById('delete-parent-minerRule').enable();
                g.getTopToolbar().findById('view-minerRule2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-minerRule').disable();
		g.getTopToolbar().findById('delete-parent-minerRule').disable();
                g.getTopToolbar().findById('view-minerRule2').disable();
	}
});



var parentMinerRulesViewWindow = new Ext.Window({
	title: 'MinerRule Under the selected Item',
	width: 700,
	height:375,
	minWidth: 700,
	minHeight: 400,
	resizable: false,
	plain:true,
	bodyStyle:'padding:5px;',
	buttonAlign:'center',
        modal: true,
	items: [
		g
	],

	buttons: [{
		text: 'Close',
		handler: function(btn){
			parentMinerRulesViewWindow.close();
		}
	}]
});

store_parent_minerRules.load({
    params: {
        start: 0,    
        limit: list_size
    }
});