<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	/**
	 * beforeFilter callback
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('logout');
	}

	/**
	 * login method
	 *
	 * @return void
	 */
	public function login() {
		if ($this->Auth->loggedIn()) {
			$this->_sessionError('You are already logged in. ');
			$this->redirect($this->Auth->redirectUrl());
		}
		$this->set('auth_url', $this->facebookSdk->getLoginUrl());
	}

	/**
	 * logout method
	 *
	 * @return void
	 */
	public function logout() {
		if (!$this->Auth->loggedIn()) {
			$this->_sessionError('You are not logged in yet. Please log in.');
			$this->redirect($this->Auth->loginAction);
		}
		$return_url = $this->Auth->logout();
		$return_url = $this->facebookSdk->getLogoutUrl(array('return_url' => $return_url));
		$this->facebookSdk->clearAllPersistentData();
		$this->redirect($return_url);
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid %s', __('user')));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid %s', __('user')));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('user')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('user')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-error'
					)
				);
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	/**
	 * admin_edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid %s', __('user')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('user')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('user')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	/**
	 * admin_delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid %s', __('user')));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('user')), 'alert', array(
			    'plugin' => 'TwitterBootstrap',
			    'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('user')), 'alert', array(
		    'plugin' => 'TwitterBootstrap',
		    'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}

}
