<?php
App::import('Vendor', 'Facebook', array('file' => 'facebook-php-sdk' . DS . 'src' . DS . 'facebook.php'));

/**
 * CakephpFacebook
 *
 * An exteded version of the Facebook Class using CakePHP standards
 *
 * @author amoreno
 */
class CakephpFacebook extends Facebook {
	/**
	 * Permissions
	 *
	 * @var array
	 */
	public $perms = array();

	public function __construct($config = array()) {
		if (Configure::check('Facebook')) {
			$config = array_merge(Configure::read('Facebook'), $config);
		}
		parent::__construct($config);
		if (!empty($config['perms'])) {
			$this->perms = $config['perms'];
		}
	}

	public function getLoginUrl($params = array()) {
		$params['scope'] = isset($params['scope']) ? $params['scope'] : $this->perms;
		return parent::getLoginUrl($params);
	}

	public function getState() {
		return $this->state;
	}

	public function getLogoutUrl($params = array()) {
		$return_url = (isset($params['return_url'])) ? Router::url($params['return_url'], true) : $this->getCurrentUrl();
		return $this->getUrl(
			'www', 'logout.php', array_merge(array(
			'next' => $return_url,
			'access_token' => $this->getUserAccessToken(),
			), $params)
		);
	}

	public function clearAllPersistentData() {
		parent::clearAllPersistentData();
	}
}

