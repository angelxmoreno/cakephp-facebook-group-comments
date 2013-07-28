<?php

App::uses('Component', 'Controller');

class BaseFbQueryComponent extends Component {
	/**
	 * sdk
	 *
	 * CakephpFacebook class to relay calls to
	 *
	 * @var CakephpFacebook
	 */
	protected $_sdk = null;

	/**
	 * Wheter to cache the calls made out to the Facebook Servers
	 *
	 * @var boolean
	 */
	public $cache = false;

	/**
	 * Called after the Controller::beforeFilter() and before the controller action
	 *
	 * @param Controller $controller Controller with components to startup
	 * @return void
	 */
	public function startup(Controller $controller) {
		$this->_sdk = $controller->facebookSdk;
	}

	public function fql($fql, $access_code = null) {
		$results = false;
		$access_code = ($access_code) ? $access_code : $this->_sdk->getAccessToken();
		$cacheKey = $this->_cacheKey(array('fql' => $fql, 'access_code' => $access_code));
		if ($this->cache) {
			$results = Cache::read($cacheKey, 'fbService');
		}
		if (!$results) {
			$method = (is_array($fql)) ? 'fql.multiquery' : 'fql.query';
			$queryType = (is_array($fql)) ? 'queries' : 'query';
			$params = array(
			    'method' => $method,
			    $queryType => $fql,
			    'access_token' => $access_code
			);

			try {
				$results = $this->_sdk->api($params);
			} catch (Exception $e) {
				throw new CakeException('Facebook Service Error: ' . $e->getMessage());
			}
			$results = (is_array($fql)) ? Hash::combine($results, '{n}.name', '{n}.fql_result_set') : $results;
			Cache::write($cacheKey, $results, 'fbService');
		}

		return $results;
	}

	protected function _cacheKey($params) {
		return md5(serialize($params));
	}

}

$defaultCache = Cache::config('default');
Cache::config('fbService', array_merge($defaultCache['settings'], array(
	'duration' => '+5 minutes',
	'prefix' => 'fbService_',
)));