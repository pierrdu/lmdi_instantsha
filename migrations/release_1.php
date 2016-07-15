<?php
/**
*
* @package phpBB Extension - LMDI Instant Shadow Topic
* @copyright (c) 2016 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\instantsha\migrations;

class release_1 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['lmdi_instantsha']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}

	public function update_data()
	{
		return array(
			// ACP modules
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_INSTANTSHA_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_INSTANTSHA_TITLE',
				array(
					'module_basename'	=> '\lmdi\instantsha\acp\instantsha_module',
					'modes'			=> array('settings'),
				),
			)),

			// Configuration rows
			array('config.add', array('lmdi_instantsha', 0)),

		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('lmdi_instantsha')),

			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_INSTANTSHA_TITLE'
			)),

		);
	}

}
