<?php
/**
*
* @package phpBB Extension - LMDI Instant Shadow Topic
* @copyright (c) 2015-2016 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\instantsha\acp;

class instantsha_info
{
	function module()
	{
		return array(
			'filename'	=> '\lmdi\instantsha\acp\instantsha_module',
			'title'		=> 'ACP_INSTANTSHA_TITLE',
			'version'		=> '1.0.0',
			'modes'		=> array (
				'settings'	=> array('title' => 'ACP_INSTANTSHA_SETTINGS',
				'auth' => 'ext_lmdi/instantsha',
				'cat' => array('ACP_INSTANTSHA_TITLE')),
			),
		);
	}
}
