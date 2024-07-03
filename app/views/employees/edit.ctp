﻿
    <?php
    //print_r($employee);
    $this->ExtForm->create('Employee');
    $this->ExtForm->defineFieldFunctions();
    
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
array_sort_by_column($employee['EmployeeDetail'],"start_date");

    ?>
    var store_positions = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'name'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'positions', 'action' => 'list_data')); ?>'
	})
    });
    var store_city = new Ext.data.Store({
	reader: new Ext.data.JsonReader({
            root:'rows',
            totalProperty: 'results',
            fields: [
                'id', 'city'		
            ]
	}),
	proxy: new Ext.data.HttpProxy({
            url: '<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'list_city')); ?>'
	})
    });
          store_city.load({
            params: {
                start: 0
            }
        });
        var EmployeeEditForm = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            labelWidth: 150,
            labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'Edit')); ?>',
            defaultType: 'textfield',
            frame:true,
            fileUpload: true,
            
            items: {
                xtype:'tabpanel',
                activeTab: 0,
                height: 425,
                id: 'form_tabs',
                tabWidth: 185,
                defaults:{ bodyStyle:'padding:10px'}, 
                items:[{
                        title:'Personal Info',
                        layout:'form',
                        defaultType: 'textfield',
                        id:'personal',
                        items: [{ 
                                xtype: 'compositefield',
                                labelWidth: 120,
                                fieldLabel: 'Full Name',
                                items:[
                                    <?php $this->ExtForm->input('id', array('hidden' => $employee['Employee']['id'])); ?>,
                                    {	xtype: 'hidden',
					name: 'data[Person][id]',
					value: '<?php $this->ExtForm->create('Person'); echo $employee['User']['Person']['id']; ?>'
                                    },
                                    {	xtype: 'hidden',
					name: 'data[EmployeeDetail][id]',
					value: '<?php $this->ExtForm->create('EmployeeDetail'); echo $employee['EmployeeDetail'][0]['id']; ?>'
                                    },
                                    {	xtype: 'hidden',
					name: 'data[User][id]',
					value: '<?php $this->ExtForm->create('User'); echo $employee['User']['id']; ?>'
                                    },
                                     <?php
                                        $this->ExtForm->create('Person');
                                        $options = array();
                                        $options['value'] = $employee['User']['Person']['first_name'];
                                        $this->ExtForm->input('first_name', $options);
                                    ?>,
                                    <?php
                                        $options = array();
                                        $options['value'] = $employee['User']['Person']['middle_name'];
                                        $this->ExtForm->input('middle_name', $options);
                                    ?>,
                                    <?php
                                        $options = array();
                                        $options['value'] = $employee['User']['Person']['last_name'];
                                        $this->ExtForm->input('last_name', $options);
                                    ?>
                                ]
                            },
{ 
                                xtype: 'compositefield',
                                labelWidth: 120,
                                fieldLabel: 'ሙሉ ስም',
                                items:[
                                    <?php
            App::import('Amharic');
                $employee['User']['Person']['first_name_am']=Amharic::decode_amharic($employee['User']['Person']['first_name_am']);
                $employee['User']['Person']['middle_name_am']=Amharic::decode_amharic($employee['User']['Person']['middle_name_am']);
                $employee['User']['Person']['last_name_am']=Amharic::decode_amharic($employee['User']['Person']['last_name_am']);
                                        $options = array(
                                            'enableKeyEvents' => 'true',
                                            'anchor' => '99%');
                                        $options['listeners'] = '{
                                            keypress: function(tb,e){
                                                translateOnKeyPress(e,1);
                                            }
                                        }';
                                         $options['value'] = $employee['User']['Person']['first_name_am'];
                                        $this->ExtForm->input('first_name_am', $options);
                                    ?>,
                                    <?php
                                        $options = array(
                                            'enableKeyEvents' => 'true',
                                            'anchor' => '99%');
                                        $options['listeners'] = '{
                                            keypress: function(tb,e){
                                                translateOnKeyPress(e,1);
                                            }
                                        }';
                                         $options['value'] = $employee['User']['Person']['middle_name_am'];
                                        $this->ExtForm->input('middle_name_am', $options);
                                    ?>,
                                    <?php
                                        $options = array(
                                            'enableKeyEvents' => 'true',
                                            'anchor' => '99%');
                                        $options['listeners'] = '{
                                            keypress: function(tb,e){
                                                translateOnKeyPress(e,1);
                                            }
                                        }';
                                         $options['value'] = $employee['User']['Person']['last_name_am'];
                                        $this->ExtForm->input('last_name_am', $options);
                                    ?>
                                ]
                            },
                            <?php
                                $this->ExtForm->create('Employee');
                                $options = array();
                                $options=array('anchor' => '70%');
                                $options['value'] = $employee['Employee']['mother_name'];
                                $this->ExtForm->input('mother_name', $options);
                            ?>,
                            <?php
                                $this->ExtForm->create('Person');
                                $options = array();
                                $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Sex', 'value' => 'F');
                                $options['items'] = array('M' => 'Male', 'F' => 'Female');
                                $options['value'] = $employee['User']['Person']['sex'];
                                $this->ExtForm->input('sex', $options);
                            ?>,
                            <?php
                                $options = array();
                                $options=array('anchor' => '50%','allowBlank'=>'false');
                                $options['value'] = $employee['User']['Person']['birthdate'];
                                $this->ExtForm->input('birthdate', $options);
                            ?>,
                            <?php
                                $options = array();
                                $options=array('anchor' => '50%');
                                if (isset($parent_id))
                                    $options['hidden'] = $parent_id;
                                else
                                    $options['items'] = $locations;
                                $options['value'] = $employee['User']['Person']['birth_location_id'];
                                $this->ExtForm->input('birth_location_id', $options);
                            ?>, {   
                                xtype:'fieldset',
                                title: 'Address',
                                autoHeight: true,
                                boxMinHeight: 300,
                                items: [{
                                        layout:'column',
                                        items:[{
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[
                                                <?php
                                                    $this->ExtForm->create('Employee');
                                                    $options = array('fieldLabel'=>'Region','allowBlank'=>'true');
                                                    $options['items'] = $locations;
                                                    $options['value'] = $employee['Employee']['emp_loc_id'];
                                                    $this->ExtForm->input('emp_loc_id', $options);
                                                ?>,
                                                <?php
                                                    $options = array();
                                                    $options['value'] = $employee['Employee']['kebele'];
                                                    $this->ExtForm->input('kebele', $options);
                                                ?>, 
                                                <?php
                                                    $options = array();
                                                    $options['value'] = $employee['Employee']['telephone'];
                                                    $this->ExtForm->input('telephone', $options);
                                                ?>
                                            ]
                                        }, {
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[ 
                                                   <?php
                                                    $options = array();
                                                    $options['value'] = $employee['Employee']['city'];
                                                    $this->ExtForm->input('city', $options);
                                                ?>,
                                                <?php
                                                    $options = array();
                                                    $options['value'] = $employee['Employee']['house_no'];
                                                    $this->ExtForm->input('house_no', $options);
                                                ?>,
                                                <?php
                                                    $options = array();
                                                    $options['value'] = $employee['Employee']['p_o_box'];
                                                    $this->ExtForm->input('p_o_box', $options);
                                                ?>
                                            ]
                                        }
                                    ]
                                }, 
                                <?php
                                    $this->ExtForm->create('User');
                                    $options = array('vtype' => 'email','anchor'=>'70%');
                                    $options['value'] = $employee['User']['email'];
                                    $this->ExtForm->input('email', $options);
                                ?>
                                ]
                            }, 
                            <?php
                                $this->ExtForm->create('Employee');
                                $options = array();
                                $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Marital Status', 'value' => 'Single');
                                $options['items'] = array('Single' => 'Single', 'Married' => 'Married','Divorced'=>'Divorced');
                                $options['value'] = $employee['Employee']['marital_status'];
                                $this->ExtForm->input('marital_status', $options);
                            ?> ,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '70%');
                                 $options['value'] = $employee['Employee']['spouse_name'];
                                $this->ExtForm->input('spouse_name', $options);
                            ?>,
                            {
                            xtype: 'fileuploadfield',
                            id: 'form-file',
                            emptyText: 'Select Image',
                            fieldLabel: 'New Photo',
                            name: 'data[Employee][photo]',
                            buttonText: '',
                            anchor:'50%',
                            buttonCfg: {
                                iconCls: 'upload-icon'
                            }}
                        ]
                    }, {
                        title:'Contact Person Info',
                        layout:'form',
                        defaultType: 'textfield',
                        id:'contact',
                        disabled: true,
                        items: [
                            <?php
                                $options = array();
                                 $options=array('anchor' => '70%','fieldLabel'=>'Full Name');
                                 $options['value'] = $employee['Employee']['contact_name'];
                                $this->ExtForm->input('contact_name', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Region','allowBlank'=>'true');
                                $options['items'] = $locations;
                                $options['value'] = $employee['Employee']['contact_region_id'];
                                $this->ExtForm->input('contact_region_id', $options);
                            ?>,
                               <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'City');
                                 $options['value'] = $employee['Employee']['contact_city'];
                                $this->ExtForm->input('contact_city', $options);
                            ?>,        
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Kebele');
                                 $options['value'] = $employee['Employee']['contact_kebele'];
                                $this->ExtForm->input('contact_kebele', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'House No');
                                 $options['value'] = $employee['Employee']['contact_house_no'];
                                $this->ExtForm->input('contact_house_no', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Residence Tel');
                                 $options['value'] = $employee['Employee']['contact_residence_tel'];
                                $this->ExtForm->input('contact_residence_tel', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Office Tel');
                                 $options['value'] = $employee['Employee']['contact_office_tel'];
                                $this->ExtForm->input('contact_office_tel', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Mobile');
                                 $options['value'] = $employee['Employee']['contact_mobile'];
                                $this->ExtForm->input('contact_mobile', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '70%','fieldLabel'=>'Email');
                                 $options['value'] = $employee['Employee']['contact_email'];
                                $this->ExtForm->input('contact_email', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'P.O.Box');
                                 $options['value'] = $employee['Employee']['contact_p_o_box'];
                                $this->ExtForm->input('contact_p_o_box', $options);
                            ?>
                        ]
                    }, {
                        title:'Employment Info',
                        layout:'form',
                        id:'employment',
                        defaultType: 'textfield',
                        disabled: true,
                        items: [
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Id Card Number');
                                 $options['value'] = $employee['Employee']['card'];
                                $this->ExtForm->input('card', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%');
                                 $options['value'] = $employee['Employee']['date_of_employment'];
                                $this->ExtForm->input('date_of_employment', $options);
                            ?>,
                            <?php
                                $options = array();
                                $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Terms of Employment', 'value' => 'Permanent');
                                $options['items'] = array('Permanent' => 'Permanent', 'Contract' => 'Contract');
                                $options['value'] = $employee['Employee']['terms_of_employment'];
                                $this->ExtForm->input('terms_of_employment', $options);
                            ?>,
                            <?php


                                $this->ExtForm->create('EmployeeDetail');
                                $options = array();
                                $options=array('anchor' => '50%');
                                $options['listeners'] = "{
                            scope: this,
                            'select': function(combo, record, index){
                                var position = Ext.getCmp('data[EmployeeDetail][position_id]');
                                position.setValue('');
                                position.store.removeAll();
                                position.store.reload({
                                    params: {
                                        grade_id : combo.getValue()
                                    }
                                });
                            }
                        }";
                                $options['items'] = $grades;
                                $options['value'] = $employee['EmployeeDetail'][0]['Grade']['id'];
                                $this->ExtForm->input('grade_id', $options);
                            ?>,
                            <?php
                                $options = array();
                                $options=array('anchor' => '50%');
                                $options['items'] = $steps;
                                $options['value'] = $employee['EmployeeDetail'][0]['Step']['id'];
                                $this->ExtForm->input('step_id', $options);
                            ?>,
                            {
                                xtype: 'combo',
                                emptyText: 'All',
                                id: 'data[EmployeeDetail][position_id]',
                                name: 'data[EmployeeDetail][position_id]',
                                store : store_positions,
                                displayField : 'name',
                                valueField : 'id',
                                anchor:'50%',
                                fieldLabel: '<span style="color:red;">*</span> Position',
                                mode: 'local',
                                disableKeyFilter : true,
                                allowBlank: false,
                                typeAhead: true,
                                emptyText: 'Select Position',
                                editable: false,
                                triggerAction: 'all',
                                value:'<?php echo  $employee['EmployeeDetail'][0]['Position']['name']; ?>'
                            },
                            <?php
                                $this->ExtForm->create('User');
                                $options = array();
                                $options=array('anchor' => '50%');
                                $options['items'] = $branches;
                                $options['value'] = $employee['User']['branch_id'];
                                $this->ExtForm->input('branch_id', $options);
                            ?>
                                
                        ]
                    }
                ]
            }
        });

        var activetab=1;
        var EmployeeEditWindow = new Ext.Window({
            title: '<?php __('Edit Employee'); ?>',
            width: 700,
            minWidth: 600,
            autoHeight: true,
            layout: 'fit',
            modal: true,
            resizable: true,
            plain:true,
            bodyStyle:'padding:5px;',
            buttonAlign:'right',
            items: EmployeeEditForm,
            tools: [{
                    id: 'refresh',
                    qtip: 'Reset',
                    handler: function () {
                        EmployeeEditForm.getForm().reset();
                    },
                    scope: this
                }, {
                    id: 'help',
                    qtip: 'Help',
                    handler: function () {
                        Ext.Msg.show({
                            title: 'Help',
                            buttons: Ext.MessageBox.OK,
                            msg: 'This form is used to Edit Employee Information.',
                            icon: Ext.MessageBox.INFO
                        });
                    }
                }, {
                    id: 'toggle',
                    qtip: 'Collapse / Expand',
                    handler: function () {
                        if(EmployeeEditWindow.collapsed)
                            EmployeeEditWindow.expand(true);
                        else
                            EmployeeEditWindow.collapse(true);
                    }
                }],
            buttons: [ {
                    text: '<?php __('Back'); ?>',
                    disabled: true,
                    id:'back',
                    handler: function(btn){
                        if(activetab==2){
                            Ext.getCmp('personal').enable();
                            Ext.getCmp('contact').disable();
                            Ext.getCmp('form_tabs').setActiveTab(Ext.getCmp('personal'));
                            Ext.getCmp('back').disable();
                            activetab=1;
                        }
                        if(activetab==3){
                            Ext.getCmp('contact').enable();
                            Ext.getCmp('employment').disable();
                            Ext.getCmp('form_tabs').setActiveTab(Ext.getCmp('contact'));
                            Ext.getCmp('next').setText('Next');
                            activetab=2;
                        }


                    }
                }, {
                    text: '<?php __('Next'); ?>',
                    id:'next',
                    handler: function(btn){
                        if(activetab==3){
                            
                            EmployeeEditForm.getForm().submit({
                                waitMsg: '<?php __('Submitting your data...'); ?>',
                                waitTitle: '<?php __('Wait Please...'); ?>',
                                success: function(f,a){
                                    Ext.Msg.show({
                                        title: '<?php __('Success'); ?>',
                                        buttons: Ext.MessageBox.OK,
                                        msg: a.result.msg,
                                        icon: Ext.MessageBox.INFO
                                    });
                                    EmployeeEditWindow.close();
        <?php if (isset($parent_id)) { ?>
                                        RefreshParentEmployeeData();
        <?php } else { ?>
                                        RefreshEmployeeData();
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
                        if(activetab==2){
                            Ext.getCmp('employment').enable();
                            Ext.getCmp('contact').disable();
                            Ext.getCmp('form_tabs').setActiveTab(Ext.getCmp('employment'));
                            Ext.getCmp('next').setText('Finish');
                            activetab=3;
                        }
                        if(activetab==1){
                            Ext.getCmp('back').enable();
                            Ext.getCmp('contact').enable();
                            Ext.getCmp('personal').disable();
                            Ext.getCmp('form_tabs').setActiveTab(Ext.getCmp('contact'));
                            activetab=2;
                        }
                    }
                },{
                    text: '<?php __('Cancel'); ?>',
                    handler: function(btn){
                        EmployeeEditWindow.close();
                    }
                }]
        });
