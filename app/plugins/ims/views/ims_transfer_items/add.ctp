		<?php
			$this->ExtForm->create('ImsTransferItem');
			$this->ExtForm->defineFieldFunctions();
		?>
		var ImsTransferItemAddForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'imsTransferItems', 'action' => 'add')); ?>',
			defaultType: 'textfield',

			items: [
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_transfers;
					$this->ExtForm->input('ims_transfer_id', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $ims_items;
					$this->ExtForm->input('ims_item_id', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('quantity', $options);
				?>,
				<?php 
					$options = array();
					$this->ExtForm->input('unit_price', $options);
				?>			]
		});
		
		var ImsTransferItemAddWindow = new Ext.Window({
			title: '<?php __('Add Ims Transfer Item'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: ImsTransferItemAddForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					ImsTransferItemAddForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to insert a new Ims Transfer Item.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(ImsTransferItemAddWindow.collapsed)
						ImsTransferItemAddWindow.expand(true);
					else
						ImsTransferItemAddWindow.collapse(true);
				}
			}],
			buttons: [  {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					ImsTransferItemAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferItemAddForm.getForm().reset();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferItemData();
<?php } else { ?>
							RefreshImsTransferItemData();
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
					ImsTransferItemAddForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							ImsTransferItemAddWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentImsTransferItemData();
<?php } else { ?>
							RefreshImsTransferItemData();
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
					ImsTransferItemAddWindow.close();
				}
			}]
		});
