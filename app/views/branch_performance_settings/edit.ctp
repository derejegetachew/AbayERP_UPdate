		<?php
			$this->ExtForm->create('BranchPerformanceSetting');
			$this->ExtForm->defineFieldFunctions();
		?>


		var BranchPerformanceSettingEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				{
				xtype: 'label',
			text: '<?php __('Please use this edit for only human errors. This is not used for normal edit procedure.'); ?>',
			style: 'color: red; padding: 25px; font-weight: bold;'
			},
				
		
				
				<?php $this->ExtForm->input('id', array('hidden' => $branch_performance_setting['BranchPerformanceSetting']['id'])); ?>,

				{   
                                xtype:'fieldset',
                                title: 'Goal/Objective',
                                autoHeight: true,
                                boxMinHeight: 300,
                                items: [{
                                        layout:'column',
                                        items:[{
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[
                                                
                                               
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $positions;
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['position_id'];
					$this->ExtForm->input('position_id', $options);
				?>, 
                    <?php 
					$options = array();
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['measure'];
					$this->ExtForm->input('measure', $options);
				?>,
					<?php 
					$options = array();
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['weight'];
					$this->ExtForm->input('weight', $options);
				?>,
				<?php 
					$options = array();
					$options = array('xtype' => 'combo', 'fieldLabel' => 'Effective Quarter');
					$options['items'] = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV");
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['start_quarter'];
					$this->ExtForm->input('start_quarter', $options);
					
				?>,
												
                                                
                                            ]
                                        }, {
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[ 
				<?php 
					$options = array( );
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['goal'];
					$this->ExtForm->input('goal', $options);
				?>,
                   <?php 
					$options = array( );
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['target'];
					$this->ExtForm->input('target', $options);
				?>,
				
				<?php 
														$options = array('fieldLabel' => 'Effective Budget Year');
														
															$options['items'] = $budget_years;
															$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['start_budget_year_id'];
														    $this->ExtForm->input('start_budget_year_id', $options);
													?>, 
												
                                            ]
                                        }
                                    ]
                                }, 
								
                                
                                ]
                            }, 
				{   
                                xtype:'fieldset',
                                title: 'Rate settings',
                                autoHeight: true,
                                boxMinHeight: 300,
                                items: [{
                                        layout:'column',
                                        items:[{
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[
                                                <?php 
					$options = array();
					$options = array('fieldLabel' => '5 Rating  Min');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['five_pointer_min'];
					$this->ExtForm->input('five_pointer_min', $options);
				?>,
				<?php 
					$options = array();
					$options = array('fieldLabel' => '4 Rating  Min');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['four_pointer_min'];
					$this->ExtForm->input('four_pointer_min', $options);
				?>,
                          
						  <?php 
					$options = array();
					$options = array('fieldLabel' => '3 Rating  Min');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['three_pointer_min'];
					$this->ExtForm->input('three_pointer_min', $options);
				?>,

				<?php 
					$options = array();
					$options = array('fieldLabel' => '2 Rating  Min');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['two_pointer_min'];
					$this->ExtForm->input('two_pointer_min', $options);
				?>,

				<?php 
					$options = array();
					$options = array('fieldLabel' => '1 Rating  Min');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['one_pointer_min'];
					$this->ExtForm->input('one_pointer_min', $options);
				?>,
										
                                             
												
                                                
                                            ]
                                        }, {
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[ 

												
				<?php 
					$options = array();
					$options = array('fieldLabel' => 'Max(included)');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['five_pointer_max_included'];
					$this->ExtForm->input('five_pointer_max_included', $options);
				?>,

				<?php 
					$options = array();
					$options = array('fieldLabel' => 'Max(included)');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['four_pointer_max_included'];
					$this->ExtForm->input('four_pointer_max_included', $options);
				?>,

				<?php 
					$options = array();
					$options = array('fieldLabel' => 'Max(included)');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['three_pointer_max_included'];
					$this->ExtForm->input('three_pointer_max_included', $options);
				?>,

				<?php 
					$options = array();
					$options = array('fieldLabel' => 'Max(included)');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['two_pointer_max_included'];
					$this->ExtForm->input('two_pointer_max_included', $options);
				?>,

				<?php 
					$options = array();
					$options = array('fieldLabel' => 'Max(included)');
					$options['value'] = $branch_performance_setting['BranchPerformanceSetting']['one_pointer_max_included'];
					$this->ExtForm->input('one_pointer_max_included', $options);
				?>,

					
											
                        					
											
                                            ]
                                        }
                                    ]
                                }, 
                                
                                ]
                            }, 
				
				
				]
		});



		function CloseSetting(){

			var id = <?php echo $branch_performance_setting['BranchPerformanceSetting']['id'] ?>;
	
	Ext.Ajax.request({
		
		url: '<?php echo $this->Html->url(array('controller' => 'branchPerformanceSettings', 'action' => 'close_setting')); ?>/'+id,
		success: function(response, opts) {
			var branchPerformanceSetting_data = response.responseText;
			
			eval(branchPerformanceSetting_data);
			
			CloseSettingWindow.show();
		},
		failure: function(response, opts) {
			Ext.Msg.alert('<?php __('Error'); ?>', '<?php __('Cannot get the branchPerformanceSettings edit form. Error code'); ?>: ' + response.status);
		}
	});
	
}

	

		
		var BranchPerformanceSettingEditWindow = new Ext.Window({
			title: '<?php __('Edit Branch Performance Setting'); ?>',
			width: 700,
			minWidth: 700,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: BranchPerformanceSettingEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					BranchPerformanceSettingEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Branch Performance Setting.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(BranchPerformanceSettingEditWindow.collapsed)
						BranchPerformanceSettingEditWindow.expand(true);
					else
						BranchPerformanceSettingEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				hidden: 'false',
				handler: function(btn){
					BranchPerformanceSettingEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							BranchPerformanceSettingEditWindow.close();
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
			}
			,{
				text: '<?php __('Close Setting'); ?>',
				handler: function(btn){
			
					CloseSetting();
					
				}
			}
				,{
				text: '<?php __('Cancel'); ?>',
				handler: function(btn){
					BranchPerformanceSettingEditWindow.close();
				}
			}]
		});
