<?php
/**
* @package phpBB Extension - LMDI Instant Shadow Topic
* @copyright (c) 2016 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\instantsha\acp;

class instantsha_module {

	var $u_action;
	var $action;

	public function main ($id, $mode)
	{
		global $db, $user, $template, $request, $config;

		$user->add_lang_ext ('lmdi/instantsha', 'instantsha');

		$this->tpl_name = 'acp_instantsha_body';
		$this->page_title = $user->lang('ACP_INSTANTSHA_TITLE');

		$action = $request->variable ('action', '');
		$action_config = $this->u_action . "&action=config";

		if ($action == 'config')
		{
			if (!check_form_key('acp_instantsha_body'))
			{
				trigger_error('FORM_INVALID');
			}
			else
			{
				$target = (int) $request->variable ('forum', 0);
				$config->set ('lmdi_instantsha', $target);
				$message = $user->lang['CONFIG_UPDATED'];
				trigger_error($message . adm_back_link ($this->u_action));
			}
		}

		$form_key = 'acp_instantsha_body';
		add_form_key ($form_key);

		$target = $config['lmdi_instantsha'];
		$forum_list = make_forum_select(false, false, true, true, true, false, true);
		foreach ($forum_list as $row)
		{
			$template->assign_block_vars('forums', array(
				'FORUM_NAME'			=> $row['forum_name'],
				'FORUM_ID'			=> $row['forum_id'],
				'SELECTED'			=> (($target == $row['forum_id']) ? "selected" : "")
			));
		}

		$sql = "SELECT * from " . FORUMS_TABLE . " WHERE forum_id = '$target'";
		$result = $db->sql_query($sql);
		$forum = $db->sql_fetchrow ($result);

		$template->assign_vars (array(
			'C_ACTION'		=> $action_config,
			));
		$db->sql_freeresult($result);
	}

}
