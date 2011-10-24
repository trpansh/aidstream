<?php
class Form_Wep_EditDefaults extends App_Form
{
    public function edit($defaults = '', $account_id = '')
    {
        $form = array();
        $model = new Model_Wep();
        $currency = $model->getCodeArray('Currency',null,'1');
//        $selectedCurrency = $model->findIdByFieldData('Currency', $defaultFields['field_values']['currency'], '1');
//        print_r($selectedCurrency[0]);exit();
        $form['default_currency'] = new Zend_Form_Element_Select('default_currency');
        $form['default_currency']->setRequired()->setLabel('Default Currency')->addMultiOption('', 'Select anyone');
        $form['default_currency']->setValue($defaults['field_values']['currency'])
        ->setAttrib('class', 'form-select');
        foreach($currency as $key => $eachCurrency){
            $form['default_currency']->addMultiOption($key, $eachCurrency);
        }
        
        $language = $model->getCodeArray('Language',null,'1');
//        $selectedLanguage = $model->findIdByFieldData('Language', $defaultFields['field_values']['language'], '1');
        $form['default_language'] = new Zend_Form_Element_Select('default_language');
        $form['default_language']->setRequired()->setLabel('Default Language')->addMultiOption('', 'Select anyone');
        $form['default_language']->setValue($defaults['field_values']['language'])
        ->setAttrib('class', 'form-select');
        foreach($language as $key => $eachLanguage){
            $form['default_language']->addMultiOption($key, $eachLanguage);
        }
        
        $form['hierarchy'] = new Zend_Form_Element_Text('hierarchy');
        $form['hierarchy']->setLabel('Default Hierarchy')
                                ->setValue($defaults['field_values']['hierarchy']);
        
        
        $form['default_reporting_org'] = new Zend_Form_Element_Text('default_reporting_org');
        $form['default_reporting_org']->setLabel('Default Reporting Organisation Name')
                                ->setValue($defaults['field_values']['reporting_org'])
                                ->setRequired()->setAttrib('class', 'form-text');

        $form['reporting_org_ref'] = new Zend_Form_Element_Text('reporting_org_ref');
        $form['reporting_org_ref']->setLabel('Default Reporting Organisation Identifier')
                                    ->setValue($defaults['field_values']['reporting_org_ref'])
                                    ->setAttrib('width','20px')
                                    ->setAttrib('class', 'form-text');
                                    
        foreach($form as $item_name=>$element)
        {
            $form[$item_name]->setDecorators( array(
                        'ViewHelper',
                        'Errors',
                        'Label',
                        array('HtmlTag', array(
                                               'tag'        =>'<div>',
                                               'placement'  =>'APPEND',
                                               'class'      =>'help activity_defaults-'.$item_name
                                               )
                            ),
                        array(array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div','class'=>'clearfix form-element'))
                    )
            );
        }
        
        
        //@todo reCaptcha
        
                                
        $signup = new Zend_Form_Element_Submit('Save');
                                         $signup->setValue('save')->setAttrib('class', 'form-submit');
                 
        
        $button = new Zend_Form_Element_Button('button');
        $button->setLabel('Check All');
        $button->setAttrib('class', 'check-uncheck');
        
        $this->addElement($button);
                                
        $this->addElements($form);
        
        foreach($defaults['fields'] as $key=>$eachDefault){
            $default_fields[$key] =  ucwords(str_replace("_", " ", $key));
            if($eachDefault == '1'){
                $checked[] = $key;
            }
        }
        
        
        $this->addElement('multiCheckbox', 'default_fields', array(
                        'disableLoadDefaultDecorators' => true,
                        'separator'    => '&nbsp;',
                        'multiOptions' => $default_fields,
                        'value' => $checked,
                        'decorators'   => array(
                                    'ViewHelper',
                                    'Errors',
                                array('HtmlTag', array('tag' => 'p'))          
                        )
        ));
        $this->addDisplayGroup(array('default_currency', 'default_language', 'default_reporting_org', 'reporting_org_ref', 'hierarchy'), 'field2',array('legend'=>'Default Field Values'));
       
        $df = $this->addDisplayGroup(array('button', 'default_fields',), 'field3',array('legend'=>'Default Field Groups'));

        $this->addElement($signup);
        $this->setMethod('post');
    }
}