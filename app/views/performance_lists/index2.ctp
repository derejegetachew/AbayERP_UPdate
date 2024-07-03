var store_parent_performanceLists = new Ext.data.GroupingStore({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','name','type','performance','perspective'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'list_data', $parent_id)); ?>'	})
                ,
        sortInfo:{field: 'name', direction: "ASC"},
	groupField: 'perspective'
});


function AddParentPerformanceList() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_performanceList_data = response.responseText;
			
			eval(parent_performanceList_data);
			
			PerformanceListAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceList add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentPerformanceList(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_performanceList_data = response.responseText;
			
			eval(parent_performanceList_data);
			
			PerformanceListEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceList edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceList(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var performanceList_data = response.responseText;

			eval(performanceList_data);

			PerformanceListViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceList view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceListEmployeePerformanceResults(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'employeePerformanceResults', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_employeePerformanceResults_data = response.responseText;

			eval(parent_employeePerformanceResults_data);

			parentEmployeePerformanceResultsViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewPerformanceListPerformanceListChoices(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceListChoices', 'action' => 'index2')); ?>/'+id,
		success: function(response, opts) {
			var parent_performanceListChoices_data = response.responseText;

			eval(parent_performanceListChoices_data);

			parentPerformanceListChoicesViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
		}
	});
}


function DeleteParentPerformanceList(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'performanceLists', 'action' => 'delete')); ?>/'+id,
		success: function(response, opts) {
			Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PerformanceList(s) successfully deleted!'); ?>');
			RefreshParentPerformanceListData();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the performanceList to be deleted. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentPerformanceListName(value){
	var conditions = '\'PerformanceList.name LIKE\' => \'%' + value + '%\'';
	store_parent_performanceLists.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentPerformanceListData() {
	store_parent_performanceLists.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('PerformanceLists'); ?>',
	store: store_parent_performanceLists,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'performanceListGrid',
	columns: [
		{header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
		{header: "<?php __('Type'); ?>", dataIndex: 'type', sortable: true},
		{header:"<?php __('performance'); ?>", dataIndex: 'performance', sortable: true},
                {header:"<?php __('Perspective'); ?>", dataIndex: 'perspective', sortable: true}],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	view: new Ext.grid.GroupingView({
            forceFit:true,
            groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Perspectives" : "Perspective"]})'
        }),
    listeners: {
        celldblclick: function(){
            ViewPerformanceListPerformanceListChoices(Ext.getCmp('performanceListGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('Add'); ?>',
				tooltip:'<?php __('<b>Add PerformanceList</b><br />Click here to create a new PerformanceList'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentPerformanceList();
				}
			}, ' ', '-', ' ', '-',' ', {
				xtype: 'tbsplit',
				text: '<?php __('View Choices'); ?>',
				id: 'view-performanceList2',
				tooltip:'<?php __('<b>View Choices</b><br />Click here to see details of the selected PerformanceList'); ?>',
				icon: 'img/table_view.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
							var sm = g.getSelectionModel();
							var sel = sm.getSelected();
							if (sm.hasSelection()){
								ViewPerformanceListPerformanceListChoices(sel.data.id);
							};
						},
				

            }, ' ', '->', {
				xtype: 'textfield',
				emptyText: '<?php __('[Search By Name]'); ?>',
				id: 'parent_performanceList_search_field',
				listeners: {
					specialkey: function(field, e){
						if (e.getKey() == e.ENTER) {
							SearchByParentPerformanceListName(Ext.getCmp('parent_performanceList_search_field').getValue());
						}
					}

				}
			}, {
				xtype: 'tbbutton',
				icon: 'img/search.png',
				cls: 'x-btn-text-icon',
				text: 'GO',
				tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
				id: 'parent_performanceList_go_button',
				handler: function(){
					SearchByParentPerformanceListName(Ext.getCmp('parent_performanceList_search_field').getValue());
				}
			}, ' '
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_performanceLists,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
        g.getTopToolbar().findById('view-performanceList2').enable();
	if(this.getSelections().length > 1){
                g.getTopToolbar().findById('view-performanceList2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
                g.getTopToolbar().findById('view-performanceList2').disable();
	}
	else if(this.getSelections().length == 1){
                g.getTopToolbar().findById('view-performanceList2').enable();
	}
	else{
                g.getTopToolbar().findById('view-performanceList2').disable();
	}
});



var parentPerformanceListsViewWindow = new Ext.Window({
	title: 'PerformanceList Under the selected Item',
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
			parentPerformanceListsViewWindow.close();
		}
	}]
});

store_parent_performanceLists.load({
    params: {
        start: 0,    
        limit: list_size
    }
});