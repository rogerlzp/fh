<?php

// Defining menu structure here
// the items that need to appear when user is logged in should have logged_in set as true
return array(

	'menu' => array(
		array(
			'label' => '发起活动',
			'route' => 'tricks.new',
			'active' => array('user/tricks/new'),
			// 'logged_in' => true
		),
		array(
					'label' => '用户管理',
					'route' => 'image.new_local',
					'active' => array('user/image/new'),
					// 'logged_in' => true
		),
		array(
					'label' => '订单管理',
					'route' => 'image.new_net',
					'active' => array('user/image/new_net'),
					// 'logged_in' => true
			),
		array(
			'label' => '图片',
			'route' => 'image.show',
			'active' => array('image*'),
				// 'logged_in' => true
		),
	),

	'browse' => array(
		array(
			'label' => '最新',
			'route' => 'browse.recent',
			'active' => array('/')
		),
		array(
			'label' => '最流行',
			'route' => 'browse.popular',
			'active' => array('popular')
		),
		array(
			'label' => '推荐',
			'route' => 'browse.comments',
			'active' => array('comments')
		),
	),

);
