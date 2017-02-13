<?php 

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_extra-velden-voor-berichten',
		'title' => 'Extra velden voor berichten',
		'fields' => array (
			array (
				'key' => 'field_54aea101ea4fb',
				'label' => 'Sectie',
				'name' => 'sectie',
				'type' => 'flexible_content',
				'layouts' => array (
					array (
						'label' => 'Paragraaf',
						'name' => 'paragraaf',
						'display' => 'row',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_54aea30fbfc96',
								'label' => 'Paragraaf',
								'name' => 'paragraaf',
								'type' => 'wysiwyg',
								'column_width' => '',
								'default_value' => '',
								'toolbar' => 'full',
								'media_upload' => 'yes',
							),
						),
					),
					array (
						'label' => 'Quote',
						'name' => 'quote',
						'display' => 'row',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_53afa30fbfc96',
								'label' => 'Text',
								'name' => 'text',
								'type' => 'textarea',
								'column_width' => '',
								'default_value' => '',
								'toolbar' => 'full',
								'media_upload' => 'yes',
							),
							array (
								'key' => 'field_51afb30fbfc96',
								'label' => 'Auteur',
								'name' => 'auteur',
								'type' => 'text',
								'column_width' => '',
								'default_value' => '',
								'toolbar' => 'full',
								'media_upload' => 'yes',
							),
						),
					),
					array (
						'label' => 'Foto links',
						'name' => 'foto_links',
						'display' => 'table',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_54aec9c981e12',
								'label' => 'Afbeelding',
								'name' => 'afbeelding',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'object',
								'preview_size' => 'large',
								'library' => 'all',
							),
						),
					),
					array (
						'label' => 'Ongelijke foto combi (klein rechts)',
						'name' => 'foto_combi',
						'display' => 'table',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_54be4abdd4e10',
								'label' => 'Afbeelding1',
								'name' => 'afbeelding1',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'object',
								'preview_size' => 'large',
								'library' => 'all',
							),
							array (
								'key' => 'field_54be4ad1d4e12',
								'label' => 'Afbeelding2',
								'name' => 'afbeelding2',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'object',
								'preview_size' => 'klein',
								'library' => 'all',
							),
						),
					),
					array (
						'label' => 'Ongelijke foto combi (klein links)',
						'name' => 'foto_combi_2',
						'display' => 'table',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_54e1fc8f3141a',
								'label' => 'Afbeelding2',
								'name' => 'afbeelding2',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'object',
								'preview_size' => 'klein',
								'library' => 'all',
							),
							array (
								'key' => 'field_54e1fc8f31419',
								'label' => 'Afbeelding1',
								'name' => 'afbeelding1',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'object',
								'preview_size' => 'large',
								'library' => 'all',
							),
						),
					),
					array (
						'label' => 'Gelijke foto combi',
						'name' => 'foto_combi_3',
						'display' => 'table',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_561b8b60c654e',
								'label' => 'Afbeelding1',
								'name' => 'afbeelding1',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'object',
								'preview_size' => 'medium',
								'library' => 'all',
							),
							array (
								'key' => 'field_561b8b60c654d',
								'label' => 'Afbeelding2',
								'name' => 'afbeelding2',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'object',
								'preview_size' => 'medium',
								'library' => 'all',
							),
						),
					),
					array (
						'label' => 'Foto rechts',
						'name' => 'foto_rechts',
						'display' => 'table',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_54aee6d6c1253',
								'label' => 'Afbeelding',
								'name' => 'afbeelding',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'object',
								'preview_size' => 'large',
								'library' => 'all',
							),
						),
					),
					array (
						'label' => 'Grote foto',
						'name' => 'grote_foto',
						'display' => 'row',
						'min' => '',
						'max' => '',
						'sub_fields' => array (
							array (
								'key' => 'field_54b67961daa4b',
								'label' => 'Afbeelding',
								'name' => 'afbeelding',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'object',
								'preview_size' => 'groot',
								'library' => 'all',
							),
						),
					),
					// array (
					// 	'label' => 'Video',
					// 	'name' => 'video',
					// 	'display' => 'row',
					// 	'min' => '',
					// 	'max' => '',
					// 	'sub_fields' => array (
					// 		array (
					// 			'key' => 'field_54be32880e156',
					// 			'label' => 'Youtube',
					// 			'name' => 'youtube',
					// 			'type' => 'text',
					// 			'column_width' => '',
					// 			'default_value' => '',
					// 			'placeholder' => '',
					// 			'prepend' => '',
					// 			'append' => '',
					// 			'formatting' => 'html',
					// 			'maxlength' => '',
					// 		),
					// 		array (
					// 			'key' => 'field_54be32970e157',
					// 			'label' => 'Vimeo',
					// 			'name' => 'vimeo',
					// 			'type' => 'text',
					// 			'column_width' => '',
					// 			'default_value' => '',
					// 			'placeholder' => '',
					// 			'prepend' => '',
					// 			'append' => '',
					// 			'formatting' => 'html',
					// 			'maxlength' => '',
					// 		),
					// 		array (
					// 			'key' => 'field_557fe211202a1',
					// 			'label' => 'Iframe',
					// 			'name' => 'iframe',
					// 			'type' => 'text',
					// 			'column_width' => '',
					// 			'default_value' => '',
					// 			'placeholder' => '',
					// 			'prepend' => '',
					// 			'append' => '',
					// 			'formatting' => 'html',
					// 			'maxlength' => '',
					// 		),
					// 	),
					// ),
					// array (
					// 	'label' => 'Grafiek',
					// 	'name' => 'grafiek',
					// 	'display' => 'row',
					// 	'min' => '',
					// 	'max' => '',
					// 	'sub_fields' => array (
					// 		array (
					// 			'key' => 'field_54cd18cc96a92',
					// 			'label' => 'File',
					// 			'name' => 'file',
					// 			'type' => 'file',
					// 			'conditional_logic' => array (
					// 				'status' => 1,
					// 				'rules' => array (
					// 					array (
					// 						'field' => 'field_54cd18fb96a93',
					// 						'operator' => '==',
					// 						'value' => 'planning',
					// 					),
					// 				),
					// 				'allorany' => 'all',
					// 			),
					// 			'column_width' => '',
					// 			'save_format' => 'url',
					// 			'library' => 'all',
					// 		),
					// 		array (
					// 			'key' => 'field_54cd18fb96a93',
					// 			'label' => 'Grafieksoort',
					// 			'name' => 'grafieksoort',
					// 			'type' => 'select',
					// 			'column_width' => '',
					// 			'choices' => array (
					// 				'budget' => 'Budget',
					// 				'planning' => 'Planning',
					// 				'kolomdiagram' => 'Kolomdiagram',
					// 				'vervoersmodel' => 'Vervoersmodel',
					// 				'prognose' => 'Prognose in- en uitstappers',
					// 				'reistijden' => 'Reistijden',
					// 				'compacteplanning' => 'Compacte planning',
					// 			),
					// 			'default_value' => '',
					// 			'allow_null' => 0,
					// 			'multiple' => 0,
					// 		),
					// 		array (
					// 			'key' => 'field_569d2a82132b9',
					// 			'label' => 'Taak',
					// 			'name' => 'taak',
					// 			'type' => 'select',
					// 			'conditional_logic' => array (
					// 				'status' => 1,
					// 				'rules' => array (
					// 					array (
					// 						'field' => 'field_54cd18fb96a93',
					// 						'operator' => '==',
					// 						'value' => 'planning',
					// 					),
					// 				),
					// 				'allorany' => 'all',
					// 			),
					// 			'column_width' => '',
					// 			'choices' => array (
					// 				'noordzuidlijn' => 'Noord/Zuidlijn',
					// 				'oostlijn' => 'Oostlijn',
					// 				'station' => 'Station',
					// 			),
					// 			'default_value' => '',
					// 			'allow_null' => 0,
					// 			'multiple' => 0,
					// 		),
					// 		array (
					// 			'key' => 'field_54cd2b0add435',
					// 			'label' => 'Tekst',
					// 			'name' => 'tekst',
					// 			'type' => 'wysiwyg',
					// 			'conditional_logic' => array (
					// 				'status' => 1,
					// 				'rules' => array (
					// 					array (
					// 						'field' => 'field_54cd18fb96a93',
					// 						'operator' => '==',
					// 						'value' => 'kolomdiagram',
					// 					),
					// 				),
					// 				'allorany' => 'all',
					// 			),
					// 			'column_width' => '',
					// 			'default_value' => '',
					// 			'toolbar' => 'full',
					// 			'media_upload' => 'yes',
					// 		),
					// 		array (
					// 			'key' => 'field_569d0d947fd8d',
					// 			'label' => 'Data ID',
					// 			'name' => 'data_id',
					// 			'type' => 'text',
					// 			'conditional_logic' => array (
					// 				'status' => 1,
					// 				'rules' => array (
					// 					array (
					// 						'field' => 'field_569d2a82132b9',
					// 						'operator' => '==',
					// 						'value' => 'station',
					// 					),
					// 				),
					// 				'allorany' => 'all',
					// 			),
					// 			'column_width' => '',
					// 			'default_value' => '',
					// 			'placeholder' => '',
					// 			'prepend' => '',
					// 			'append' => '',
					// 			'formatting' => 'html',
					// 			'maxlength' => '',
					// 		),
					// 	),
					// ),
					// array (
					// 	'label' => 'Fotomorph',
					// 	'name' => 'fotomorph',
					// 	'display' => 'row',
					// 	'min' => '',
					// 	'max' => '',
					// 	'sub_fields' => array (
					// 		array (
					// 			'key' => 'field_57a843cb59b34',
					// 			'label' => 'Foto oud',
					// 			'name' => 'foto_oud',
					// 			'type' => 'image',
					// 			'column_width' => '',
					// 			'save_format' => 'object',
					// 			'preview_size' => 'large',
					// 			'library' => 'all',
					// 		),
					// 		array (
					// 			'key' => 'field_57a843e159b35',
					// 			'label' => 'Foto nieuw',
					// 			'name' => 'foto_nieuw',
					// 			'type' => 'image',
					// 			'column_width' => '',
					// 			'save_format' => 'object',
					// 			'preview_size' => 'large',
					// 			'library' => 'all',
					// 		),
					// 	),
					// ),
				),
				'button_label' => 'Sectie toevoegen',
				'min' => '',
				'max' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
