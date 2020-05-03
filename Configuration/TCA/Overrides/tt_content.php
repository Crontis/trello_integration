<?php
defined('TYPO3_MODE') || die();

/**
 * This file is part of the "trello_integration" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Crontis.TrelloIntegration',
    'ShowCardsOnList',
    'Show cards on a specific list'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['trellointegration_showcardsonlist'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'trellointegration_showcardsonlist',
    'FILE:EXT:trello_integration/Configuration/FlexForms/ShowCardsOnList.xml'
);
