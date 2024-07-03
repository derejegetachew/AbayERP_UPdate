﻿
    <?php
    $this->ExtForm->create('Employee');
    $this->ExtForm->defineFieldFunctions();
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
        var EmployeeAddForm = new Ext.form.FormPanel({
            baseCls: 'x-plain',
            labelWidth: 150,
            labelAlign: 'right',
            url:'<?php echo $this->Html->url(array('controller' => 'employees', 'action' => 'add')); ?>',
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
                                fieldLabel: '<span style="color:red;">*</span> Full Name',
                                items:[
                                    <?php
                                        $this->ExtForm->create('Person');
                                        $options = array();
                                        $this->ExtForm->input('first_name', $options);
                                    ?>,
                                    <?php
                                        $options = array();
                                        $this->ExtForm->input('middle_name', $options);
                                    ?>,
                                    <?php
                                        $options = array();
                                        $this->ExtForm->input('last_name', $options);
                                    ?>
                                ]
                            },{ 
                                xtype: 'compositefield',
                                labelWidth: 120,
                                fieldLabel: 'ሙሉ ስም',
                                items:[
                                    <?php
                                        $options = array(
                                            'enableKeyEvents' => 'true',
                                            'anchor' => '99%');
                                        $options['listeners'] = '{
                                            keypress: function(tb,e){
                                                translateOnKeyPress(e,1);
                                            }
                                        }';
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
                                        $this->ExtForm->input('last_name_am', $options);
                                    ?>
                                ]
                            },


                            <?php
                                $this->ExtForm->create('Employee');
                                $options = array();
                                $options=array('anchor' => '70%');
                                $this->ExtForm->input('mother_name', $options);
                            ?>,
                            <?php
                                $this->ExtForm->create('Person');
                                $options = array();
                                $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Sex', 'value' => 'F');
                                $options['items'] = array('M' => 'Male', 'F' => 'Female');
                                $this->ExtForm->input('sex', $options);
                            ?>,
                            <?php
                                $options = array();
                                $options=array('anchor' => '50%','allowBlank'=>'false');
                                $this->ExtForm->input('birthdate', $options);
                            ?>,
                            <?php
                                $options = array();
                                $options=array('anchor' => '50%');
                                $options['items'] = $locations;
                                $this->ExtForm->input('birth_loc_id', $options);
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
                                                    $this->ExtForm->input('emp_loc_id', $options);
                                                ?>,
                                                <?php
                                                    $options = array();
                                                    $this->ExtForm->input('kebele', $options);
                                                ?>, 
                                                <?php
                                                    $options = array();
                                                    $this->ExtForm->input('telephone', $options);
                                                ?>
                                            ]
                                        }, {
                                            columnWidth:.5,
                                            layout: 'form',
                                            items:[ 
                                                    <?php
                                                    $options = array();
                                                    $this->ExtForm->input('city', $options);
                                                ?>,
                                                <?php
                                                    $options = array();
                                                    $this->ExtForm->input('house_no', $options);
                                                ?>,
                                                <?php
                                                    $options = array();
                                                    $this->ExtForm->input('p_o_box', $options);
                                                ?>
                                            ]
                                        }
                                    ]
                                }, 
                                <?php
                                    $this->ExtForm->create('User');
                                    $options = array('vtype' => 'email','anchor'=>'70%');
                                    $this->ExtForm->input('email', $options);
                                ?>
                                ]
                            }, 
                            <?php
                                $this->ExtForm->create('Employee');
                                $options = array();
                                $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Marital Status', 'value' => 'Single');
                                $options['items'] = array('Single' => 'Single', 'Married' => 'Married','Divorced'=>'Divorced');
                                $this->ExtForm->input('marital_status', $options);
                            ?> ,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '70%');
                                $this->ExtForm->input('spouse_name', $options);
                            ?>,
                            {
                            xtype: 'fileuploadfield',
                            id: 'form-file',
                            emptyText: 'Select Image',
                            fieldLabel: 'Photo',
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
                                $this->ExtForm->input('contact_name', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Region');
                                $options['items'] = $locations;
                                $this->ExtForm->input('contact_region_id', $options);
                            ?>,
                                                               
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'City');
                                $this->ExtForm->input('contact_city', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Kebele');
                                $this->ExtForm->input('contact_kebele', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'House No');
                                $this->ExtForm->input('contact_house_no', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Residence Tel');
                                $this->ExtForm->input('contact_residence_tel', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Office Tel');
                                $this->ExtForm->input('contact_office_tel', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'Mobile');
                                $this->ExtForm->input('contact_mobile', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '70%','fieldLabel'=>'Email');
                                $this->ExtForm->input('contact_email', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%','fieldLabel'=>'P.O.Box');
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
                                $this->ExtForm->input('card', $options);
                            ?>,
                            <?php
                                $options = array();
                                 $options=array('anchor' => '50%');
                                $this->ExtForm->input('date_of_employment', $options);
                            ?>,
                            <?php
                                $options = array();
                                $options = array('xtype' => 'combo', 'anchor' => '50%', 'fieldLabel' => 'Terms of Employment', 'value' => 'Permanent');
                                $options['items'] = array('Permanent' => 'Permanent', 'Contract' => 'Contract');
                                
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
                                $this->ExtForm->input('grade_id', $options);
                            ?>,
                            <?php
                                $options = array();
                                $options=array('anchor' => '50%');
                                $options['items'] = $steps;
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
                                triggerAction: 'all'
                            },
                            <?php
                                $this->ExtForm->create('User');
                                $options = array();
                                $options=array('anchor' => '50%');
                                $options['items'] = $branches;
                                $this->ExtForm->input('branch_id', $options);
                            ?>
                                
                        ]
                    }
                ]
            }
        });

        var activetab=1;
        var EmployeeAddWindow = new Ext.Window({
            title: '<?php __('Register Employee'); ?>',
            width: 700,
            minWidth: 600,
            autoHeight: true,
            layout: 'fit',
            modal: true,
            resizable: true,
            plain:true,
            bodyStyle:'padding:5px;',
            buttonAlign:'right',
            items: EmployeeAddForm,
            tools: [{
                    id: 'refresh',
                    qtip: 'Reset',
                    handler: function () {
                        EmployeeAddForm.getForm().reset();
                    },
                    scope: this
                }, {
                    id: 'help',
                    qtip: 'Help',
                    handler: function () {
                        Ext.Msg.show({
                            title: 'Help',
                            buttons: Ext.MessageBox.OK,
                            msg: 'This form is used to insert a new Employee.',
                            icon: Ext.MessageBox.INFO
                        });
                    }
                }, {
                    id: 'toggle',
                    qtip: 'Collapse / Expand',
                    handler: function () {
                        if(EmployeeAddWindow.collapsed)
                            EmployeeAddWindow.expand(true);
                        else
                            EmployeeAddWindow.collapse(true);
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
                            EmployeeAddForm.getForm().submit({
                                waitMsg: '<?php __('Submitting your data...'); ?>',
                                waitTitle: '<?php __('Wait Please...'); ?>',
                                success: function(f,a){
                                    Ext.Msg.show({
                                        title: '<?php __('Success'); ?>',
                                        buttons: Ext.MessageBox.OK,
                                        msg: a.result.msg,
                                        icon: Ext.MessageBox.INFO
                                    });
                                    EmployeeAddWindow.close();
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
                        EmployeeAddWindow.close();
                    }
                }]
        });