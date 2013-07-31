<?php

App::uses('AppController', 'Controller');

/**
 * Groups Controller
 *
 * @property Group $Group
 */
class GroupsController extends AppController {
	public $components = array('FbQuery');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$groups = $this->FbQuery->getGroups();
		$this->Group->saveMany($groups);
		$this->set('groups', $groups);
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($group_id = null) {
		if (!$this->FbQuery->groupExists($group_id)) {
			$this->_sessionError('The group id passed is invalid!');
			$this->redirect(array('action' => 'index'));
		}
		$allowedToView = $this->FbQuery->allowedToViewGroup($group_id);
		$group = $this->FbQuery->getGroup($group_id);
		$this->Group->save($group);
		$Group = array('Group' => $group, 'WallPost' => array());
		$postsData = $this->FbQuery->getGroupPostsBypage($group_id, $page = 1, $limit = 25);
		$posts = $postsData['data'];
		$this->Group->WallPost->saveMany($posts);
		$users = $postsData['users'];
		$this->Group->Admin->saveMany($users);
		if (!$allowedToView) {
			$this->_sessionInfo('You are not a member of this non-public group! Please join the group to see its posts');
		} else {
			$Group['WallPost'] = $posts;
		}
		$this->set('group', $Group);
	}

	public function group_posts_page($group_id, $page = 1) {
		$this->autoRender = false;
		$allowedToView = $this->FbQuery->allowedToViewGroup($group_id);
		$posts = array();
		if (!$allowedToView) {
			$this->_sessionInfo('You are not a member of this non-public group! Please join the group to see its posts');
		} else {
			$results = $this->FbQuery->getGroupPostsBypage($group_id, $page);
			$posts = $results['data'];
			$this->Group->WallPost->saveMany($posts);
		}
		//$this->set('posts', $posts);
		echo json_encode($posts);
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->Group->recursive = 0;
		$this->set('groups', $this->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid %s', __('group')));
		}
		$this->set('group', $this->Group->read(null, $id));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('group')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('group')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-error'
					)
				);
			}
		}
		$admins = $this->Group->Admin->find('list');
		$groupMembers = $this->Group->GroupMember->find('list');
		$this->set(compact('admins', 'groupMembers'));
	}

	/**
	 * admin_edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid %s', __('group')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('group')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('group')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->Group->read(null, $id);
		}
		$admins = $this->Group->Admin->find('list');
		$groupMembers = $this->Group->GroupMember->find('list');
		$this->set(compact('admins', 'groupMembers'));
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Invalid %s', __('group')));
		}
		if ($this->Group->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('group')), 'alert', array(
			    'plugin' => 'TwitterBootstrap',
			    'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('group')), 'alert', array(
		    'plugin' => 'TwitterBootstrap',
		    'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}

}
