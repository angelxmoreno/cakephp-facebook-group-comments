<?php

App::uses('AppController', 'Controller');

/**
 * Posts Controller
 *
 * @property Post $Post
 */
class PostsController extends AppController {

	public $components = array('FbQuery');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Post->recursive = 0;
		$this->set('posts', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($post_id = null) {
		$this->Post->id = $post_id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid %s', __('post')));
		}
		$group_id = $this->Post->field('group_id');
		$results = $this->FbQuery->getGroupPostComments($group_id, $post_id, $limit = 500);
		foreach ($results['comment'] as $key => $comment) {
			$results['comment'][$key]['group_id'] = $group_id;
			$results['comment'][$key]['created_at'] = date('Y-m-d H:i:s', $comment['created_at']);
			$data[] = $results['comment'][$key];
		}
		$data[] = current($results['post']);
		$this->Post->saveMany($data);
		$post = $this->Post->read(null, $post_id);
		$this->set('post', $post);
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->Post->recursive = 0;
		$this->set('posts', $this->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid %s', __('post')));
		}
		$this->set('post', $this->Post->read(null, $id));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('post')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('post')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-error'
					)
				);
			}
		}
		$groups = $this->Post->Group->find('list');
		$posters = $this->Post->Poster->find('list');
		$recipients = $this->Post->Recipient->find('list');
		$parentPosts = $this->Post->ParentPost->find('list');
		$this->set(compact('groups', 'posters', 'recipients', 'parentPosts'));
	}

	/**
	 * admin_edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid %s', __('post')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(
					__('The %s has been saved', __('post')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-success'
					)
				);
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(
					__('The %s could not be saved. Please, try again.', __('post')), 'alert', array(
				    'plugin' => 'TwitterBootstrap',
				    'class' => 'alert-error'
					)
				);
			}
		} else {
			$this->request->data = $this->Post->read(null, $id);
		}
		$groups = $this->Post->Group->find('list');
		$posters = $this->Post->Poster->find('list');
		$recipients = $this->Post->Recipient->find('list');
		$parentPosts = $this->Post->ParentPost->find('list');
		$this->set(compact('groups', 'posters', 'recipients', 'parentPosts'));
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
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid %s', __('post')));
		}
		if ($this->Post->delete()) {
			$this->Session->setFlash(
				__('The %s deleted', __('post')), 'alert', array(
			    'plugin' => 'TwitterBootstrap',
			    'class' => 'alert-success'
				)
			);
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(
			__('The %s was not deleted', __('post')), 'alert', array(
		    'plugin' => 'TwitterBootstrap',
		    'class' => 'alert-error'
			)
		);
		$this->redirect(array('action' => 'index'));
	}

}
