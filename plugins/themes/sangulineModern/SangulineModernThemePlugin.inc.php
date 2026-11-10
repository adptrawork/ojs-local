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

		// Drop the parent visual layer. The parent JS stays because it powers
		// dropdowns, the abstract toggle, registration toggles and the slider.
		$this->removeStyle('stylesheet');
		$this->removeStyle('font');

		// Parent Bootstrap 4 scripts and main.js are replaced by Bootstrap 5
		// bundle + jrdc.js. jQuery stays because OJS core/plugins use it.
		$this->removeScript('popper');
		$this->removeScript('bsUtil');
		$this->removeScript('bsDropdown');
		$this->removeScript('default');

		// Parent JS URLs contain Windows backslashes (ThemePlugin::_getBaseUrl uses
		// DIRECTORY_SEPARATOR) and return 404 on Apache. Re-register the remaining
		// parent script with a forward-slash URL.
		$request = Application::get()->getRequest();
		$base = $request->getBaseUrl();
		$this->addScript('announcementSlider', $base . '/plugins/themes/sanguline/js/announcement-slider.js', ['baseUrl' => '']);
		$this->addScript('bootstrap', $base . '/plugins/themes/sangulineModern/vendor/bootstrap/bootstrap.bundle.min.js', ['baseUrl' => '']);
		$this->addScript('jrdc', $base . '/plugins/themes/sangulineModern/js/jrdc.js', ['baseUrl' => '']);

		// Explicitly register navigation menu areas
		$this->addMenuArea(['primary', 'user', 'sidebar']);

		// Geist only. Material Symbols was loaded but never used.
		$this->addStyle(
			'fontGeist',
			'https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&display=swap',
			['baseUrl' => '']
		);

		$this->addOption('modernAccent', 'FieldColor', [
			'label' => 'Modern accent color',
			'description' => 'Optional accent color for Sanguline Modern highlights (hex, e.g. #0b2038). Default is institutional navy.',
			'default' => '#0b2038',
		]);

		// Bootstrap 5.3.3, vendored locally. Absolute URL avoids Windows backslashes.
		$this->addStyle(
			'bootstrap',
			$base . '/plugins/themes/sangulineModern/vendor/bootstrap/bootstrap.min.css',
			['baseUrl' => '']
		);

		// Font Awesome is already loaded by core frontend CSS.
		$this->addStyle('stylesheetModern', 'styles/index.less');

		$accent = $this->getOption('modernAccent');
		if (!$accent || !preg_match('/^#[0-9a-fA-F]{3,6}$/', $accent)) {
			$accent = '#0b2038';
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
