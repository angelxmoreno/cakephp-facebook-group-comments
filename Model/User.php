<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Group $OwnedGroup
 * @property Post $WallPost
 * @property Group $Group
 */
class User extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

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
		'allowEmpty' => true,
		'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	    'pic_url' => array(
		'url' => array(
		    'rule' => array('url'),
		//'message' => 'Your custom message here',
		'allowEmpty' => true,
		'required' => false,
		//'last' => false, // Stop validation after this rule
		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	    ),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
	    'OwnedGroup' => array(
		'className' => 'Group',
		'foreignKey' => 'admin_id',
		'dependent' => false,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'exclusive' => '',
		'finderQuery' => '',
		'counterQuery' => ''
	    ),
	    'WallPost' => array(
		'className' => 'Post',
		'foreignKey' => 'from_id',
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
	    'Group' => array(
		'className' => 'Group',
		'joinTable' => 'groups_users',
		'foreignKey' => 'user_id',
		'associationForeignKey' => 'group_id',
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
