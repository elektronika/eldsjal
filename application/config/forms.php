<?php
$config = array(
	'topic' => array(
		array(
			'field' => 'title',
			'label' => 'Rubrik',
			'type' => 'text',
			'object' => 'topic'
		),
		array(
			'field' => 'body',
			'label' => 'Inlägg',
			'type' => 'textarea',
			'object' => 'post'
		),
		array(
			'field' => 'is_event',
			'label' => 'Visa i kalendern',
			'type' => 'checkbox',
			'object' => 'topic'
		),
		array(
			'field' => 'date_start',
			'label' => 'Startdatum',
			'type' => 'datepicker',
			'object' => 'topic'
		),
		array(
			'field' => 'date_end',
			'label' => 'Slutdatum',
			'type' => 'datepicker',
			'object' => 'topic'
		),
		array(
			'field' => 'location_id',
			'label' => 'Plats/område',
			'type' => 'dropdown',
			'values' => function() {
				return get_instance()->models->location->get_all_assoc();
			},
			'object' => 'topic'
		)
	),
	'thought' => array(
		array(
			'field' => 'title',
			'label' => 'Rubrik',
			'type' => 'text',
			'rules' => 'trim|xss_clean|required'
		),
		array(
			'field' => 'body',
			'label' => 'Din tanke',
			'type' => 'textarea',
			'rules' => 'trim|xss_clean|required'
		)
	)
);

$config['topic_admin'] = array_merge($config['topic'], array(
	array(
		'field' => 'sticky',
		'label' => 'Klistrad',
		'type' => 'checkbox',
		'object' => 'topic'
	),
	array(
		'field' => 'locked',
		'label' => 'Låst',
		'type' => 'checkbox',
		'object' => 'topic'
	)
));