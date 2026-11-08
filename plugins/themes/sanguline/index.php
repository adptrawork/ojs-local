<?php

/**
 * @defgroup plugins_themes_sanguline Sanguline theme plugin
 */

/**
 * @file plugins/themes/Sanguline/index.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_themes_sanguline
 * @brief Wrapper for Sanguline theme plugin.
 *
 */

require_once('SangulineThemePlugin.inc.php');

return new SangulineThemePlugin();
