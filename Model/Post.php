<?php

App::uses('AppModel', 'Model');

/**
 * Post Model
 *
 * @property Group $Group
 * @property User $Poster
 * @property User $Recipient
 * @property Post $ParentPost
 * @property Post $ChildPost
 */
class Post extends AppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
	    'id' => array(
		'numeric' => array(
		    'rule' => array('numeric'),
		    //'message' => 'Your custom message here',
		    'allowEmpty' => false,
		    'required' => true,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	    'group_id' => array(
		'numeric' => array(
		    'rule' => array('numeric'),
		    //'message' => 'Your custom message here',
		    'allowEmpty' => false,
		    'required' => true,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	    'from_id' => array(
		'numeric' => array(
		    'rule' => array('numeric'),
		    //'message' => 'Your custom message here',
		    'allowEmpty' => false,
		    'required' => true,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	    'to_id' => array(
		'numeric' => array(
		    'rule' => array('numeric'),
		    //'message' => 'Your custom message here',
		    'allowEmpty' => true,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	    'likes_count' => array(
		'numeric' => array(
		    'rule' => array('numeric'),
		    //'message' => 'Your custom message here',
		    'allowEmpty' => true,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	    'comments_count' => array(
		'numeric' => array(
		    'rule' => array('numeric'),
		    //'message' => 'Your custom message here',
		    'allowEmpty' => true,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
	    'Group' => array(
		'className' => 'Group',
		'foreignKey' => 'group_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
	    ),
	    'Poster' => array(
		'className' => 'User',
		'foreignKey' => 'from_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
	    ),
	    'Recipient' => array(
		'className' => 'User',
		'foreignKey' => 'to_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
	    ),
	    'ParentPost' => array(
		'className' => 'Post',
		'foreignKey' => 'parent_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
	    )
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
	    'ChildPost' => array(
		'className' => 'Post',
		'foreignKey' => 'parent_id',
		'dependent' => false,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'exclusive' => '',
		'finderQuery' => '',
		'counterQuery' => ''
	    )
	);

}
