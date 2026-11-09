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
		$this->setParent('sangulinethemeplugin');

		// Parent JS URLs contain Windows backslashes (ThemePlugin::_getBaseUrl uses
		// DIRECTORY_SEPARATOR) and return 404 on Apache. Re-register the same scripts
		// with forward-slash URLs; child registration overwrites the parent entry.
		$request = Application::get()->getRequest();
		$base = $request->getBaseUrl();
		$this->addScript('popper', $base . '/plugins/themes/sanguline/js/lib/popper/popper.js', ['baseUrl' => '']);
		$this->addScript('bsUtil', $base . '/plugins/themes/sanguline/js/lib/bootstrap/util.js', ['baseUrl' => '']);
		$this->addScript('bsDropdown', $base . '/plugins/themes/sanguline/js/lib/bootstrap/dropdown.js', ['baseUrl' => '']);
		$this->addScript('default', $base . '/plugins/themes/sanguline/js/main.js', ['baseUrl' => '']);
		$this->addScript('announcementSlider', $base . '/plugins/themes/sanguline/js/announcement-slider.js', ['baseUrl' => '']);
		$this->addScript('jrdc', $base . '/plugins/themes/sangulineModern/js/jrdc.js', ['baseUrl' => '']);

		// Explicitly register navigation menu areas
		$this->addMenuArea(['primary', 'user', 'sidebar']);

		// External fonts from prototype: Geist & Material Symbols
		$this->addStyle(
			'fontGeist',
			'https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Satoshi:wght@400;500;700&display=swap',
			['baseUrl' => '']
		);
		$this->addStyle(
			'fontMaterialSymbols',
			'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200',
			['baseUrl' => '']
		);

		$this->addOption('modernAccent', 'FieldColor', [
			'label' => 'Modern accent color',
			'description' => 'Optional accent color for Sanguline Modern highlights (hex, e.g. #c2410c). Default is prototype burnt orange.',
			'default' => '#c2410c',
		]);

		$this->addStyle('stylesheetModern', 'styles/index.less');

		$accent = $this->getOption('modernAccent');
		if (!$accent || !preg_match('/^#[0-9a-fA-F]{3,6}$/', $accent)) {
			$accent = '#c2410c';
		}
		$this->modifyStyle('stylesheetModern', [
			'addLessVariables' => "@modern-primary: {$accent};\n@modern-navy: #0b2038;\n",
		]);
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
	 * Usage statistics chart rendering compatibility on OJS 3.3.
	 *
	 * @return bool
	 */
	public function supportsUsageStats() {
		return false;
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
