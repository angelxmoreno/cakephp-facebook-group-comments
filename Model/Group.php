<?php

App::uses('AppModel', 'Model');

/**
 * Group Model
 *
 * @property User $Admin
 * @property Post $WallPost
 * @property User $GroupMember
 */
class Group extends AppModel {

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
	    'name' => array(
		'notempty' => array(
		    'rule' => array('notempty'),
		    //'message' => 'Your custom message here',
		    'allowEmpty' => false,
		    'required' => true,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	    'members_count' => array(
		'numeric' => array(
		    'rule' => array('numeric'),
		//'message' => 'Your custom message here',
		//'allowEmpty' => false,
		//'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	    'admin_id' => array(
		'numeric' => array(
		    'rule' => array('numeric'),
		//'message' => 'Your custom message here',
		//'allowEmpty' => false,
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
	    'Admin' => array(
		'className' => 'User',
		'foreignKey' => 'user_id',
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
	    'WallPost' => array(
		'className' => 'Post',
		'foreignKey' => 'group_id',
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

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
	    'GroupMember' => array(
		'className' => 'User',
		'joinTable' => 'groups_users',
		'foreignKey' => 'group_id',
		'associationForeignKey' => 'user_id',
		'unique' => 'keepExisting',
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'finderQuery' => '',
		'deleteQuery' => '',
		'insertQuery' => ''
	    )
	);

}
