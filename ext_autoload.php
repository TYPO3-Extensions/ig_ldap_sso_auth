<?php
// DO NOT CHANGE THIS FILE! It is automatically generated by extdeveval::buildAutoloadRegistry.
// This file was generated on 2010-07-06 16:13

$extensionPath = t3lib_extMgm::extPath('ig_ldap_sso_auth');
return array(
	'tx_igldapssoauth_scheduler_synchroniseusers'  => $extensionPath . 'lib/class.tx_igldapssoauth_scheduler_synchroniseusers.php',
	'tx_igldapssoauth_auth'				=>	$extensionPath . 'lib/class.tx_igldapssoauth_auth.php',
	'tx_igldapssoauth_config'			=>	$extensionPath . 'lib/class.tx_igldapssoauth_config.php',
	'tx_igldapssoauth_ldap_group'		=>	$extensionPath . 'lib/class.tx_igldapssoauth_ldap_group.php',
	'tx_igldapssoauth_ldap_user'		=>	$extensionPath . 'lib/class.tx_igldapssoauth_ldap_user.php',
	'tx_igldapssoauth_ldap'				=>	$extensionPath . 'lib/class.tx_igldapssoauth_ldap.php',
	'tx_igldapssoauth_typo3_group'		=>	$extensionPath . 'lib/class.tx_igldapssoauth_typo3_group.php',
	'tx_igldapssoauth_typo3_user'		=>	$extensionPath . 'lib/class.tx_igldapssoauth_typo3_user.php',
	'tx_igldapssoauth_utility_db'		=>	$extensionPath . 'classes/utility/class.tx_igldapssoauth_utility_db.php',
	'tx_igldapssoauth_utility_debug'	=>	$extensionPath . 'classes/utility/class.tx_igldapssoauth_utility_debug.php',
	'tx_igldapssoauth_utility_ldap'		=>	$extensionPath . 'classes/utility/class.tx_igldapssoauth_utility_ldap.php',
	
	// RSA authentication Classes
	'tx_rsaauth_backendfactory'			=>	t3lib_extMgm::extPath('rsaauth') . 'sv1/backends/class.tx_rsaauth_backendfactory.php',
	'tx_rsaauth_storagefactory'			=>	t3lib_extMgm::extPath('rsaauth') . 'sv1/storage/class.tx_rsaauth_storagefactory.php',
	
	// Service authentication Class
	//'tx_sv_auth'						=>	t3lib_extMgm::extPath('sv') . 'class.tx_sv_auth.php',
);
?>