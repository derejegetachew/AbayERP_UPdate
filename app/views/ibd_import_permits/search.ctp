var currentlyToggled = '';
var toggleHandler = function(btn, pressed){
	var clickedButton = btn.getText();
	currentlyToggled = clickedButton;
}

var ParamStore = new Ext.data.ArrayStore({ fields: ['value', 'text']});

function AddParameter(field, value){
	if(!validateInput(currentlyToggled,field,value)){
		Ext.Msg.alert('Invalid Input','Your Input is Invalid');
		return;
	}
	if(currentlyToggled == "IN"){
		row = [[field, '"' + field + '" => array( ' + InsertQuotations(value) + ' )' ]];
	}
	else if(currentlyToggled == "BETWEEN"){
		row = [[field, 'array(' + field + '" BETWEEN ? AND ?" => array( ' + InsertQuotations(value) + ' ))']];
	}
	else if(currentlyToggled == "LIKE"){
		row = [[field, '\'' + field + ' LIKE\' => \'%' + value + '%\'']];
	}
	else if(currentlyToggled == "="){
		row = [[field, '\'' + field + '\' => \'' + value + '\'']];
	}
	else
		row = [[ field , "'" + field + ' ' + currentlyToggled + '\' => ' + InsertQuotations(value) ]];
	ParamStore.loadData(row,true);
	ParamStore.reload();
	Ext.getCmp('param_view').doLayout();
}

function validateInput(operation, field, value) {
	if(operation == '' || field == '' || value == '')
		return 0;
	return 1;
}

function InsertQuotations(value) {
	var quotedString = '';
	var values = value.split(',');
	for( i = 0; i < values.length; i++){
		if(i > 0)
			quotedString += ', ';
		quotedString += "'" + values[i].trim() + "'";
	}
	return quotedString;
}

function RemoveParameters(records){
		ParamStore.remove(records);
		ParamStore.reload();
}

function GroupParameters(records, operation){
	if(records.length < 2)
		return 0;
	var finalParameter = '\'' + operation + '\' => array (';
	for(i = 0; i < records.length; i++){
		if(i > 0)
			finalParameter += ', ';
		finalParameter += ' array( ' + records[i].get('text') + ' ) ';
	}
	finalParameter += ')';
	row = [[1, finalParameter]];
	ParamStore.remove(records);
	ParamStore.loadData(row,true);
	ParamStore.reload();
	Ext.getCmp('param_view').doLayout();
	return 1;
}
function finalGrouping(records){
	var conditionsParameter = '';
	for(i = 0; i < records.length; i++){
			if(conditionsParameter == ''){
				conditionsParameter += 'array( ' + records[i].get('text') + ' )';
			}
			else
				conditionsParameter += ', array( ' + records[i].get('text') + ' )';
	}
	return conditionsParameter;
}
var SearchField = new Ext.form.ComboBox({
	name: 'searchField',
	fieldLabel: '<?php __('Field'); ?>',
	anchor: '100%',
	editable: false,
	triggerAction: 'all',
	typeAhead: true,
	store: new Ext.data.ArrayStore({
		fields: ['value_field', 'display_field'],
		data: [
			['IbdImportPermit.PERMIT_ISSUE_DATE', '<?php __('PERMIT ISSUE DATE'); ?>']
,			['IbdImportPermit.NAME_OF_IMPORTER', '<?php __('NAME OF IMPORTER'); ?>']
,			['IbdImportPermit.IMPORT_PERMIT_NO', '<?php __('IMPORT PERMIT NO'); ?>']
,			['IbdImportPermit.currency_id', '<?php __('Currency Id'); ?>']
,			['IbdImportPermit.FCY_AMOUNT', '<?php __('FCY AMOUNT'); ?>']
,			['IbdImportPermit.PREVAILING_RATE', '<?php __('PREVAILING RATE'); ?>']
,			['IbdImportPermit.LCY_AMOUNT', '<?php __('LCY AMOUNT'); ?>']
,			['IbdImportPermit.payment_term_id', '<?php __('Payment Term Id'); ?>']
,			['IbdImportPermit.ITEM_DESCRIPTION_OF_GOODS', '<?php __('ITEM DESCRIPTION OF GOODS'); ?>']
,			['IbdImportPermit.SUPPLIERS_NAME', '<?php __('SUPPLIERS NAME'); ?>']
,			['IbdImportPermit.MINUTE_NO', '<?php __('MINUTE NO'); ?>']
,			['IbdImportPermit.FCY_APPROVAL_DATE', '<?php __('FCY APPROVAL DATE'); ?>']
,			['IbdImportPermit.FCY_APPROVAL_INTIAL_ORDER_NO', '<?php __('FCY APPROVAL INTIAL ORDER NO'); ?>']
,			['IbdImportPermit.FROM_THEIR_FCY_ACCOUNT', '<?php __('FROM THEIR FCY ACCOUNT'); ?>']
,			['IbdImportPermit.THE_PRICE_AS_PER_NBE_SELLECTED', '<?php __('THE PRICE AS PER NBE SELLECTED'); ?>']
,			['IbdImportPermit.NBE_UNDERTAKING', '<?php __('NBE UNDERTAKING'); ?>']
,			['IbdImportPermit.SUPPLIERS_CREDIT', '<?php __('SUPPLIERS CREDIT'); ?>']
,			['IbdImportPermit.REMARK', '<?php __('REMARK'); ?>']
		]
	}),
	mode: 'local',
	displayField: 'display_field',
	valueField: 'value_field'
});

var SearchValue = new Ext.form.TextField({
	id: 'Search_Value',
	fieldLabel: '<?php __('Value'); ?>',
	anchor: '100%'
});

var ibdImportPermitSearchForm = new Ext.form.FormPanel({
	baseCls: 'x-plain',
	labelWidth: 55,
	url: '<?php echo $this->Html->url(array('controller' => 'ibdImportPermits', 'action' => 'search')); ?>',
	defaultType: 'textfield',

	items: [
		{
			xtype: 'fieldset',
			title: '<?php __('Search Parameters'); ?>',
			anchor: '100%, 45%',
			defaultType: 'textfield',
			buttonAlign: 'right',
			items: [
				SearchField,
				{
					xtype: 'toolbar',
					columns: 9,
					defaults: {
						width: '50',
						enableToggle: true,
						toggleGroup : 'btnGroup',
						toggleHandler: toggleHandler
					},
					items: [
						{
							text: '=',
							tooltip: '<?php __('Equal To'); ?>'
						},
						{
							text: '\<\>',
							tooltip: '<?php __('Is Not Equal To'); ?>'
						},
						{
							text: '\<',
							tooltip: '<?php __('Less Than'); ?>'
						},
						{
							text: '\>',
							tooltip: '<?php __('Greater Than'); ?>'
						},
						{
							text: '\<=',
							tooltip: '<?php __('Less Than Or Equal To'); ?>'
						},
						{
							text: '\>=',
							tooltip: '<?php __('Greater Than Or Equal To'); ?>'
						},
						{
							text: 'LIKE',
							tooltip: '<?php __('Like This'); ?>'
						},
						{
							text: 'IN',
							tooltip: '<?php __('Is In This List (Like: a,b,c,...)'); ?>'
						},
						{
							text: 'BETWEEN',
							tooltip: '<?php __('Is Between These Two Values(Like: a,b)'); ?>'
						}
					]
				},
				SearchValue
			],
			buttons : [
				{
					text: '<?php __('Add Parameter'); ?>',
					handler: function(){
						AddParameter(SearchField.getValue(),SearchValue.getValue());
					}
				}
			]
		},{
			xtype: 'fieldset',
			anchor: '100%, 45%',
			title: '<?php __('Edit Parameters'); ?>',
			labelWidth: 0,
			layout: 'hbox',
			items: [{
				xtype: 'panel',
				width: 375,
				height: 110,
				layout: 'fit',
				items: {
						xtype: 'listview',
						id: 'param_view',
						autoScroll: true,
						store: ParamStore,
						multiSelect: true,
						hideHeaders: true,
						columns: [
							{
								header: 'value',
								dataIndex: 'text'
							}
						]
				}
			},
			{
				xtype: 'buttongroup',
				columns: 1,
				height: 100,
				border: false,
				width: 125,
				frame: true,
				iconCls: 'add32',
				items: [
					{
						xtype: 'button',
						text: '<?php __('Remove Parameter'); ?>',
						width: 110,
						handler: function(){
							var selectedRecords = Ext.getCmp('param_view').getSelectedRecords();
							if(selectedRecords.length == 0)
								Ext.Msg.alert('<?php __('Invalid Input'); ?>', '<?php __('You have to select at least one record'); ?>');
							else
								RemoveParameters(selectedRecords);
						}
					},
					{
						xtype: 'button',
						width: 110,
						text: 'AND',
						handler: function(){
							var result = GroupParameters(Ext.getCmp('param_view').getSelectedRecords(), 'AND');
							if(!result)
								Ext.Msg.alert('<?php __('Invalid Input'); ?>','<?php __('You have to select 2 or more records'); ?>');
						}
					},
					{
						xtype: 'button',
						width: 110,
						text: 'OR',
						handler: function(){
							var result = GroupParameters(Ext.getCmp('param_view').getSelectedRecords(), 'OR');
							if(!result)
								Ext.Msg.alert('<?php __('Invalid Input'); ?>','<?php __('You have to select 2 or more records'); ?>');
						}
					}
				]
			}]
		},
		
		{
			xtype: 'button',
			text: '<?php __('Search'); ?>',
			handler: function(){
				if(ParamStore.getCount() == 0)
					Ext.Msg.alert('<?php __('Invalid Input'); ?>','<?php __('Please input at least one search parameter'); ?>');
				else{
				export_all=false;
					ibdImportPermitSearchWindow.close();
					var conditions = finalGrouping(ParamStore.getRange());
					store_ibdImportPermits.reload({
						  params: {
								start: 0,
								limit: list_size,
								conditions: conditions
						   }
					});
				}
			}
		}
	]
});

var ibdImportPermitSearchWindow = new Ext.Window({
	title: '<?php __('Search IbdImportPermit'); ?>',
	modal: true,
	items: ibdImportPermitSearchForm,
	resizable: false,
	width: 550,
	height: 400,
	bodyStyle: 'padding: 5px;',
	layout: 'fit',
	plain: true
});