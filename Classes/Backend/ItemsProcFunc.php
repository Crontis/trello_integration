<?php

declare(strict_types=1);

/*
 * This file is part of the package crontis/trello_integration.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Crontis\TrelloIntegration\Backend;

use TrelloPhp\Client;
use TrelloPhp\Requests\Boards\GetListsOnABoard;
use TrelloPhp\Requests\Members\GetMemberBoardsRequest;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

@include 'phar://' . ExtensionManagementUtility::extPath('trello_integration') . 'Libraries/trello-php.phar/vendor/autoload.php';

class ItemsProcFunc
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        /** @var ExtensionConfiguration $extensionConfiguration */
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $this->client = new Client(
            $extensionConfiguration->get('trello_integration', 'apiKey'),
            $extensionConfiguration->get('trello_integration', 'apiToken')
        );
    }

    public function getBoards(array &$config): void
    {
        $boards = $this->client->send(new GetMemberBoardsRequest());
        foreach ($boards as $board) {
            $config['items'][] = [
                $board['name'], $board['id']
            ];
        }
    }

    public function getLists(array &$config): void
    {
        $boardId = $config['row']['settings.boardId'];

        // On Plugin creation on change will return a string instead of an array. Don't know why.
        if (is_array($boardId)) {
            $boardId = $boardId[0];
        }

        if (!$boardId) {
            return;
        }

        $lists = $this->client->send(new GetListsOnABoard($boardId));
        foreach ($lists as $list) {
            $config['items'][] = [
                $list['name'], $list['id']
            ];
        }
    }
}
