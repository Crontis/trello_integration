<?php
defined('TYPO3_MODE') || die();

/**
 * This file is part of the "trello_integration" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'trello_integration',
    'Configuration/TypoScript',
    'Trello Integration'
);
