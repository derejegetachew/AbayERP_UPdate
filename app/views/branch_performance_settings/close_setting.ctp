<?php
			$this->ExtForm->create('BranchPerformanceSetting');
			$this->ExtForm->defineFieldFunctions();
			
		?>
	var CloseSettingForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'close_setting')); ?>',
			defaultType: 'textfield',

			items: [
				 <?php $this->ExtForm->input('id', array('hidden' => $branch_performance_setting['BranchPerformanceSetting']['id'])); ?>, 
				 {
			xtype: 'label',
			text: '<?php __('Are you sure you want to close this setting. Do you know what you are doing?'); ?>',
			style: 'color: red;  '
			}

				]
		});
		
		var CloseSettingWindow = new Ext.Window({
			title: '<?php __('Close Setting'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: CloseSettingForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					CloseSettingForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Ho Performance Plan.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ChangeStatusWindow.collapsed)
					CloseSettingWindow.expand(true);
					else
					CloseSettingWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Close Setting'); ?>',
				handler: function(btn){
					CloseSettingForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							CloseSettingWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentBranchPerformanceSettingData();
<?php } else { ?>
							RefreshBranchPerformanceSettingData();
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
					CloseSettingWindow.close();
				}
			}]
		});
