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
	'INSTANTSHA'			=> 'Sujet-traceur instantané',
	'INSTANTSHA_MOVE'		=> 'Création d’un sujet-traceur',

// ACP
	'ACP_INSTANTSHA_TITLE'	=> 'Sujet-traceur instantané',
	'ACP_INSTANTSHA_SETTINGS'	=> 'Paramétrage de l’extension',
	'ACP_INSTANTSHA_ALLOW_FEATURE'		=> 'Sélection du forum de destination',
	'ACP_INSTANTSHA_ALLOW_FEATURE_EXPLAIN'	=> 'Vous pouvez sélectionner ci-contre le forum qui sera la destination des sujets-traceurs créés.',
));
