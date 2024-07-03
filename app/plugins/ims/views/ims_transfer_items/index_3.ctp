//<script>
var store_parent_imsTransferItems = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','code','description','measurement','remaining','quantity','unit_price','remark','tag'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'list_transfer_items_data2', $transfer_id)); ?>'	})
});


function ViewImsTransferItem(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var ImsTransferItem_data = response.responseText;

			eval(ImsTransferItem_data);

			ImsTransferItemViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the Transfer Item view form. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentImsTransferItemName(value){
	var conditions = '\'ImsTransferItem.name LIKE\' => \'%' + value + '%\'';
	store_parent_imsTransferItems.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentImsTransferItemData() {
	store_parent_imsTransferItems.reload();
}

  var editor = new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });
	
	function DeleteRow(){		
        var selectedRows = g.getSelectionModel().getSelections();
        
        if(selectedRows.length >0)
            store_parent_imsTransferItems.remove(selectedRows);
        else
            Ext.Msg.alert('Status', 'Please select at least one record to delete!');
	}
	
    
	function Transfer(){
	  var to_user = c.getForm().findField('to_user').getValue();
	  var from_user = c.getForm().findField('from_user').getValue();
	  var from_branch = c.getForm().findField('from_branch').getValue();
	 // var to_branch = c.getForm().findField('to_branch').getValue();

	 //start Mycode //
	  var to_branch ="not_required";
	 //ende my code //
	  var number = c.getForm().findField('number').getValue();
       if(to_branch==''|| to_user=='' ) {
			Ext.Msg.alert('Status','Please select to employee first');
			return 0;
            }
		//var from_branch = c.getForm().findField('from_branch').getValue();
		//var to_branch = c.getForm().findField('to_branch').getValue();
		//var from_user = c.getForm().findField('from_user').getValue();
		//var to_user = c.getForm().findField('to_user').getValue();
		//var number = c.getForm().findField('number').getValue();
		
		if(from_branch != '' && to_branch != '' && from_user != '' && to_user != ''){
			var records = store_parent_imsTransferItems.data.items, fields = store_parent_imsTransferItems.fields;		
			if(records.length<=0){
				Ext.Msg.alert('<?php __('Error'); ?>','There are no items available for transfer at this time');
				return 0;
			  }
			var param = {};        
			for(var i = 0; i < records.length; i++) {
				for(var j = 0; j < fields.length; j++){
					param[ i + '^' + fields['items'][j]['name']] = Ext.encode(records[i].get(fields['items'][j]['name']));
				}
			}
			Ext.Ajax.request({
				url: '<?php echo $this->Html->url(array('controller' => 'ims_transfers', 'action' => 'add_transfer2', $transfer_id)); ?>/'+from_branch+'/'+to_branch+'/'+from_user+'/'+to_user+'/'+number,
				params:param,
				method: 'POST',				
				success: function(response, opts){
					store_parent_imsTransferItems.commitChanges();
					//RefreshImsTransferData();
					parentimsTransferItemsViewWindow.close();
					var json = eval("(" + response.responseText + ")");
					Ext.Msg.alert('<?php __('Result'); ?>', json.msg);
				},
				failure: function(response, opts){
					var json = eval("(" + response.responseText + ")");
					Ext.Msg.alert('<?php __('Error'); ?>', json.errormsg);
				}
			});
		}
		else{
			Ext.Msg.alert('Error','Please fill required information first');
		}
    }
	
	function checkquanitity(val){
        var sm = parentimsTransferItemsViewWindow.findById('ImsTransferItemGrid').getSelectionModel();
        var sel = sm.getSelected();
        if (sm.hasSelection()){
            remaining=sel.data.remaining;
                msg = "";
            quantity = Ext.getCmp('data[quantity]').getValue();
           
            if(quantity > remaining){
                msg = 'Value more than Remaining';

                return msg; 
            }else 
                return true;
        }
    }

var g = new Ext.grid.GridPanel({
	title: '<?php __('Transfer Items'); ?>',
	store: store_parent_imsTransferItems,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'ImsTransferItemGrid',
	plugins: [editor],
	columns: [
		{header:"<?php __('Id'); ?>", dataIndex: 'id', sortable: true, hidden: true},
		{header:"<?php __('Code'); ?>", dataIndex: 'code', sortable: true},
		{header:"<?php __('description'); ?>", dataIndex: 'description', sortable: true},
		{header: "<?php __('Measurement'); ?>", dataIndex: 'measurement', sortable: true},
		{header: "<?php __('Remaining'); ?>", dataIndex: 'remaining', sortable: true},
		{header: "<?php __('Quantity'); ?>", dataIndex: 'quantity', editor: { id:'data[quantity]', xtype: 'numberfield', allowBlank: false, validator:checkquanitity }, sortable: true},
		{header: "<?php __('Unit Price'); ?>", dataIndex: 'unit_price', sortable: true},
		{header: "<?php __('Remark'); ?>", dataIndex: 'remark', editor: { id:'data[remark]', allowBlank: true }, sortable: true},
		{header: "<?php __('Tag'); ?>", dataIndex: 'tag', editor: { id:'data[tag]', allowBlank: true, xtype: 'textarea' }, sortable: true, align:'left'} 	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            //ViewImsTransferItem(Ext.getCmp('ImsTransferItemGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_imsTransferItems,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	
	if(this.getSelections().length > 1){
		
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		
	}
	else if(this.getSelections().length == 1){
	}
	else{
		
	}
});

var c = new Ext.form.FormPanel({
        baseCls: 'x-plain',
        labelWidth: 100,
        labelAlign: 'right',
		layout:'column',
		items: [{
				columnWidth:.5,
				layout: 'form',				
				defaultType: 'textfield',
                unstyled :true,
				items:[
			 {
				xtype: 'textfield',
				fieldLabel: 'Transfer Number',
				readOnly: 'true',
				value: '<?php date_default_timezone_set("Africa/Addis_Ababa"); echo date("Ymd").'/'.str_pad(($count + 1), 3,'0',STR_PAD_LEFT)?>',
				id: 'number',
				name: 'number',
			},
			{
				xtype: 'textfield',
				hidden:true,
				value: '<?php echo $from_user['id'];?>',
				id: 'from_user',
				name: 'from_user',
			},
			
			{
			xtype: 'label',
            text: 'From Employee:  <?php echo $from_user['first_name'];?>  <?php echo $from_user['middle_name'];?>  <?php echo $from_user['last_name'];?> ',
            forId: 'name',
			style: 'font-size: 15px'
        },
		{
				xtype: 'textfield',
				hidden:true,
				value: '<?php echo $from_branch['id'];?>',
				id: 'from_branch',
				name: 'from_branch',
			},
		{
			xtype: 'label',
            text: 'From Branch:  <?php echo $from_branch['name'];?>',
            forId: 'name1',
			style: 'font-size: 14px'
        },
			/*  {
				xtype: 'textfield',
				fieldLabel: 'From Employee:',
				readOnly: 'true',
				hidden:true,
				value: '<?php //echo $from_user['first_name'];?>  <?php //echo $from_user['middle_name'];?>  <?php //echo $from_user['last_name'];?>',
				id: 'number1',
				name: 'number1',
			    },
				{
				xtype: 'textfield',
				hidden:true,
				fieldLabel: 'From Branch:',
				readOnly: 'true',
				value: '<?php //echo $from_branch['name'];?>',
				id: 'number2',
				name: 'number3',
			    },
			
			{
				xtype: 'combo',
				store: new Ext.data.ArrayStore({
					sortInfo: { field: "name", direction: "ASC" },
					storeId: 'my_array_store',
					id: 0,
					fields: ['id','name'],
					
					data: [
						/*
					<?php //foreach($branches as $branch){?>
					['<?php //echo $branch['Branch']['id']?>','<?php //echo $branch['Branch']['name']?>'],
					<?php
					//}
					?>
					]
				}),					
				displayField: 'name',
				typeAhead: true,
				hiddenName:'data[ImsTransfer][from_branch]',
				id: 'from_branch',
				name: 'from_branch',
				mode: 'local',					
				triggerAction: 'all',
				emptyText: 'Select branch',
				selectOnFocus:true,
				valueField: 'id',
				fieldLabel: '<span style="color:red;">*</span> From Branch',
				allowBlank: false,
				editable: true,
				layout: 'form',
				lazyRender: true,
				blankText: 'Your input is invalid.',
			},
			*/
                 
/*
			    {
				xtype: 'combo',
				store: new Ext.data.ArrayStore({
					sortInfo: { field: "name", direction: "ASC" },
					storeId: 'my_array_store',
					id: 0,
					fields: ['id','name'],
					
					data: [
					<?php //foreach($branches as $branch){?>
					['<?php // echo $branch['Branch']['id']?>','<?php //echo $branch['Branch']['name']?>'],
					<?php
					//}
					?>
					]
					
				}),					
				displayField: 'name',
				typeAhead: true,
				hiddenName:'data[ImsTransfer][to_branch]',
				id: 'to_branch',
				name: 'to_branch',
				mode: 'local',					
				triggerAction: 'all',
				emptyText: 'Select branch',
				selectOnFocus:true,
				valueField: 'id',
				fieldLabel: '<span style="color:red;">*</span> To Branch',
				allowBlank: false,
				editable: true,
				layout: 'form',
				lazyRender: true,
				blankText: 'Your input is invalid.',
			}
			*/
			]
			},
		

			{
				columnWidth:.5,
				layout: 'form',				
				defaultType: 'textfield',
                unstyled :true,
				items:[
			 /*{
				xtype: 'combo',
				store: new Ext.data.ArrayStore({
					sortInfo: { field: "name", direction: "ASC" },
					storeId: 'my_array_store',
					id: 0,
					fields: ['id','name'],
					
					data: [
					<?php //foreach($employees as $employee){?>
					['<?php //echo $employee['People']['id']?>','<?php //echo $employee['People']['first_name'].' '.$employee['People']['middle_name'].' '.$employee['People']['last_name']?>'],
					<?php
					//}
					?>
					]
					
				}),					
				displayField: 'name',
				typeAhead: true,
				hiddenName:'data[ImsTransfer][from_user]',
				id: 'from_user',
				name: 'from_user',
				mode: 'local',					
				triggerAction: 'all',
				emptyText: 'Select Employee',
				selectOnFocus:true,
				valueField: 'id',
				fieldLabel: '<span style="color:red;">*</span> From Employee',
				allowBlank: false,
				editable: true,
				layout: 'form',
				lazyRender: true,
				blankText: 'Your input is invalid.',
			},
			*/
			{
				xtype: 'combo',
				store: new Ext.data.ArrayStore({
					sortInfo: { field: "name", direction: "ASC" },
					storeId: 'my_array_store',
					id: 0,
					fields: ['id','name'],
					
					data: [
					<?php foreach($employees as $employee){?>
					['<?php echo $employee['People']['id']?>','<?php echo $employee['People']['first_name'].' '.$employee['People']['middle_name'].' '.$employee['People']['last_name']?>'],
					<?php
					}
					?>
					]
					
				}),					
				displayField: 'name',
				typeAhead: true,
				hiddenName:'data[ImsTransfer][to_user]',
				id: 'to_user',
				name: 'to_user',
				mode: 'local',					
				triggerAction: 'all',
				emptyText: 'Select Employee',
				selectOnFocus:true,
				valueField: 'id',
				fieldLabel: '<span style="color:red;">*</span> To Employee',
				allowBlank: false,
				editable: true,
				layout: 'form',
				lazyRender: true,
				blankText: 'Your input is invalid.',
			}, 
			// {
			// 	xtype: 'combo',
			// 	store: new Ext.data.ArrayStore({
			// 		sortInfo: { field: "name", direction: "ASC" },
			// 		storeId: 'my_array_store',
			// 		id: 0,
			// 		fields: ['id','name'],
					
			// 		data: [
			// 		<?php //foreach($branches as $branch){?>
			// 		['<?php // echo $branch['Branch']['id']?>','<?php //echo $branch['Branch']['name']?>'],
			// 		<?php
			// 		}
			// 		?>
			// 		]
					
			// 	}),					
			// 	displayField: 'name',
			// 	typeAhead: true,
			// 	hiddenName:'data[ImsTransfer][to_branch]',
			// 	id: 'to_branch',
			// 	name: 'to_branch',
			// 	mode: 'local',					
			// 	triggerAction: 'all',
			// 	emptyText: 'Select branch',
			// 	selectOnFocus:true,
			// 	valueField: 'id',
			// 	fieldLabel: '<span style="color:red;">*</span>Branch',
			// 	//allowBlank: false,
			// 	editable: true,
			// 	layout: 'form',
			// 	lazyRender: true,
			// 	blankText: 'Your input is invalid.',
			// }
			]
			}
			]
		});
		
var parentimsTransferItemsViewWindow = new Ext.Window({
	title: 'Transfer Items for transfer',
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
		c,
		g
	],

	buttons: [{
				text: '<?php __('Delete Row'); ?>',
				handler: function(btn){
					DeleteRow();
				}
			},
			{
				text: '<?php __('Transfer'); ?>',
				handler: function(btn){
					Transfer();
					
				}
			}
			,{
				text: 'Close',
				handler: function(btn){
					parentimsTransferItemsViewWindow.close();
				}
			}]
});

store_parent_imsTransferItems.load({
    params: {
        start: 0,    
        limit: list_size
    }
});