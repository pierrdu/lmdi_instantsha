<?php
/**
*
* @package phpBB Extension - LMDI instant Shadow Topic
* @copyright (c) 2016 LMDI - Pierre Duhem
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\instantsha\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $user;
	protected $db;
	protected $template;
	protected $config;
	protected $root_path;
	protected $phpEx;
	protected $request;
	protected $auth;
	protected $phpbb_log;
	protected $fid;	// Class global because of function build_url
	protected $tid;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\request\request $request,
		\phpbb\auth\auth $auth,
		\phpbb\log\log $log,
		$root_path,
		$phpEx
		)
	{
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->request = $request;
		$this->auth = $auth;
		$this->root_path = $root_path;
		$this->phpEx = $phpEx;
		$this->phpbb_log = $log;
	}


	static public function getSubscribedEvents ()
	{
	return array(
		'core.user_setup'				=> 'load_language_on_setup',
		'core.page_header'				=> 'build_url',
		'core.viewtopic_get_post_data'	=> 'create_shadow_topic',
		);
	}


	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'lmdi/instantsha',
			'lang_set' => 'instantsha',
			);
		$event['lang_set_ext'] = $lang_set_ext;
	}


	public function build_url($event)
	{
		$target = (int) $this->config['lmdi_instantsha'];
		// Target forum configured and we aren't in this forum
		if ($target && ($target != $this->fid))
		{
			$params = "f=$this->fid&amp;t=$this->tid&amp;shadow=1";
			$url = append_sid($this->root_path . 'viewtopic.' . $this->phpEx, $params);
			$this->template->assign_vars(array(
				'U_INSTANTSHA'	=> $url,
				'L_INSTANTSHA'	=> $this->user->lang['INSTANTSHA'],
				'S_INSTANTSHA'	=> true,
				));
		}
		else
		{
		$this->template->assign_vars(array(
			'S_TRASHBIN'	=> false,
			));
		}
	}

	public function create_shadow_topic($event)
	{
		$shadow = $this->request->variable('shadow', 0);
		$this->fid = (int) $this->request->variable('f', 0);
		$this->tid = (int) $this->request->variable('t', 0);
		if ($shadow)
		{
			$user_id = $this->user->data['user_id'];
			$target = $this->config['lmdi_instantsha'];
			if ($target != 0 && $this->fid != $target)
			{
				if ($this->auth->acl_get('m_delete', $this->fid) || $this->auth->acl_get('m_move', $this->fid))
				{
					$sql = 'SELECT * FROM ' .TOPICS_TABLE . " WHERE topic_id = $this->tid";
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult ($result);
					$row['topic_moved_id'] = $this->tid;
					$row['topic_id'] = '0';
					$row['forum_id'] = $target;
					$row['topic_status'] = ITEM_MOVED;
					// var_dump ($row);
					$sql = 'INSERT INTO ' . TOPICS_TABLE . ' ' . $this->db->sql_build_array('INSERT', $row);
					var_dump ($sql);
					$this->db->sql_query($sql);

					// Redirection
					$params = "f={$this->fid}&amp;t={$this->tid}";
					$url = append_sid($this->root_path . 'viewtopic.' . $this->phpEx, $params);
					var_dump ($url);
					// redirect($url);
				}
			}
		}
	}

}
