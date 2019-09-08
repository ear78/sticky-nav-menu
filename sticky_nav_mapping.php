<?php
/**
 * Date: 2019-09-06
 */

/*----------------------------------------------
 * Sticky Nav Menu shortcode VC integrate
 ---------------------------------------------*/

  return array(
    "name" => __("Sticky Nav Menu", "my-text-domain"),
    'base' => 'sticky_nav_menu',
    'category' => __('Kochava Custom', 'my-text-domain'),
    'params' => array(
      array(
        'type' => 'dropdown',
        'value' => array('button-top', 'button-bottom'),
        'heading' => 'Layout',
        'param_name' => 'layout',
		'save_always' => true,
        'description' => 'Choose different layouts. Button top is above links, Button bottom is below links'
      ),
      array(
        'type' => 'textfield',
        'value' => '',
        'heading' => 'CTA Title',
        'param_name' => 'cta_text',
        'description' => 'Title text'
      ),
      array(
        'type' => 'textfield',
        'value' => '',
        'heading' => 'CTA Button Text',
        'param_name' => 'cta_text',
        'description' => 'Button text'
      ),
      array(
        'type' => 'textfield',
        'value' => '',
        'heading' => 'CTA URL',
        'param_name' => 'cta_url',
        'description' => 'URL where you want to link to.  Ex. https://twitter.com or relative to www.kochava.com you can type the page you want to hit - kochava-collective'
      ),
      array(
        'type' => 'param_group',
        'value' => '',
        'param_name' => 'titles',
        'heading' => 'Links',
        'description' => 'Toggle the arrow on the right, and build the links using the text input fields',
        'params' => array(
          array(
            'type' => 'textfield',
            'name' => 'url',
            'value' => '',
            'heading' => 'URL',
			'admin_label' => true,
            'description' => 'Path: ex. https://twitter.com or /kochava-collective if relative to https://www.kochava.com , id: ex. #some-id',
            'param_name' => 'url',
          ),
          array(
            'type' => 'textfield',
            'name' => 'title',
            'value' => '',
            'heading' => 'Title',
			'admin_label' => true,
            'description' => 'visible link text on the webpage',
            'param_name' => 'title',
          ),
          array(
            'type' => 'textfield',
            'name' => 'new_tab',
            'value' => '',
            'heading' => 'Open new tab',
			'admin_label' => true,
            'description' => 'set to "_blank" or delete/leave blank to stay on same page.',
            'param_name' => 'new_tab',
          )
        )
      )
    )
  ); //end vc_map
