<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		Andrey Andreev
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 3.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Session Memcached Driver
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		Andrey Andreev
 * @link		http://codeigniter.com/user_guide/libraries/sessions.html
 */
class CI_Session_memcached_driver extends CI_Session_driver implements SessionHandlerInterface {

	/**
	 * Save path
	 *
	 * @var	string
	 */
	protected $_save_path;

	/**
	 * Memcached instance
	 *
	 * @var	Memcached
	 */
	protected $_memcached;

	/**
	 * Key prefix
	 *
	 * @var	string
	 */
	protected $_key_prefix = 'ci_session:';

	/**
	 * Lock key
	 *
	 * @var	string
	 */
	protected $_lock_key;

	// ------------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 * @param	array	$params	Configuration parameters
	 * @return	void
	 */
	public function __construct(&$params)
	{
		parent::__construct($params);

		if (empty($this->_save_path))
		{
			log_message('error', 'Session: No Memcached save path configured.');
		}

		if ($this->_match_ip === TRUE)
		{
			$this->_key_prefix .= $_SERVER['REMOTE_ADDR'].':';
		}
	}

	// ------------------------------------------------------------------------

	public function open($save_path, $name)
	{
		$this->_memcached = new Memcached();
		$server_list = array();
		foreach ($this->_memcached->getServerList() as $server)
		{
			$server_list[] = $server['host'].':'.$server['port'];
		}

		if ( ! preg_match_all('#,?([^,:]+)\:(\d{1,5})(?:\:(\d+))?#', $this->_save_path, $matches, PREG_SET_ORDER))
		{
			$this->_memcached = NULL;
			log_message('error', 'Session: Invalid Memcached save path format: '.$this->_save_path);
			return FALSE;
		}

		foreach ($matches as $match)
		{
			// If Memcached already has this server (or if the port is invalid), skip it
			if (in_array($match[1].':'.$match[2], $server_list, TRUE))
			{
				log_message('debug', 'Session: Memcached server pool already has '.$match[1].':'.$match[2]);
				continue;
			}

			if ( ! $this->_memcached->addServer($match[1], $match[2], isset($match[3]) ? $match[3] : 0))
			{
				log_message('error', 'Could not add '.$match[1].':'.$match[2].' to Memcached server pool.');
			}
			else
			{
				$server_list[] = $server['host'].':'.$server['port'];
			}
		}

		if (empty($server_list))
		{
			log_message('error', 'Session: Memcached server pool is empty.');
			return FALSE;
		}

		return TRUE;
	}

	// ------------------------------------------------------------------------

	public function read($session_id)
	{
		if (isset($this->_memcached) && $this->_get_lock($session_id))
		{
			$session_data = (string) $this->_memcached->get($this->_key_prefix.$session_id);
			$this->_fingerprint = md5($session_data);
			return $session_data;
		}

		return FALSE;
	}

	public function write($session_id, $session_data)
	{
		if (isset($this->_memcached, $this->_lock_key))
		{
			$this->_memcached->replace($this->_lock_key, time(), 5);
			if ($this->_fingerprint !== ($fingerprint = md5($session_data)))
			{
				if ($this->_memcached->set($this->_key_prefix.$session_id, $session_data, $this->_expiration))
				{
					$this->_fingerprint = $fingerprint;
					return TRUE;
				}

				return FALSE;
			}

			return $this->_memcached->touch($this->_key_prefix.$session_id, $this->_expiration);
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	public function close()
	{
		if (isset($this->_memcached))
		{
			isset($this->_lock_key) && $this->_memcached->delete($this->_lock_key);
			if ( ! $this->_memcached->quit())
			{
				return FALSE;
			}

			$this->_memcached = NULL;
			return TRUE;
		}

		return FALSE;
	}

	// ------------------------------------------------------------------------

	public function destroy($session_id)
	{
		if (isset($this->_memcached, $this->_lock_key))
		{
			$this->_memcached->delete($this->_key_prefix.$session_id);
			return ($this->_cookie_destroy() && $this->close());
		}

		return $this->close();
	}

	// ------------------------------------------------------------------------

	public function gc($maxlifetime)
	{
		return TRUE;
	}

	// ------------------------------------------------------------------------

	protected function _get_lock($session_id)
	{
		if (isset($this->_lock_key))
		{
			return $this->_memcached->replace($this->_lock_key, time(), 5);
		}

		$lock_key = $this->_key_prefix.$session_id.':lock';
		if ( ! ($ts = $this->_memcached->get($lock_key)))
		{
			if ( ! $this->_memcached->set($lock_key, TRUE, 5))
			{
				log_message('error', 'Session: Error while trying to obtain lock for '.$this->_key_prefix.$session_id);
				return FALSE;
			}

			$this->_lock_key = $lock_key;
			$this->_lock = TRUE;
			return TRUE;
		}

		// Another process has the lock, we'll try to wait for it to free itself ...
		$attempt = 0;
		while ($attempt++ < 5)
		{
			usleep(((time() - $ts) * 1000000) - 20000);
			if (($ts = $this->_memcached->get($lock_key)) < time())
			{
				continue;
			}

			if ( ! $this->_memcached->set($lock_key, time(), 5))
			{
				log_message('error', 'Session: Error while trying to obtain lock for '.$this->_key_prefix.$session_id);
				return FALSE;
			}

			$this->_lock_key = $lock_key;
			break;
		}

		if ($attempt === 5)
		{
			log_message('error', 'Session: Unable to obtain lock for '.$this->_key_prefix.$session_id.' after 5 attempts, aborting.');
			return FALSE;
		}

		$this->_lock = TRUE;
		return TRUE;
	}

	// ------------------------------------------------------------------------

	protected function _release_lock()
	{
		if (isset($this->_memcached, $this->_lock_key) && $this->_lock)
		{
			if ( ! $this->_memcached->delete($this->_lock_key) && $this->_memcached->getResultCode() !== Memcached::RES_NOTFOUND)
			{
				log_message('error', 'Session: Error while trying to free lock for '.$this->_key_prefix.$session_id);
				return FALSE;
			}

			$this->_lock_key = NULL;
			$this->_lock = FALSE;
		}

		return TRUE;
	}

}

/* End of file Session_memcached_driver.php */
/* Location: ./system/libraries/Session/drivers/Session_memcached_driver.php */
