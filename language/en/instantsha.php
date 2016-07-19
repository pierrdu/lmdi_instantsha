<?php
/**
* gloss.php
* @package phpBB Extension - LMDI Instant Shadow Topic
* @copyright (c) 2016 LMDI - Pierre Duhem
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge ($lang, array(
	'INSTANTSHA'	=> 'Instant Shadow Topic',
	'INSTANTSHA_MOVE'	=> 'Shadow topic created in the target forum',

// ACP
	'ACP_INSTANTSHA_TITLE'	=> 'Instant Shadow Topic',
	'ACP_INSTANTSHA_SETTINGS'	=> 'Settings',
	'ACP_INSTANTSHA_ALLOW_FEATURE'		=> 'Target forum selection',
	'ACP_INSTANTSHA_ALLOW_FEATURE_EXPLAIN'	=> 'You may select the forum used as a target of the shadow topic creation.',

));
