<?php
/*
+--------------------------------------------------------------------------
|   WeCenter [#RELEASE_VERSION#]
|   ========================================
|   by WeCenter Software
|   © 2011 - 2013 WeCenter. All Rights Reserved
|   http://www.wecenter.com
|   ========================================
|   Support: WeCenter@qq.com
|   
+---------------------------------------------------------------------------
*/


if (!defined('IN_ANWSION'))
{
	die;
}

class main extends AWS_CONTROLLER
{
	public function get_access_rule()
	{
		$rule_action['rule_type'] = 'black';
		$rule_action['actions'] = array();
		
		return $rule_action;
	}

	public function setup()
	{
		HTTP::no_cache_header();
	}

	public function index_action()
	{
		if ($this->is_post())
		{
			define('IN_AJAX', TRUE);
		
			if ($_POST['upload_dir'] && preg_match('/(.*)\/$/i', $_POST['upload_dir']))
			{
				H::redirect_msg(AWS_APP::lang()->_t('上传文件存放绝对路径不能以 / 结尾'));
			}

			if ($_POST['upload_url'] && preg_match('/(.*)\/$/i', $_POST['upload_url']))
			{
				H::redirect_msg(AWS_APP::lang()->_t('上传目录外部访问 URL 地址不能以 / 结尾'));
			}
			
			$allow_settings = array(
				'base_url' => $_POST['base_url'],
				'img_url' => $_POST['img_url'],
				'upload_dir' => $_POST['upload_dir'],
				'upload_url' => $_POST['upload_url'],
			);
			
			$this->model('setting')->set_vars($this->model('setting')->check_vars($allow_settings));
		
			H::redirect_msg(AWS_APP::lang()->_t('系统设置修改成功, 请立即删除 app/migrate 目录'));
		}
			
		TPL::assign('page_title', 'WeCenter - Migrate Tools');
		
		if (strstr($_SERVER['REQUEST_URI'], '/?'))
		{
			TPL::assign('static_url', './static');
		}
		else
		{
			TPL::assign('static_url', './../static');
		}

		switch ($_POST['act'])
		{
			default :
				TPL::assign('setting', get_setting(null, false));
		
				TPL::output('migrate/index');
			break;
		}
	}
}