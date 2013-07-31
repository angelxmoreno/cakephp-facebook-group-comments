<?php

App::uses('BaseFbQueryComponent', 'Controller/Component');

class FbQueryComponent extends BaseFbQueryComponent {
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
	    'comment' => array(
		'post_id' => 'parent_id',
		'fromid' => 'from_id',
		'text' => 'message',
		'likes' => 'likes_count',
		'comment_count' => 'comments_count',
		'time' => 'created_at'
	    ),
	);
	protected $_fqls = array(
	    'members_groups' => 'select gid, name, description, icon, icon68, creator, privacy from group where gid in(SELECT gid FROM group_member WHERE uid = %s)',
	    'group' => 'select gid, name, description, icon, icon68, creator, privacy from group where gid  = "%s"',
	    'group_posts' => 'select post_id, source_id, actor_id, target_id, message, like_info, comment_info, created_time from stream where type = 308 and source_id  = "%s" ORDER BY created_time DESC limit %u offset %u',
	    'post' => 'select post_id, source_id, actor_id, target_id, message, like_info, comment_info, created_time from stream where post_id = "%s"',
	    'is_group_member' => 'SELECT gid FROM group_member WHERE uid = me() and gid = "%s"',
	    'post_comment' => 'SELECT id, post_id,fromid, text, likes, comment_count, time FROM comment WHERE post_id = "%s" ORDER BY time ASC limit %u'
	);
	protected $_graphs = array(
	    'group_posts' => '%s/feed/?fields=id,from,to,message,created_time,updated_time,type,picture,full_picture,link&limit=%u',
	//'post_comments' => '%s?fields=comments.limit(%u).fields(comment_count,created_time,from,id,like_count,message,parent,attachment)'
	);

	public function getGroups($user_id = 'me()', $limit = 50) {
		$fql['group'] = sprintf($this->_fqls['members_groups'], $user_id, $limit);
		$results = $this->fql($fql);
		return $results['group'];
	}

	public function getGroup($group_id, $limit = 50) {
		$fql['group'] =  sprintf($this->_fqls['group'], $group_id);
		$results = $this->fql($fql);
		$results = current($results['group']);
		return $results;
	}

	public function getGroupPostsBypage($group_id, $page = 1, $limit = 10) {
		$graph = sprintf($this->_graphs['group_posts'], $group_id, $limit);
		$results[1] = $this->graph($graph);
		if ($page > 1) {
			for ($current_page = 2; $current_page <= $page; $current_page++) {
				$graph = $results[$current_page - 1]['paging']['next'];
				$results[$current_page] = $this->graph($graph);
			}
		}
		$postsData = $results[$page];
		$post_ids = Hash::extract($postsData['data'], '{n}.id');
		$postsData['data'] = array_combine($post_ids, $postsData['data']);
		$fql = 'select post_id, comment_info, likes from stream where post_id in("' . implode('","', $post_ids) . '")';
		$postsMeta = $this->fql($fql);
		$users = array();
		foreach ($postsMeta as $postMeta) {
			$postsData['data'][$postMeta['post_id']]['comments_count'] = $postMeta['comment_info']['comment_count'];
			$postsData['data'][$postMeta['post_id']]['likes_count'] = $postMeta['likes']['count'];

			$postsData['data'][$postMeta['post_id']]['created_at'] = date('Y-m-d H:i:s', strtotime($postsData['data'][$postMeta['post_id']]['created_time']));
			$postsData['data'][$postMeta['post_id']]['updated_at'] = date('Y-m-d H:i:s', strtotime($postsData['data'][$postMeta['post_id']]['updated_time']));

			$postsData['data'][$postMeta['post_id']]['group_id'] = $group_id;
			$postsData['data'][$postMeta['post_id']]['to_id'] = $postsData['data'][$postMeta['post_id']]['to_data_0_id'];
			//$postsData['data'][$postMeta['post_id']]['from_id'] = $postsData['data'][$postMeta['post_id']]['from_id'];
			$user_id = $postsData['data'][$postMeta['post_id']]['from_id'];
			$user_name = $postsData['data'][$postMeta['post_id']]['from_name'];;
			$users[$user_id  . '_'] = array('id' => $user_id, 'name' => $user_name);
		}
		$postsData['users'] = array_values($users);
		return $postsData;
	}

	public function getPostComments($post_id, $limit = 500) {
		$fql['comment'] = sprintf($this->_fqls['post_comment'], $post_id, $limit);
		$results = $this->fql($fql);
		return $results;
	}

	public function getGroupPostComments($group_id, $post_id, $limit = 500) {
		$fql['group'] = sprintf($this->_fqls['group'], $group_id);
		$fql['post'] = sprintf($this->_fqls['post'], $post_id);
		$fql['comment'] = sprintf($this->_fqls['post_comment'], $post_id, $limit);

		$results = $this->fql($fql);
		return $results;
	}

	public function allowedToViewGroup($group_id) {
		$fql['privacy'] = 'select privacy from group where gid  = ' . $group_id;
		$fql['is_member'] =  sprintf($this->_fqls['group_posts'], $group_id, 1, 0);
		//'SELECT gid FROM group_member WHERE uid = me() and gid = ' . $id;

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

	protected function _buildQuery($type, $params = array()) {

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

	public function graph($path, $access_code = null) {
		$results = parent::graph($path, $access_code);
		foreach ($results['data'] as $key => $row) {
			$results['data'][$key] = Hash::flatten($row, '_');
		}
		$results['paging']['previous'] = @str_replace('https://graph.facebook.com', '', $results['paging']['previous']);
		$results['paging']['next'] = @str_replace('https://graph.facebook.com', '', $results['paging']['next']);
		return $results;
	}
}