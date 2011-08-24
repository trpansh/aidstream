<?php

require_once 'PHPUnit/Framework/TestCase.php';

class WepControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }
    
    public function appBootstrap()
    {
        $this->_application = new Zend_Application(APPLICATION_ENV,
              APPLICATION_PATH . '/configs/application.ini'
        );
        $this->_application->bootstrap();
        
        /**
         * Fix for ZF-8193
         * http://framework.zend.com/issues/browse/ZF-8193
         * Zend_Controller_Action->getInvokeArg('bootstrap') doesn't work
         * under the unit testing environment.
         */
        $front = Zend_Controller_Front::getInstance();
        if($front->getParam('bootstrap') === null) {
            $front->setParam('bootstrap', $this->_application->getBootstrap());
        }
    }
    

    public function tearDown()
    {
        /* Tear Down Routine */
    }
    
    public function testDashboard()
    {
//        $this->resetRequest();
//        $this->resetResponse();
        $this->request
             ->setMethod('POST')
             ->setPost(array(
                 'username' => 'unicef_admin',
                 'password' => 'admin'
             ));
        $this->dispatch('/user/user/login');
        
        $this->assertRedirectTo('/wep/dashboard');
        $this->assertController("user");
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        $this->resetRequest();
        $this->resetResponse();
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        
        /*
        $this->dispatch('/wep/dashboard');
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        $this->assertController('wep');*/
        
        
    }
    
}