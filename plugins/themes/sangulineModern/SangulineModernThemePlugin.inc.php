<?php

/**
 * @file plugins/themes/sangulineModern/SangulineModernThemePlugin.inc.php
 *
 * @class SangulineModernThemePlugin
 * @ingroup plugins_themes_sangulinemodern
 *
 * @brief Sanguline Modern child theme for OJS 3.3 (extends Sanguline).
 */

import('lib.pkp.classes.plugins.ThemePlugin');

class SangulineModernThemePlugin extends ThemePlugin {

	/**
	 * @copydoc ThemePlugin::isActive()
	 */
	public function isActive() {
		if (defined('SESSION_DISABLE_INIT')) {
			return true;
		}
		return parent::isActive();
	}

	/**
	 * Initialize the theme.
	 *
	 * @return null
	 */
	public function init() {
		$this->setParent('sanguline');

		$this->addOption('modernAccent', 'FieldColor', [
			'label' => 'Modern accent color',
			'description' => 'Optional accent color for Sanguline Modern highlights (hex, e.g. #2563eb). Leave empty to use the parent theme primary color.',
			'default' => '',
		]);

		$this->addStyle('stylesheetModern', 'styles/index.less');

		$accent = $this->getOption('modernAccent');
		if ($accent && preg_match('/^#[0-9a-fA-F]{3,6}$/', $accent)) {
			$this->modifyStyle('stylesheetModern', [
				'addLessVariables' => '@modern-accent: ' . $accent . ';',
			]);
		}
	}

	/**
	 * Get the name of the settings file to be installed on new context creation.
	 *
	 * @return string
	 */
	public function getContextSpecificPluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * Get the name of the settings file to be installed site-wide.
	 *
	 * @return string
	 */
	public function getInstallSitePluginSettingsFile() {
		return $this->getPluginPath() . '/settings.xml';
	}

	/**
	 * @copydoc ThemePlugin::saveOption()
	 */
	public function saveOption($name, $value, $contextId = null) {
		if ($name == 'modernAccent') {
			if ($value !== '' && $value !== null && !preg_match('/^#[0-9a-fA-F]{3,6}$/', $value)) {
				$value = '';
			}
		}
		parent::saveOption($name, $value, $contextId);
	}

	/**
	 * Get the display name of this plugin.
	 *
	 * @return string
	 */
	public function getDisplayName() {
		return 'Sanguline Modern Theme';
	}

	/**
	 * Get the description of this plugin.
	 *
	 * @return string
	 */
	public function getDescription() {
		return 'A modern academic child theme for Sanguline (OJS 3.3), with refined typography, spacing, cards, and navigation while preserving Sanguline compatibility.';
	}
}
