<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| USER AGENT TYPES
| -------------------------------------------------------------------
| This file contains four arrays of user agent data.  It is used by the
| User Agent Class to help identify browser, platform, robot, and
| mobile device data.  The array keys are used to identify the device
| and the array values are used to set the actual name of the item.
|
*/

$config = array (
					'useragent'	=> 'EffectHub.com',
					'protocol'	=> 'smtp',
					'mailpath'	=> '/usr/sbin/sendmail',
					'smtp_host'	=> 'localhost',
					'smtp_user'	=> 'message',
					'smtp_pass'			=> 'msg001',
					'smtp_port'			=> '25',
					'smtp_timeout'				=> '5',
					'wordwrap'		=> 'TRUE',
					'wrapchars'				=> '76',
					'mailtype'		=> 'html',
					'charset'				=> 'utf-8',
					'validate'			=> 'FALSE',
					'priority'				=> '3',
					'crlf'			=> '\n',
					'newline'			=> '\n',
					'bcc_batch_mode'				=> 'FALSE',
					'bcc_batch_size'				=> '200'
				);

/* End of file user_agents.php */
/* Location: ./application/config/user_agents.php */