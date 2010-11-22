<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/


$hook['post_controller_constructor'][] = array(
                                'class'    => '',
                                'function' => 'checkAclHook',
                                'filename' => 'ACL.php',
                                'filepath' => 'hooks'
                                );

$hook['post_controller_constructor'][] = array(
                                'class'    => '',
                                'function' => 'ping',
                                'filename' => 'Ping.php',
                                'filepath' => 'hooks'
                                );

$hook['display_override'][] = array(
								'class' => '',
								'function' => 'auto_render',
								'filename' => 'auto_render.php',
								'filepath' => 'hooks'
								);

/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */