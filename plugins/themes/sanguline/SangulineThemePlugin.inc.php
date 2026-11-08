<?php

/**
 * @file plugins/themes/Sanguline/SangulineThemePlugin.inc.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class SangulineThemePlugin
 * @ingroup plugins_themes_sanguline
 *
 * @brief Sanguline theme for OJS 3.3
 */

if (!class_exists('SangulineThemePlugin')) {
	import('lib.pkp.classes.plugins.ThemePlugin');
	import('classes.file.PublicFileManager');

	class SangulineThemePlugin extends ThemePlugin {
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
		 * Initialize the theme's styles, scripts and hooks.
		 *
		 * @return null
		 */
		public function init() {
			AppLocale::requireComponents(LOCALE_COMPONENT_PKP_MANAGER, LOCALE_COMPONENT_APP_MANAGER);

			$this->addOption('typography', 'FieldOptions', [
				'type' => 'radio',
				'label' => __('plugins.themes.sanguline.option.typography.label'),
				'description' => __('plugins.themes.sanguline.option.typography.description'),
				'options' => [
					[
						'value' => 'notoSans',
						'label' => __('plugins.themes.sanguline.option.typography.notoSans'),
					],
					[
						'value' => 'notoSerif',
						'label' => __('plugins.themes.sanguline.option.typography.notoSerif'),
					],
					[
						'value' => 'notoSerif_notoSans',
						'label' => __('plugins.themes.sanguline.option.typography.notoSerif_notoSans'),
					],
					[
						'value' => 'notoSans_notoSerif',
						'label' => __('plugins.themes.sanguline.option.typography.notoSans_notoSerif'),
					],
					[
						'value' => 'lato',
						'label' => __('plugins.themes.sanguline.option.typography.lato'),
					],
					[
						'value' => 'lora',
						'label' => __('plugins.themes.sanguline.option.typography.lora'),
					],
					[
						'value' => 'lora_openSans',
						'label' => __('plugins.themes.sanguline.option.typography.lora_openSans'),
					],
				],
				'default' => 'notoSans',
			]);

			$this->addOption('baseColour', 'FieldColor', [
				'label' => __('plugins.themes.sanguline.option.colour.label'),
				'description' => __('plugins.themes.sanguline.option.colour.description'),
				'default' => '#1E6292',
			]);

			$this->addOption('showDescriptionInJournalIndex', 'FieldOptions', [
				'label' => __('manager.setup.contextSummary'),
				'options' => [
					[
						'value' => true,
						'label' => __('plugins.themes.sanguline.option.showDescriptionInJournalIndex.option'),
					],
				],
				'default' => false,
			]);

			$this->addOption('useHomepageImageAsHeader', 'FieldOptions', [
				'label' => __('plugins.themes.sanguline.option.useHomepageImageAsHeader.label'),
				'description' => __('plugins.themes.sanguline.option.useHomepageImageAsHeader.description'),
				'options' => [
					[
						'value' => true,
						'label' => __('plugins.themes.sanguline.option.useHomepageImageAsHeader.option'),
					],
				],
				'default' => false,
			]);

			$this->addOption('displayStats', 'FieldOptions', [
				'type' => 'radio',
				'label' => __('plugins.themes.sanguline.option.displayStats.label'),
				'options' => [
					[
						'value' => 'none',
						'label' => __('plugins.themes.sanguline.option.displayStats.none'),
					],
					[
						'value' => 'bar',
						'label' => __('plugins.themes.sanguline.option.displayStats.bar'),
					],
					[
						'value' => 'line',
						'label' => __('plugins.themes.sanguline.option.displayStats.line'),
					],
				],
				'default' => 'none',
			]);

			$this->addOption('homepageImageWidth', 'FieldOptions', [
				'type' => 'radio',
				'label' => __('plugins.themes.sanguline.option.homepageImageWidth.label'),
				'description' => __('plugins.themes.sanguline.option.homepageImageWidth.description'),
				'options' => [
					[
						'value' => '30',
						'label' => __('plugins.themes.sanguline.option.homepageImageWidth.small'),
					],
					[
						'value' => '40',
						'label' => __('plugins.themes.sanguline.option.homepageImageWidth.medium'),
					],
					[
						'value' => '50',
						'label' => __('plugins.themes.sanguline.option.homepageImageWidth.large'),
					],
				],
				'default' => '40',
			]);

			$this->addOption('headerLogoSize', 'FieldOptions', [
				'type' => 'radio',
				'label' => __('plugins.themes.sanguline.option.headerLogoSize.label'),
				'description' => __('plugins.themes.sanguline.option.headerLogoSize.description'),
				'options' => [
					[
						'value' => '60',
						'label' => __('plugins.themes.sanguline.option.headerLogoSize.small'),
					],
					[
						'value' => '80',
						'label' => __('plugins.themes.sanguline.option.headerLogoSize.medium'),
					],
					[
						'value' => '100',
						'label' => __('plugins.themes.sanguline.option.headerLogoSize.large'),
					],
					[
						'value' => '120',
						'label' => __('plugins.themes.sanguline.option.headerLogoSize.xlarge'),
					],
				],
				'default' => '80',
			]);

			$this->addStyle('stylesheet', 'styles/index.less');

			$additionalLessVariables = [];

			if ($this->getOption('typography') === 'notoSerif') {
				$this->addStyle('font', 'styles/fonts/notoSerif.less');
				$additionalLessVariables[] = '@font: "Noto Serif", -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen-Sans", "Ubuntu", "Cantarell", "Helvetica Neue", sans-serif;';
			} elseif (strpos($this->getOption('typography'), 'notoSerif') !== false) {
				$this->addStyle('font', 'styles/fonts/notoSans_notoSerif.less');
				if ($this->getOption('typography') == 'notoSerif_notoSans') {
					$additionalLessVariables[] = '@font-heading: "Noto Serif", serif;';
				} elseif ($this->getOption('typography') == 'notoSans_notoSerif') {
					$additionalLessVariables[] = '@font: "Noto Serif", serif;@font-heading: "Noto Sans", serif;';
				}
			} elseif ($this->getOption('typography') == 'lato') {
				$this->addStyle('font', 'styles/fonts/lato.less');
				$additionalLessVariables[] = '@font: Lato, sans-serif;';
			} elseif ($this->getOption('typography') == 'lora') {
				$this->addStyle('font', 'styles/fonts/lora.less');
				$additionalLessVariables[] = '@font: Lora, serif;';
			} elseif ($this->getOption('typography') == 'lora_openSans') {
				$this->addStyle('font', 'styles/fonts/lora_openSans.less');
				$additionalLessVariables[] = '@font: "Open Sans", sans-serif;@font-heading: Lora, serif;';
			} else {
				$this->addStyle('font', 'styles/fonts/notoSans.less');
			}

			$baseColour = $this->getOption('baseColour');
			if (!$baseColour || !preg_match('/^#[0-9a-fA-F]{3,6}$/', $baseColour)) {
				$baseColour = '#1E6292';
			}

			$additionalLessVariables[] = '@bg-base:' . $baseColour . ';';
			$additionalLessVariables[] = '@primary:' . $baseColour . ';';
			$additionalLessVariables[] = '@primary-lift:' . $this->adjustBrightness($baseColour, 20) . ';';

			if (!$this->isColourDark($baseColour)) {
				$additionalLessVariables[] = '@text-bg-base:rgba(0,0,0,0.84);';
				$additionalLessVariables[] = '@bg-base-border-color:rgba(0,0,0,0.2);';
			}

			if (!empty($additionalLessVariables)) {
				$this->modifyStyle('stylesheet', ['addLessVariables' => join("\n", $additionalLessVariables)]);
			}

			$request = Application::get()->getRequest();

			$this->addStyle(
				'fontAwesome',
				$request->getBaseUrl() . '/lib/pkp/styles/fontawesome/fontawesome.css',
				['baseUrl' => '']
			);

			$context = $request->getContext();
			if ($context && $this->getOption('useHomepageImageAsHeader')) {
				$homepageImage = $context->getLocalizedData('homepageImage');
				if ($homepageImage && !empty($homepageImage['uploadName'])) {
					$publicFileManager = new PublicFileManager();
					$publicFilesDir = $request->getBaseUrl() . '/' . $publicFileManager->getContextFilesPath($context->getId());
					$homepageImageUrl = $publicFilesDir . '/' . $homepageImage['uploadName'];

					$this->addStyle(
						'homepageImage',
						'.pkp_structure_head { background: center / cover no-repeat url("' . $homepageImageUrl . '");}',
						['inline' => true]
					);
				}
			}

			$homepageImageWidth = $this->getOption('homepageImageWidth');
			if ($homepageImageWidth) {
				$this->addStyle(
					'homepageImageWidth',
					':root { --homepage-image-width: ' . $homepageImageWidth . '%; }',
					['inline' => true]
				);
			}

			$this->addStyle(
				'sidebarNavBlock',
				'.block_sidebar_nav .pkp_nav_list li { display: block; }',
				['inline' => true]
			);

			$headerLogoSize = $this->getOption('headerLogoSize');
			if ($headerLogoSize) {
				$this->addStyle(
					'headerLogoSize',
					'.pkp_site_name .is_img img { max-height: ' . $headerLogoSize . 'px; width: auto; } .pkp_site_name_wrapper { min-height: ' . ((int) $headerLogoSize + 20) . 'px; }',
					['inline' => true]
				);
			}

			$min = Config::getVar('general', 'enable_minified') ? '.min' : '';
			$jquery = $request->getBaseUrl() . '/lib/pkp/lib/vendor/components/jquery/jquery' . $min . '.js';
			$jqueryUI = $request->getBaseUrl() . '/lib/pkp/lib/vendor/components/jqueryui/jquery-ui' . $min . '.js';
			$this->addScript('jQuery', $jquery, ['baseUrl' => '']);
			$this->addScript('jQueryUI', $jqueryUI, ['baseUrl' => '']);

			$this->addScript('popper', 'js/lib/popper/popper.js');
			$this->addScript('bsUtil', 'js/lib/bootstrap/util.js');
			$this->addScript('bsDropdown', 'js/lib/bootstrap/dropdown.js');
			$this->addScript('default', 'js/main.js');
			$this->addScript('announcementSlider', 'js/announcement-slider.js');

			$this->addMenuArea(['primary', 'user', 'sidebar']);
		}

		/**
		 * Get the name of the settings file to be installed on new journal
		 * creation.
		 *
		 * @return string
		 */
		function getContextSpecificPluginSettingsFile() {
			return $this->getPluginPath() . '/settings.xml';
		}

		/**
		 * @copydoc ThemePlugin::saveOption()
		 */
		public function saveOption($name, $value, $contextId = null) {
			if ($name == 'baseColour' && !preg_match('/^#[0-9a-fA-F]{3,6}$/', $value)) {
				$value = null;
			}

			parent::saveOption($name, $value, $contextId);
		}

		/**
		 * Get the name of the settings file to be installed site-wide when OJS
		 * is installed.
		 *
		 * @return string
		 */
		function getInstallSitePluginSettingsFile() {
			return $this->getPluginPath() . '/settings.xml';
		}

		/**
		 * Map OJS 3.3 locale keys to the locale folders bundled with this theme.
		 *
		 * @param string $locale
		 * @return array
		 */
		public function getLocaleFilename($locale) {
			$localeFiles = [];

			foreach ($this->getLocaleCandidates($locale) as $candidate) {
				$localePath = $this->getPluginPath() . '/locale/' . $candidate . '/locale.po';
				if (file_exists($localePath)) {
					$localeFiles[] = $localePath;
					break;
				}
			}

			foreach ($this->getLocaleCandidates(MASTER_LOCALE) as $candidate) {
				$localePath = $this->getPluginPath() . '/locale/' . $candidate . '/locale.po';
				if (file_exists($localePath)) {
					$localeFiles[] = $localePath;
					break;
				}
			}

			return array_values(array_unique($localeFiles));
		}

		/**
		 * OJS 3.3 does not provide the same usage stats chart integration used by
		 * the OJS 3.4 version of this theme.
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
		function getDisplayName() {
			return __('plugins.themes.sanguline.name');
		}

		/**
		 * Get the description of this plugin.
		 *
		 * @return string
		 */
		function getDescription() {
			return __('plugins.themes.sanguline.description');
		}

		/**
		 * Adjust the brightness of a hex colour.
		 *
		 * @param string $hex
		 * @param int $steps
		 * @return string
		 */
		protected function adjustBrightness($hex, $steps) {
			$hex = ltrim($hex, '#');

			if (strlen($hex) === 3) {
				$hex = preg_replace('/(.)/', '$1$1', $hex);
			}

			if (strlen($hex) !== 6) {
				$hex = '1E6292';
			}

			$r = hexdec(substr($hex, 0, 2));
			$g = hexdec(substr($hex, 2, 2));
			$b = hexdec(substr($hex, 4, 2));

			$r = max(0, min(255, $r + $steps));
			$g = max(0, min(255, $g + $steps));
			$b = max(0, min(255, $b + $steps));

			return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
		}

		/**
		 * Build locale candidates for OJS 3.3 locale keys.
		 *
		 * @param string $locale
		 * @return array
		 */
		protected function getLocaleCandidates($locale) {
			$aliases = [
				'ar_IQ' => 'ar',
				'bs_BA' => 'bs',
				'ca_ES' => 'ca',
				'cs_CZ' => 'cs',
				'da_DK' => 'da',
				'de_DE' => 'de',
				'en_US' => 'en',
				'es_ES' => 'es',
				'fa_IR' => 'fa',
				'fi_FI' => 'fi',
				'hu_HU' => 'hu',
				'id_ID' => 'id',
				'it_IT' => 'it',
				'ja_JP' => 'ja',
				'ka_GE' => 'ka',
				'ko_KR' => 'ko',
				'ku_IQ' => 'ckb',
				'mk_MK' => 'mk',
				'nb_NO' => 'nb',
				'nl_NL' => 'nl',
				'pl_PL' => 'pl',
				'ro_RO' => 'ro',
				'ru_RU' => 'ru',
				'sk_SK' => 'sk',
				'sl_SI' => 'sl',
				'sr_RS@latin' => 'sr@latin',
				'sv_SE' => 'sv',
				'tr_TR' => 'tr',
				'uk_UA' => 'uk',
				'vi_VN' => 'vi',
				'zh_TW' => 'zh_Hant',
			];

			$candidates = [$locale];

			if (isset($aliases[$locale])) {
				$candidates[] = $aliases[$locale];
			}

			if (strpos($locale, '_') !== false) {
				$candidates[] = substr($locale, 0, strpos($locale, '_'));
			}

			if (strpos($locale, '@') !== false) {
				$candidates[] = substr($locale, 0, strpos($locale, '@'));
			}

			return array_values(array_unique(array_filter($candidates)));
		}
	}
}
