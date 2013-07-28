<?php

App::uses('BaseFbQueryComponent', 'Controller/Component');

class FbQueryComponent extends BaseFbQueryComponent {

	public $cache = true;
	protected $_maps = array(
	    'group' => array(
		'gid' => 'id',
		'creator' => 'admin_id',
		'icon' => 'icon_small',
		'icon68' => 'icon_big'
	    ),
	    'post' => array(
		'post_id' => 'id',
		'source_id' => 'group_id',
		'actor_id' => 'from_id',
		'target_id' => 'to_id',
		'like_info.like_count' => 'likes_count',
		'comment_info.comment_count' => 'comments_count',
		'created_time' => 'post_date'
	    ),
	);

	public function getGroups($limit =  25) {
		$fql['group'] = 'select gid, name, description, icon, icon68, creator, privacy from group where gid in(select gid from group_member where uid = me()) limit '  . $limit;
		$results = $this->fql($fql);
		return $results['group'];
	}

	public function getGroup($id, $limit = 25) {
		$fql['group'] = 'select gid, name, description, icon, icon68, creator, privacy from group where gid  = ' .  $id;
		$fql['post'] = 'select post_id, source_id, actor_id, target_id, message, like_info, comment_info, created_time from stream where source_id  = "' . $id . '" limit '  . $limit;
		$results = $this->fql($fql);
		$results['group'] = current($results['group']);
		return $results;
	}

	public function allowedToViewGroup($id) {
		$fql['privacy'] = 'select privacy from group where gid  = ' . $id;
		$fql['is_member'] = 'SELECT gid FROM group_member WHERE uid = me() and gid = ' . $id;

		$results = $this->fql($fql);
		$privacy = strtolower(@$results['privacy'][0]['privacy']);
		$is_member = (boolean) count($results['is_member']);

		$is_allowed = ($privacy == 'open' || $is_member);
		return $is_allowed;
	}

	public function groupExists($id) {
		$exists = false;
		$fql = 'select privacy from group where gid  = ' . $id;
		/*
		 * sometimes, and i really mean smetimes ( might be a bug i need to document ),
		 * when a bad group id is passed, the API returns an exception of type "unkown".
		 */
		try {
			$results = $this->fql($fql);
			$exists = (boolean) count($results);
		} catch (Exception $e) {
			$exists = false;
		}
		return $exists;
	}

	protected function _mapFields($results, $mapKey) {
		$mapKey = (is_array($mapKey)) ? $mapKey : $this->_maps[$mapKey];
		$data = array();
		foreach ($results as $row) {
			$row = Hash::flatten($row);
			foreach ($mapKey as $oldKey => $newKey) {
				if (isset($row[$oldKey])) {
					$row[$newKey] = $row[$oldKey];
					unset($row[$oldKey]);
				}
			}
			$data[] = $row;
		}
		return $data;

	}

	public function fql($fql, $access_code = null) {
		$access_code = ($access_code) ? $access_code : $this->_sdk->getAccessToken();
		//cachekey generated must be different than what the parent generates
		$cacheKey = $this->_cacheKey(array('mapped', $fql, $access_code));
		if ($this->cache && $results = Cache::read($cacheKey, 'fbService'))  {
			return $results;
		} else {
			$results = parent::fql($fql, $access_code);
			if (is_array($fql)) {
				foreach ($results as $resultType => $result) {
					if (array_key_exists($resultType, $this->_maps)) {
						$results[$resultType] = $this->_mapFields($result, $resultType);
					}
				}
			}
			Cache::write($cacheKey, $results, 'fbService');
			return $results;
		}
	}
}