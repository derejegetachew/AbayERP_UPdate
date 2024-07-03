		<?php
			$this->ExtForm->create('Education');
			$this->ExtForm->defineFieldFunctions();
		?>
  var store_level_of_attainment = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'level_of_attainment','field_of_study','institution'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'level_of_attainment')); ?>'
	})
    });
          store_level_of_attainment.load({
            params: {
                start: 0,
                limit:100
            }
        });
          var store_field_of_study = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'level_of_attainment','field_of_study','institution'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'field_of_study')); ?>'
	})
    });
          store_field_of_study.load({
            params: {
                start: 0,
                limit:100
            }
        });
          var store_institution = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'level_of_attainment','field_of_study','institution'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'institution')); ?>'
	})
    });
          store_institution.load({
            params: {
                start: 0
            }
        });
		var EducationEditForm = new Ext.form.FormPanel({
			baseCls: 'x-plain',
			labelWidth: 100,
			labelAlign: 'right',
			url:'<?php echo $this->Html->url(array('controller' => 'educations', 'action' => 'edit')); ?>',
			defaultType: 'textfield',

			items: [
				<?php $this->ExtForm->input('id', array('hidden' => $education['Education']['id'])); ?>,
				<?php 
					$options = array();
                                        $options = array('xtype' => 'combo', 'anchor' => '100%', 'fieldLabel' => 'Level of Attainment');
                                        $options['items'] = array('10'=>'10th Complete','12'=>'12th Complete','Certificate'=>'Certificate','101'=>'10+1','102'=>'10+2','103'=>'10+3','level1'=>'TVET Level I','level2'=>'TVET Level II','level3'=>'TVET Level III','level4'=>'TVET Level IV','level5'=>'TVET Level V','Diploma'=>'Diploma','BA'=>'BA Degree','BSC'=>'BSC Degree','LLB'=>'LLB Degree','BED'=>'BED','MA'=>'MA Degree','MSC'=>'MSC Degree','MBA'=>'MBA Degree','EMBA'=>'EMBA Degree','LLM'=>'LLM Degree','PhD'=>'PhD');
                                        $options['value'] = $education['Education']['level_of_attainment'];
					$this->ExtForm->input('level_of_attainment', $options);
				?>,
				{
                                                    xtype: 'combo',
                                                    name: 'data[Education][field_of_study]',
                                                    emptyText: 'All',
                                                    id: 'data[Education][field_of_study]',
                                                    name: 'data[Education][field_of_study]',
                                                    store : store_field_of_study,
                                                    displayField : 'field_of_study',
                                                    valueField : 'id',
                                                    fieldLabel: '<span style="color:red;">*</span> Field of Study',
                                                    mode: 'local',
                                                    disableKeyFilter : true,
                                                    allowBlank: false,
                                                    emptyText: '',
                                                    editable: true,
                                                    triggerAction: 'all',
                                                    hideTrigger:true,
                                                    width:250,
                                                    value:'<?php echo $education['Education']['field_of_study']; ?>'
                                                },
				{
                                                    xtype: 'combo',
                                                    name: 'data[Education][institution]',
                                                    emptyText: 'All',
                                                    id: 'data[Education][institution]',
                                                    name: 'data[Education][institution]',
                                                    store : store_institution,
                                                    displayField : 'institution',
                                                    valueField : 'id',
                                                    fieldLabel: '<span style="color:red;">*</span> Institution',
                                                    mode: 'local',
                                                    disableKeyFilter : true,
                                                    allowBlank: false,
                                                    typeAhead: true,
                                                    emptyText: '',
                                                    editable: true,
                                                    triggerAction: 'all',
                                                    hideTrigger:true,
                                                    width:250,
                                                    value:'<?php echo $education['Education']['institution']; ?>'
                                                },
				<?php 
					$options = array();
					$options['value'] = $education['Education']['date'];
					$this->ExtForm->input('date', $options);
				?>,
				<?php 
					$options = array();
					$options['value'] = $education['Education']['is_bank_related'];
					$this->ExtForm->input('is_bank_related', $options);
				?>,
				<?php 
					$options = array();
					if(isset($parent_id))
						$options['hidden'] = $parent_id;
					else
						$options['items'] = $employees;
					$options['value'] = $education['Education']['employee_id'];
					$this->ExtForm->input('employee_id', $options);
				?>			]
		});
		
		var EducationEditWindow = new Ext.Window({
			title: '<?php __('Edit Education'); ?>',
			width: 400,
			minWidth: 400,
			autoHeight: true,
			layout: 'fit',
			modal: true,
			resizable: true,
			plain:true,
			bodyStyle:'padding:5px;',
			buttonAlign:'right',
			items: EducationEditForm,
			tools: [{
				id: 'refresh',
				qtip: 'Reset',
				handler: function () {
					EducationEditForm.getForm().reset();
				},
				scope: this
			}, {
				id: 'help',
				qtip: 'Help',
				handler: function () {
					Ext.Msg.show({
						title: 'Help',
						buttons: Ext.MessageBox.OK,
						msg: 'This form is used to modify an existing Education.',
						icon: Ext.MessageBox.INFO
					});
				}
			}, {
				id: 'toggle',
				qtip: 'Collapse / Expand',
				handler: function () {
					if(EducationEditWindow.collapsed)
						EducationEditWindow.expand(true);
					else
						EducationEditWindow.collapse(true);
				}
			}],
			buttons: [ {
				text: '<?php __('Save'); ?>',
				handler: function(btn){
					EducationEditForm.getForm().submit({
						waitMsg: '<?php __('Submitting your data...'); ?>',
						waitTitle: '<?php __('Wait Please...'); ?>',
						success: function(f,a){
							Ext.Msg.show({
								title: '<?php __('Success'); ?>',
								buttons: Ext.MessageBox.OK,
								msg: a.result.msg,
                                icon: Ext.MessageBox.INFO
							});
							EducationEditWindow.close();
<?php if(isset($parent_id)){ ?>
							RefreshParentEducationData();
<?php } else { ?>
							RefreshEducationData();
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
					EducationEditWindow.close();
				}
			}]
		});