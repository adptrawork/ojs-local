<?php

/**
 * @file plugins/themes/sanguline/SangulineThemePlugin.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class SangulineThemePlugin
 *
 * @brief Sanguline theme
 */

namespace APP\plugins\themes\sanguline;

use APP\core\Application;
use APP\file\PublicFileManager;
use PKP\config\Config;
use PKP\session\SessionManager;

class SangulineThemePlugin extends \PKP\plugins\ThemePlugin
{
    /**
     * @copydoc ThemePlugin::isActive()
     */
    public function isActive()
    {
        if (SessionManager::isDisabled()) {
            return true;
        }
        return parent::isActive();
    }

    /**
     * Initialize the theme's styles, scripts and hooks. This is run on the
     * currently active theme and it's parent themes.
     *
     */
    public function init()
    {
        // Register theme options
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
                    'label' => __('plugins.themes.sanguline.option.useHomepageImageAsHeader.option')
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

        // Homepage image width option
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

        // Sanguline - Sidebar navigation display is now always block (removed from admin)

        // Header logo size option
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


        // Load primary stylesheet
        $this->addStyle('stylesheet', 'styles/index.less');

        // Store additional LESS variables to process based on options
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

        // Update colour based on theme option - Sanguline: sync @primary with @bg-base
        $baseColour = $this->getOption('baseColour');
        if (!$baseColour || !preg_match('/^#[0-9a-fA-F]{1,6}$/', $baseColour)) {
            $baseColour = '#1E6292'; // Default color
        }
        
        // Always set both @bg-base and @primary to ensure consistent theming
        $additionalLessVariables[] = '@bg-base:' . $baseColour . ';';
        $additionalLessVariables[] = '@primary:' . $baseColour . ';';
        $additionalLessVariables[] = '@primary-lift:' . $this->adjustBrightness($baseColour, 20) . ';';
        
        if (!$this->isColourDark($baseColour)) {
            $additionalLessVariables[] = '@text-bg-base:rgba(0,0,0,0.84);';
            $additionalLessVariables[] = '@bg-base-border-color:rgba(0,0,0,0.2);';
        }

        // Pass additional LESS variables based on options
        if (!empty($additionalLessVariables)) {
            $this->modifyStyle('stylesheet', ['addLessVariables' => join("\n", $additionalLessVariables)]);
        }

        $request = Application::get()->getRequest();

        // Load icon font FontAwesome - http://fontawesome.io/
        $this->addStyle(
            'fontAwesome',
            $request->getBaseUrl() . '/lib/pkp/styles/fontawesome/fontawesome.css',
            ['baseUrl' => '']
        );

        // Get homepage image and use as header background if useAsHeader is true
        $context = Application::get()->getRequest()->getContext();
        if ($context && $this->getOption('useHomepageImageAsHeader') && ($homepageImage = $context->getLocalizedData('homepageImage'))) {
            $publicFileManager = new PublicFileManager();
            $publicFilesDir = $request->getBaseUrl() . '/' . $publicFileManager->getContextFilesPath($context->getId());
            $homepageImageUrl = $publicFilesDir . '/' . $homepageImage['uploadName'];

            $this->addStyle(
                'homepageImage',
                '.pkp_structure_head { background: center / cover no-repeat url("' . $homepageImageUrl . '");}',
                ['inline' => true]
            );
        }

        // Apply homepage image width from theme option
        $homepageImageWidth = $this->getOption('homepageImageWidth');
        if ($homepageImageWidth) {
            $this->addStyle(
                'homepageImageWidth',
                ':root { --homepage-image-width: ' . $homepageImageWidth . '%; }',
                ['inline' => true]
            );
        }

        // Sanguline - Sidebar navigation always uses block display
        $this->addStyle(
            'sidebarNavBlock',
            '.block_sidebar_nav .pkp_nav_list li { display: block; }',
            ['inline' => true]
        );

        // Apply header logo size option
        $headerLogoSize = $this->getOption('headerLogoSize');
        if ($headerLogoSize) {
            $this->addStyle(
                'headerLogoSize',
                '.pkp_site_name .is_img img { max-height: ' . $headerLogoSize . 'px; width: auto; } .pkp_site_name_wrapper { min-height: ' . ($headerLogoSize + 20) . 'px; }',
                ['inline' => true]
            );
        }

        // Load jQuery from a CDN or, if CDNs are disabled, from a local copy.
        $min = Config::getVar('general', 'enable_minified') ? '.min' : '';
        $jquery = $request->getBaseUrl() . '/lib/pkp/lib/vendor/components/jquery/jquery' . $min . '.js';
        $jqueryUI = $request->getBaseUrl() . '/lib/pkp/lib/vendor/components/jqueryui/jquery-ui' . $min . '.js';
        // Use an empty `baseUrl` argument to prevent the theme from looking for
        // the files within the theme directory
        $this->addScript('jQuery', $jquery, ['baseUrl' => '']);
        $this->addScript('jQueryUI', $jqueryUI, ['baseUrl' => '']);

        // Load Bootsrap's dropdown
        $this->addScript('popper', 'js/lib/popper/popper.js');
        $this->addScript('bsUtil', 'js/lib/bootstrap/util.js');
        $this->addScript('bsDropdown', 'js/lib/bootstrap/dropdown.js');

        // Load custom JavaScript for this theme
        $this->addScript('default', 'js/main.js');
        
        // Sanguline - Announcement slider for homepage
        $this->addScript('announcementSlider', 'js/announcement-slider.js');

        // Add navigation menu areas for this theme
        $this->addMenuArea(['primary', 'user', 'sidebar']);
    }

    /**
     * Get the name of the settings file to be installed on new journal
     * creation.
     *
     * @return string
     */
    public function getContextSpecificPluginSettingsFile()
    {
        return $this->getPluginPath() . '/settings.xml';
    }

    /** @see ThemePlugin::saveOption */
    public function saveOption($name, $value, $contextId = null) {
        // Validate the base colour setting value.
        if ($name == 'baseColour' && !preg_match('/^#[0-9a-fA-F]{1,6}$/', $value)) $value = null; // pkp/pkp-lib#11974

        parent::saveOption($name, $value, $contextId);
    }

    /**
     * Get the name of the settings file to be installed site-wide when
     * OJS is installed.
     *
     * @return string
     */
    public function getInstallSitePluginSettingsFile()
    {
        return $this->getPluginPath() . '/settings.xml';
    }

    /**
     * Get the display name of this plugin
     *
     * @return string
     */
    public function getDisplayName()
    {
        return __('plugins.themes.sanguline.name');
    }

    /**
     * Get the description of this plugin
     *
     * @return string
     */
    public function getDescription()
    {
        return __('plugins.themes.sanguline.description');
    }

    /**
     * Adjust the brightness of a hex colour
     *
     * @param string $hex Hex colour code
     * @param int $steps Steps to adjust brightness (-255 to 255)
     * @return string Adjusted hex colour
     */
    protected function adjustBrightness($hex, $steps)
    {
        $hex = str_replace('#', '', $hex);
        
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));
        
        return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
    }
}

if (!PKP_STRICT_MODE) {
    class_alias('\APP\plugins\themes\sanguline\SangulineThemePlugin', '\SangulineThemePlugin');
}
