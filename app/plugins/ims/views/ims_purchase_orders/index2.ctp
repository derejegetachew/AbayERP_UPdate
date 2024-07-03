//<script>
    var store_parent_purchaseOrders = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id','name','user','created','modified'	
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'list_data', $parent_id)); ?>'	})
    });


    function AddParentPurchaseOrder() {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'add', $parent_id)); ?>',
            success: function(response, opts) {
                var parent_purchaseOrder_data = response.responseText;
			
                eval(parent_purchaseOrder_data);
			
                PurchaseOrderAddWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrder add form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function EditParentPurchaseOrder(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
            success: function(response, opts) {
                var parent_purchaseOrder_data = response.responseText;
			
                eval(parent_purchaseOrder_data);
			
                PurchaseOrderEditWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrder edit form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewPurchaseOrder(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'view')); ?>/'+id,
            success: function(response, opts) {
                var purchaseOrder_data = response.responseText;

                eval(purchaseOrder_data);

                PurchaseOrderViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrder view form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewPurchaseOrderGrns(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_grns', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_grns_data = response.responseText;

                eval(parent_grns_data);

                parentGrnsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
	});
    }

    function ViewPurchaseOrderPurchaseOrderItems(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_order_items', 'action' => 'index2')); ?>/'+id,
            success: function(response, opts) {
                var parent_purchaseOrderItems_data = response.responseText;

                eval(parent_purchaseOrderItems_data);

                parentPurchaseOrderItemsViewWindow.show();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the campus view form. Error code'); ?>: ' + response.status);
            }
	});
    }


    function DeleteParentPurchaseOrder(id) {
	Ext.Ajax.request({
            url: '<?php echo $this->Html->url(array('controller' => 'ims_purchase_orders', 'action' => 'delete')); ?>/'+id,
            success: function(response, opts) {
                Ext.Msg.alert('<?php __('Success'); ?>', '<?php __('PurchaseOrder(s) successfully deleted!'); ?>');
                RefreshParentPurchaseOrderData();
            },
            failure: function(response, opts) {
                Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the purchaseOrder to be deleted. Error code'); ?>: ' + response.status);
            }
	});
    }

    function SearchByParentPurchaseOrderName(value){
	var conditions = '\'ImsPurchaseOrder.name LIKE\' => \'%' + value + '%\'';
	store_parent_purchaseOrders.reload({
            params: {
                start: 0,
                limit: list_size,
                conditions: conditions
	    }
	});
    }

    function RefreshParentPurchaseOrderData() {
	store_parent_purchaseOrders.reload();
    }



    var g = new Ext.grid.GridPanel({
	title: '<?php __('PurchaseOrders'); ?>',
	store: store_parent_purchaseOrders,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
        id: 'purchaseOrderGrid',
	columns: [
            {header: "<?php __('Name'); ?>", dataIndex: 'name', sortable: true},
            {header:"<?php __('user'); ?>", dataIndex: 'user', sortable: true},
            {header: "<?php __('Created'); ?>", dataIndex: 'created', sortable: true},
            {header: "<?php __('Modified'); ?>", dataIndex: 'modified', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
            singleSelect: false
	}),
	viewConfig: {
            forceFit: true
	},
        listeners: {
            celldblclick: function(){
                ViewPurchaseOrder(Ext.getCmp('purchaseOrderGrid').getSelectionModel().getSelected().data.id);
            }
        },
	tbar: new Ext.Toolbar({
            items: [{
                    xtype: 'tbbutton',
                    text: '<?php __('Add'); ?>',
                    tooltip:'<?php __('<b>Add PurchaseOrder</b><br />Click here to create a new PurchaseOrder'); ?>',
                    icon: 'img/table_add.png',
                    cls: 'x-btn-text-icon',
                    handler: function(btn) {
                        AddParentPurchaseOrder();
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Edit'); ?>',
                    id: 'edit-parent-purchaseOrder',
                    tooltip:'<?php __('<b>Edit PurchaseOrder</b><br />Click here to modify the selected PurchaseOrder'); ?>',
                    icon: 'img/table_edit.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            EditParentPurchaseOrder(sel.data.id);
                        };
                    }
                }, ' ', '-', ' ', {
                    xtype: 'tbbutton',
                    text: '<?php __('Delete'); ?>',
                    id: 'delete-parent-purchaseOrder',
                    tooltip:'<?php __('<b>Delete PurchaseOrder(s)</b><br />Click here to remove the selected PurchaseOrder(s)'); ?>',
                    icon: 'img/table_delete.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelections();
                        if (sm.hasSelection()){
                            if(sel.length==1){
                                Ext.Msg.show({
                                    title: '<?php __('Remove PurchaseOrder'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove'); ?> '+sel[0].data.name+'?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            DeleteParentPurchaseOrder(sel[0].data.id);
                                        }
                                    }
                                });
                            } else {
                                Ext.Msg.show({
                                    title: '<?php __('Remove PurchaseOrder'); ?>',
                                    buttons: Ext.MessageBox.YESNOCANCEL,
                                    msg: '<?php __('Remove the selected PurchaseOrder'); ?>?',
                                    icon: Ext.MessageBox.QUESTION,
                                    fn: function(btn){
                                        if (btn == 'yes'){
                                            var sel_ids = '';
                                            for(i=0;i<sel.length;i++){
                                                if(i>0)
                                                    sel_ids += '_';
                                                sel_ids += sel[i].data.id;
                                            }
                                            DeleteParentPurchaseOrder(sel_ids);
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
                    text: '<?php __('View PurchaseOrder'); ?>',
                    id: 'view-purchaseOrder2',
                    tooltip:'<?php __('<b>View PurchaseOrder</b><br />Click here to see details of the selected PurchaseOrder'); ?>',
                    icon: 'img/table_view.png',
                    cls: 'x-btn-text-icon',
                    disabled: true,
                    handler: function(btn) {
                        var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            ViewPurchaseOrder(sel.data.id);
                        };
                    },
                    menu : {
                        items: [
                            {
                                text: '<?php __('View Grns'); ?>',
                                icon: 'img/table_view.png',
                                cls: 'x-btn-text-icon',
                                handler: function(btn) {
                                    var sm = g.getSelectionModel();
                                    var sel = sm.getSelected();
                                    if (sm.hasSelection()){
                                        ViewPurchaseOrderGrns(sel.data.id);
                                    };
                                }
                            }
                            , {
                                text: '<?php __('View Purchase Order Items'); ?>',
                                icon: 'img/table_view.png',
                                cls: 'x-btn-text-icon',
                                handler: function(btn) {
                                    var sm = g.getSelectionModel();
                                    var sel = sm.getSelected();
                                    if (sm.hasSelection()){
                                        ViewPurchaseOrderPurchaseOrderItems(sel.data.id);
                                    };
                                }
                            }
                        ]
                    }

                }, ' ', '->', {
                    xtype: 'textfield',
                    emptyText: '<?php __('[Search By Name]'); ?>',
                    id: 'parent_purchaseOrder_search_field',
                    listeners: {
                        specialkey: function(field, e){
                            if (e.getKey() == e.ENTER) {
                                SearchByParentPurchaseOrderName(Ext.getCmp('parent_purchaseOrder_search_field').getValue());
                            }
                        }

                    }
                }, {
                    xtype: 'tbbutton',
                    icon: 'img/search.png',
                    cls: 'x-btn-text-icon',
                    text: 'GO',
                    tooltip:'<?php __('<b>GO</b><br />Click here to get search results'); ?>',
                    id: 'parent_purchaseOrder_go_button',
                    handler: function(){
                        SearchByParentPurchaseOrderName(Ext.getCmp('parent_purchaseOrder_search_field').getValue());
                    }
                }, ' '
            ]}),
	bbar: new Ext.PagingToolbar({
            pageSize: list_size,
            store: store_parent_purchaseOrders,
            displayInfo: true,
            displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
            beforePageText: '<?php __('Page'); ?>',
            afterPageText: '<?php __('of {0}'); ?>',
            emptyMsg: '<?php __('No data to display'); ?>'
	})
    });
    g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-purchaseOrder').enable();
	g.getTopToolbar().findById('delete-parent-purchaseOrder').enable();
        g.getTopToolbar().findById('view-purchaseOrder2').enable();
	if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-purchaseOrder').disable();
            g.getTopToolbar().findById('view-purchaseOrder2').disable();
	}
    });
    g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
            g.getTopToolbar().findById('edit-parent-purchaseOrder').disable();
            g.getTopToolbar().findById('delete-parent-purchaseOrder').enable();
            g.getTopToolbar().findById('view-purchaseOrder2').disable();
	}
	else if(this.getSelections().length == 1){
            g.getTopToolbar().findById('edit-parent-purchaseOrder').enable();
            g.getTopToolbar().findById('delete-parent-purchaseOrder').enable();
            g.getTopToolbar().findById('view-purchaseOrder2').enable();
	}
	else{
            g.getTopToolbar().findById('edit-parent-purchaseOrder').disable();
            g.getTopToolbar().findById('delete-parent-purchaseOrder').disable();
            g.getTopToolbar().findById('view-purchaseOrder2').disable();
	}
    });



    var parentPurchaseOrdersViewWindow = new Ext.Window({
	title: 'PurchaseOrder Under the selected Item',
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
                    parentPurchaseOrdersViewWindow.close();
		}
            }]
    });

    store_parent_purchaseOrders.load({
        params: {
            start: 0,    
            limit: list_size
        }
    });