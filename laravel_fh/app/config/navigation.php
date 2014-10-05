<?php

// Defining menu structure here
// the items that need to appear when user is logged in should have logged_in set as true
return array(

	'menu' => array(
		array(
					'label' => '首页',
					'route' => 'home.index',
					'active' => array('home*')
			),
		array(
			'label' => '活动',
			'route' => 'browse.recent',
			'active' => array('/','popular','comments')
		),
		array(
			'label' => '分类',
			'route' => 'browse.categories',
			'active' => array('categories*')
		),
		array(
			'label' => '标签',
			'route' => 'browse.tags',
			'active' => array('tags*')
		),
		array(
				'label' => '专栏',
				'route' => 'product.show',
				'active' => array('product*'),
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

	),

);
