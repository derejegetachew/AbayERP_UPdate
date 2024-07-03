		<?php
			$this->ExtForm->create('TaxRule');
			$this->ExtForm->defineFieldFunctions();
		?>
		var TaxRuleAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'taxRules', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
                        <?php $this->ExtForm->input('payroll_id', array('hidden' => $this->Session->read('Auth.User.payroll_id'))); ?>,
				<?php 
					$options = array();
					$this->ExtForm->input('name', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('min', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('max', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('percent', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('deductable', $options);
				?>		]
		});
		
		var TaxRuleAddWindow = new Ext.Window({
			title: '<?php __('Add Tax Rule'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: TaxRuleAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					TaxRuleAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Tax Rule.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(TaxRuleAddWindow.collapsed)
						TaxRuleAddWindow.expand(true);
					else
						TaxRuleAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					TaxRuleAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TaxRuleAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentTaxRuleData();
<?php } else { ?>
							RefreshTaxRuleData();
<?php } ?>
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Warning'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			}, {
				text: '<?php __('Save & Close'); ?>',
				handler: function(btn){
					TaxRuleAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							TaxRuleAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentTaxRuleData();
<?php } else { ?>
							RefreshTaxRuleData();
<?php } ?>
						},
						failure: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Warning'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.errormsg,
                                icon: Ext.MessageBox.ERROR
							});
						}
					});
				}
			},{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					TaxRuleAddWindow.close();
				}
			}]
		});
