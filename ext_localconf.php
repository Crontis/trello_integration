<?php
defined('TYPO3_MODE') || die();

/**
 * This file is part of the "trello_integration" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Crontis.TrelloIntegration',
    'ShowCardsOnList',
    [
        'Trello' => 'showCardsOfList'
    ]
);

if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['trellointegration_apicache'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['trellointegration_apicache'] = [];
}

$iconRegistry->registerIcon(
    'ext-trellointegration-icon',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:trello_integration/Resources/Public/Icons/Extension.svg']
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:trello_integration/Configuration/TSconfig/ContentElementWizard.tsconfig">'
);
