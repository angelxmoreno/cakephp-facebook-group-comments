<?php

App::uses('CakephpFacebook', 'Lib');

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 *
 * @property AuthComponent $Auth
 * @property SessionComponent $Session
 * @property CakephpFacebook $facebookSdk
 */
class AppController extends Controller {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array(
	    //'DebugKit.Toolbar',
	    'Auth' => array(
		'loginAction' => array(
		    'admin' => false,
		    'plugin' => null,
		    'controller' => 'users',
		    'action' => 'login',
		),
		'logoutRedirect' => array(
		    'admin' => false,
		    'plugin' => null,
		    'controller' => 'users',
		    'action' => 'login',
		),
		'loginRedirect' => '/',
		'authError' => 'You need to authorize our app before you can continue',
	    ),
	    'Session'
	);

	/**
	 * Helpers
	 *
	 * @var array
	 */
	public $helpers = array(
	    'Session',
	    'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
	    'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
	    'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
	    'FacebookCanvas'
	);

	/**
	 * App Layout
	 *
	 * @var string
	 */
	public $layout = 'bootstrap';

	/**
	 * Layout Nav Links
	 * @var array
	 */
	public $navLinks = array(
	    'Home' => array(
		'url' => '/'
	    ),
	    'Groups' => array(
		'url' => array('admin' => false, 'plugin' => null, 'controller' => 'groups', 'action' => 'index'),
	    ),
	    'Log Out' => array(
		'url' => array('admin' => false, 'plugin' => null, 'controller' => 'users', 'action' => 'logout'),
		'auth' => true,
	    ),
	    'Log In' => array(
		'url' => array('admin' => false, 'plugin' => null, 'controller' => 'users', 'action' => 'login'),
		'auth' => false,
	    )
	);

	/**
	 * An array containing the class names of models this controller uses.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 */
	public $uses = array('User');

	/**
	 * beforeFilter callback
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->facebookSdk = new CakephpFacebook();
		$this->_facebookSdkCheck();
		$this->Auth->allow('display');
		$this->set('navLinks', $this->navLinks);
	}

	protected function _facebookSdkCheck() {
		if (!$this->Auth->loggedIn()) {
			$uid = $this->facebookSdk->getUser();
			$fbUser = false;
			if ($uid) {
				try {
					$fbUser = $this->facebookSdk->api('/me');
				} catch (FacebookApiException $e) {
					$fbUser = false;
				}
			}
			if ($fbUser) {
				$fbUser['access_token'] = $this->facebookSdk->getAccessToken();
				$this->User->save($fbUser);
				$this->User->recursive = 0;
				$user = $this->User->read(null, $fbUser['id']);
				$this->Auth->login($user['User']);
				$this->redirect($this->Auth->redirectUrl());
			} else {
				if(@$this->request->query['error_message'] && $this->request->query['state'] == $this->facebookSdk->getState())  {
					$this->_sessionError($this->request->query['error_message']);
				}
				if (@$this->request->query['error_description'] && $this->request->query['state'] == $this->facebookSdk->getState()) {
					$this->_sessionError($this->request->query['error_description']);
				}
			}
		}
	}

	protected function _sessionError($msg) {
		$this->Session->setFlash($msg, 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-error'));
	}

	protected function _sessionInfo($msg) {
		$this->Session->setFlash($msg, 'alert', array('plugin' => 'TwitterBootstrap', 'class' => 'alert-info'));
	}

}
