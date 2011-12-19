<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2007-2011 Michael Gagnon <mgagnon@infoglobe.ca>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class tx_igldapssoauth_config for the 'ig_ldap_sso_auth' extension.
 *
 * @author	Michael Gagnon <mgagnon@infoglobe.ca>
 * @package	TYPO3
 * @subpackage	ig_ldap_sso_auth
 *
 * $Id$
 */
class tx_igldapssoauth_config {

	var $uid;
	var $name;
	var $typo3_mode;
	var $be;
	var $fe;
	var $ldap;
	var $cas;

	function init($typo3_mode = null, $uid = 0) {
		$this->uid = $uid ? $uid : $GLOBALS['EXT_CONFIG']['uidConfiguration'];

		// Default TYPO3_MODE is BE
		$this->typo3_mode = $typo3_mode ? strtolower($typo3_mode) : strtolower(TYPO3_MODE);

		// Select configuration from database, merge with extension configuration template and initialise class attributes.

		$config = tx_igldapssoauth_config::select($this->uid);

		$GLOBALS['EXT_CONFIG'] = array_merge(is_array($GLOBALS['EXT_CONFIG']) ? $GLOBALS['EXT_CONFIG'] : array(), $config ? $config : array());

		$this->name = $GLOBALS['EXT_CONFIG']['name'];

		$this->be['LDAPAuthentication'] = $GLOBALS['EXT_CONFIG']['enableBELDAPAuthentication'];
		$this->be['CASAuthentication'] = 0;
		$this->be['DeleteCookieLogout'] = 0;
		$this->be['forceLowerCaseUsername'] = $GLOBALS['EXT_CONFIG']['forceLowerCaseUsername'] ? $GLOBALS['EXT_CONFIG']['forceLowerCaseUsername'] : 0;
		$this->be['evaluateGroupsFromMembership'] = $GLOBALS['EXT_CONFIG']['evaluateGroupsFromMembership'];
		$this->be['IfUserExist'] = $GLOBALS['EXT_CONFIG']['TYPO3BEUserExist'];
		$this->be['IfGroupExist'] = 0;
		$this->be['BEfailsafe'] = $GLOBALS['EXT_CONFIG']['BEfailsafe'];
		$this->be['DeleteUserIfNoLDAPGroups'] = 0;
		$this->be['DeleteUserIfNoTYPO3Groups'] = 0;
		$this->be['GroupsNotSynchronize'] = $GLOBALS['EXT_CONFIG']['TYPO3BEGroupsNotSynchronize'];
		$this->be['requiredLDAPGroups'] = $GLOBALS['EXT_CONFIG']['requiredLDAPBEGroups'] ? $GLOBALS['EXT_CONFIG']['requiredLDAPBEGroups'] : 0;
		$this->be['updateAdminAttribForGroups'] = $GLOBALS['EXT_CONFIG']['updateAdminAttribForGroups'] ? $GLOBALS['EXT_CONFIG']['updateAdminAttribForGroups'] : 0;
		$this->be['assignGroups'] = $GLOBALS['EXT_CONFIG']['assignBEGroups'] ? $GLOBALS['EXT_CONFIG']['assignBEGroups'] : 0;
		$this->be['keepTYPO3Groups'] = $GLOBALS['EXT_CONFIG']['keepBEGroups'];
		$this->be['users']['basedn'] = explode('||', $GLOBALS['EXT_CONFIG']['be_users_basedn']);
		$this->be['users']['filter'] = $GLOBALS['EXT_CONFIG']['be_users_filter'];
		$this->be['users']['mapping'] = tx_igldapssoauth_config::make_user_mapping($GLOBALS['EXT_CONFIG']['be_users_mapping'], $GLOBALS['EXT_CONFIG']['be_users_filter']);
		$this->be['groups']['basedn'] = $GLOBALS['EXT_CONFIG']['be_groups_basedn'];
		$this->be['groups']['filter'] = $GLOBALS['EXT_CONFIG']['be_groups_filter'];
		$this->be['groups']['mapping'] = tx_igldapssoauth_config::make_group_mapping($GLOBALS['EXT_CONFIG']['be_groups_mapping']);

		$this->fe['LDAPAuthentication'] = $GLOBALS['EXT_CONFIG']['enableFELDAPAuthentication'];
		$this->fe['DeleteCookieLogout'] = $GLOBALS['EXT_CONFIG']['DeleteCookieLogout'];
		$this->fe['CASAuthentication'] = $GLOBALS['EXT_CONFIG']['enableFECASAuthentication'];
		$this->fe['forceLowerCaseUsername'] = $GLOBALS['EXT_CONFIG']['forceLowerCaseUsername'] ? $GLOBALS['EXT_CONFIG']['forceLowerCaseUsername'] : 0;
		$this->fe['evaluateGroupsFromMembership'] = $GLOBALS['EXT_CONFIG']['evaluateGroupsFromMembership'];
		$this->fe['IfUserExist'] = 0;
		$this->fe['IfGroupExist'] = $GLOBALS['EXT_CONFIG']['TYPO3FEGroupExist'];
		$this->fe['BEfailsafe'] = 0;
		$this->fe['updateAdminAttribForGroups'] = 0;
		$this->fe['DeleteUserIfNoTYPO3Groups'] = $GLOBALS['EXT_CONFIG']['TYPO3FEDeleteUserIfNoTYPO3Groups'];
		$this->fe['DeleteUserIfNoLDAPGroups'] = $GLOBALS['EXT_CONFIG']['TYPO3FEDeleteUserIfNoLDAPGroups'];
		$this->fe['GroupsNotSynchronize'] = $GLOBALS['EXT_CONFIG']['TYPO3FEGroupsNotSynchronize'];
		$this->fe['assignGroups'] = $GLOBALS['EXT_CONFIG']['assignFEGroups'] ? $GLOBALS['EXT_CONFIG']['assignFEGroups'] : 0;
		$this->fe['keepTYPO3Groups'] = $GLOBALS['EXT_CONFIG']['keepFEGroups'];
		$this->fe['requiredLDAPGroups'] = $GLOBALS['EXT_CONFIG']['requiredLDAPFEGroups'] ? $GLOBALS['EXT_CONFIG']['requiredLDAPFEGroups'] : 0;
		$this->fe['users']['basedn'] = explode('||', $GLOBALS['EXT_CONFIG']['fe_users_basedn']);
		$this->fe['users']['filter'] = $GLOBALS['EXT_CONFIG']['fe_users_filter'];
		$this->fe['users']['mapping'] = tx_igldapssoauth_config::make_user_mapping($GLOBALS['EXT_CONFIG']['fe_users_mapping'], $GLOBALS['EXT_CONFIG']['fe_users_filter']);
		$this->fe['groups']['basedn'] = $GLOBALS['EXT_CONFIG']['fe_groups_basedn'];
		$this->fe['groups']['filter'] = $GLOBALS['EXT_CONFIG']['fe_groups_filter'];
		$this->fe['groups']['mapping'] = tx_igldapssoauth_config::make_group_mapping($GLOBALS['EXT_CONFIG']['fe_groups_mapping']);

		$this->cas['host'] = $GLOBALS['EXT_CONFIG']['cas_host'];
		$this->cas['port'] = $GLOBALS['EXT_CONFIG']['cas_port'];
		$this->cas['logout_url'] = $GLOBALS['EXT_CONFIG']['cas_logout_url'];
		$this->cas['uri'] = $GLOBALS['EXT_CONFIG']['cas_uri'];
		$this->cas['service_url'] = $GLOBALS['EXT_CONFIG']['cas_service_url'];

		$this->ldap['server'] = $GLOBALS['EXT_CONFIG']['ldap_server'];
		$this->ldap['host'] = $GLOBALS['EXT_CONFIG']['ldap_host'];
		$this->ldap['port'] = $GLOBALS['EXT_CONFIG']['ldap_port'];
		$this->ldap['protocol'] = $GLOBALS['EXT_CONFIG']['ldap_protocol'];
		$this->ldap['charset'] = $GLOBALS['EXT_CONFIG']['ldap_charset'] ? $GLOBALS['EXT_CONFIG']['ldap_charset'] : 'utf-8';
		$this->ldap['binddn'] = $GLOBALS['EXT_CONFIG']['ldap_binddn'];
		$this->ldap['password'] = $GLOBALS['EXT_CONFIG']['ldap_password'];

	}

	function make_user_mapping($mapping = '', $filter = '') {

		// Default fields : username, tx_igldapssoauth_dn

		$user_mapping = tx_igldapssoauth_config::make_mapping($mapping);
		$user_mapping['username'] = '<' . tx_igldapssoauth_config::get_username_attribute($filter) . '>';
		$user_mapping['tx_igldapssoauth_dn'] = '<dn>';

		return $user_mapping;

	}

	function make_group_mapping($mapping = '') {

		// Default fields : title, tx_igldapssoauth_dn

		$group_mapping = tx_igldapssoauth_config::make_mapping($mapping);
		if (!array_key_exists('title', $group_mapping)) {
			$group_mapping['title'] = '<dn>';
		}
		$group_mapping['tx_igldapssoauth_dn'] = '<dn>';

		return $group_mapping;

	}

	function make_mapping($mapping = '') {

		$config_mapping = array();

		$mapping_array = explode(chr(10), $mapping);

		if (is_array($mapping_array)) {

			foreach ($mapping_array as $field) {

				$field_mapping = explode('=', $field);

				$field_mapping[1] ? $config_mapping[trim($field_mapping[0])] = trim($field_mapping[1]) : null;

			}

		}

		return $config_mapping;

	}

	function get_pid($mapping = array()) {

		if (!$mapping) {
			return null;
		}

		return array_key_exists('pid', $mapping) ? (is_numeric($mapping['pid']) ? $mapping['pid'] : 0) : 0;

	}

	function get_username_attribute($filter = null) {

		if ($filter && preg_match("'([^$]*)\(([^$]*)={USERNAME}\)'", $filter, $username)) {

			return ($username[2]);

		}

		return false;

	}

	function get_values($key = null) {

		$config = get_object_vars($this);

		// No key, return all configuration array.
		if (!$key) {

			return $config;

		}

		// Key exist in array, return this value.
		if (array_key_exists($key, $config)) {

			return $config[$key];

		}

		// If one sequence of key is in index add it.
		foreach ($config as $index => $value) {

			if (ereg($key, $index)) {

				$config_array[$index] = $config[$index];

			}

		}

		return $config_array;

	}

	function is_enable($feature = null) {

		$config = tx_igldapssoauth_config::get_values($this->typo3_mode);

		return (isset($config[$feature]) ? $config[$feature] : 0);

	}

	function get_ldap_attributes($mapping = array()) {

		if (is_array($mapping)) {

			foreach ($mapping as $attribute) {

				if (preg_match("`<([^$]*)>`", $attribute, $match)) {

					$ldap_attributes[] = strtolower($match[1]);

				}

			}

		}

		return $ldap_attributes;

	}

	function get_server_name($uid = null) {
		switch ($uid) {
			case 0 :
				$server = 'OpenLDAP';
				break;
			case 1 :
				$server = 'Novell eDirectory';
				break;
			default:
				$server = NULL;
		}

		return $server;
	}

	function replace_filter_markers($filter = null) {

		$filter = str_replace('{USERNAME}', '*', $filter);
		preg_match("'([^$]*)\(([^$]*)={USERDN}\)'", $filter, $member_attribute);
		//return str_replace('('.$member_attribute[2].'={USERDN})', '', $filter);
		return str_replace('{USERDN}', '*', $filter);

	}

	function select($uid = 0) {

		// Get extension configuration array from table tx_igldapssoauth_config

		$query = array(
			'SELECT' => '*',
			'FROM' => 'tx_igldapssoauth_config',
			'WHERE' => 'tx_igldapssoauth_config.hidden = 0 AND tx_igldapssoauth_config.deleted = 0 AND tx_igldapssoauth_config.uid=' . $uid,
			'GROUP_BY' => '',
			'ORDER_BY' => '',
			'LIMIT' => '0,1',
			'UID_INDEX_FIELD' => ''
		);

		$config = tx_igldapssoauth_utility_Db::select($query);
		return $config[0];

	}

	function update($config = array()) {

		$query = array(
			'TABLE' => 'tx_igldapssoauth_config',
			'WHERE' => 'tx_igldapssoauth_config.uid=' . $config['uid'],
			'FIELDS_VALUES' => $config,
			'NO_QUOTE' => false,
		);

		tx_igldapssoauth_utility_Db::update($query);

		tx_igldapssoauth_config::init(tx_igldapssoauth_config::select($config['uid']));

	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ig_ldap_sso_auth/lib/class.tx_igldapssoauth_config.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ig_ldap_sso_auth/lib/class.tx_igldapssoauth_config.php']);
}

?>