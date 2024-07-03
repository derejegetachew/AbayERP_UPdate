var store_parent_loans = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
		root:'rows',
		totalProperty: 'results',
		fields: [
			'id','employee','Type','Per_month','start','no_months','total','status'	
		]
	}),
	proxy: new Ext.data.HttpProxy({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'list_data', $parent_id)); ?>'	})
});


function AddParentLoan() {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'add', $parent_id)); ?>',
		success: function(response, opts) {
			var parent_loan_data = response.responseText;
			
			eval(parent_loan_data);
			
			LoanAddWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loan add form. Error code'); ?>: ' + response.status);
		}
	});
}

function EditParentLoan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'edit')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_loan_data = response.responseText;
			
			eval(parent_loan_data);
			
			LoanEditWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function SkipParentLoan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'skip')); ?>/'+id+'/<?php echo $parent_id; ?>',
		success: function(response, opts) {
			var parent_loan_data = response.responseText;
			
			eval(parent_loan_data);
			
			LoanSkipWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loan edit form. Error code'); ?>: ' + response.status);
		}
	});
}

function ViewLoan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'view')); ?>/'+id,
		success: function(response, opts) {
			var loan_data = response.responseText;

			eval(loan_data);

			LoanViewWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loan view form. Error code'); ?>: ' + response.status);
		}
	});
}


function CloseParentLoan(id) {
	Ext.Ajax.request({
		url: '<?php echo $this->Html->url(array('controller' => 'loans', 'action' => 'close')); ?>/'+id,
		success: function(response, opts) {
			var loan_data = response.responseText;

			eval(loan_data);

			LoanCloseWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the loan to be closed. Error code'); ?>: ' + response.status);
		}
	});
}

function SearchByParentLoanName(value){
	var conditions = '\'Loan.name LIKE\' => \'%' + value + '%\'';
	store_parent_loans.reload({
		 params: {
			start: 0,
			limit: list_size,
			conditions: conditions
	    }
	});
}

function RefreshParentLoanData() {
	store_parent_loans.reload();
}



var g = new Ext.grid.GridPanel({
	title: '<?php __('Loans'); ?>',
	store: store_parent_loans,
	loadMask: true,
	stripeRows: true,
	height: 300,
	anchor: '100%',
    id: 'loanGrid',
	columns: [
		{header: "<?php __('Loan Type'); ?>", dataIndex: 'Type', sortable: true},
		{header: "<?php __('Total'); ?>", dataIndex: 'total', sortable: true},
		{header: "<?php __('Deductions'); ?>", dataIndex: 'Per_month', sortable: true},
		{header: "<?php __('Start Date'); ?>", dataIndex: 'start', sortable: true},
		{header: "<?php __('Number of Months'); ?>", dataIndex: 'no_months', sortable: true},
                {header: "<?php __('Status'); ?>", dataIndex: 'status', sortable: true}	],
	sm: new Ext.grid.RowSelectionModel({
		singleSelect: false
	}),
	viewConfig: {
		forceFit: true
	},
    listeners: {
        celldblclick: function(){
            ViewLoan(Ext.getCmp('loanGrid').getSelectionModel().getSelected().data.id);
        }
    },
	tbar: new Ext.Toolbar({
		items: [{
				xtype: 'tbbutton',
				text: '<?php __('New Loan'); ?>',
				tooltip:'<?php __('<b>Add Loan</b><br />Click here to create a new Loan'); ?>',
				icon: 'img/table_add.png',
				cls: 'x-btn-text-icon',
				handler: function(btn) {
					AddParentLoan();
				}
			}, ' ', '-', ' ',{
				xtype: 'tbbutton',
				text: '<?php __('Edit'); ?>',
				id: 'edit-parent-loan',
				tooltip:'<?php __('<b>Edit Loan</b><br />Click here to modify the selected Loan'); ?>',
				icon: 'img/table_edit.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
					var sm = g.getSelectionModel();
					var sel = sm.getSelected();
					if (sm.hasSelection()){
						EditParentLoan(sel.data.id);
					};
				}
			},' ', '-', ' ', {
				xtype: 'tbbutton',
				text: '<?php __('Close'); ?>',
				id: 'delete-parent-loan',
				tooltip:'<?php __('End Loan'); ?>',
				icon: 'img/table_delete.png',
				cls: 'x-btn-text-icon',
				disabled: true,
				handler: function(btn) {
                                var sm = g.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                        if(sel.data.status=='closed')
                        alert('Loan already closed!');
                        else
                            CloseParentLoan(sel.data.id);
                        };
                                   
                                                
					
				}
			}
	]}),
	bbar: new Ext.PagingToolbar({
		pageSize: list_size,
		store: store_parent_loans,
		displayInfo: true,
		displayMsg: '<?php __('Displaying {0} - {1} of {2}'); ?>',
		beforePageText: '<?php __('Page'); ?>',
		afterPageText: '<?php __('of {0}'); ?>',
		emptyMsg: '<?php __('No data to display'); ?>'
	})
});
g.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
	g.getTopToolbar().findById('edit-parent-loan').enable();
	g.getTopToolbar().findById('delete-parent-loan').enable();
        //g.getTopToolbar().findById('view-loan2').enable();
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-loan').disable();
              //  g.getTopToolbar().findById('view-loan2').disable();
	}
});
g.getSelectionModel().on('rowdeselect', function(sm, rowIdx, r) {
	if(this.getSelections().length > 1){
		g.getTopToolbar().findById('edit-parent-loan').disable();
		g.getTopToolbar().findById('delete-parent-loan').enable();
              //  g.getTopToolbar().findById('view-loan2').disable();
	}
	else if(this.getSelections().length == 1){
		g.getTopToolbar().findById('edit-parent-loan').enable();
		g.getTopToolbar().findById('delete-parent-loan').enable();
              //  g.getTopToolbar().findById('view-loan2').enable();
	}
	else{
		g.getTopToolbar().findById('edit-parent-loan').disable();
		g.getTopToolbar().findById('delete-parent-loan').disable();
            //    g.getTopToolbar().findById('view-loan2').disable();
	}
});



var parentLoansViewWindow = new Ext.Window({
	title: 'Loans of : <b><?php echo $employee['User']['Person']['first_name'] . ' ' . $employee['User']['Person']['middle_name'] . ' ' . $employee['User']['Person']['last_name']; ?></b>',
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
			parentLoansViewWindow.close();
		}
	}]
});

store_parent_loans.load({
    params: {
        start: 0,    
        limit: list_size
    }
});