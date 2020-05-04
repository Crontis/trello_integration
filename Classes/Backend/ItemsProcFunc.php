<?php
declare(strict_types=1);
namespace Crontis\TrelloIntegration\Backend;

/**
 * This file is part of the "trello_integration" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TrelloPhp\Client;
use TrelloPhp\Requests\Boards\GetListsOnABoard;
use TrelloPhp\Requests\Members\GetMemberBoardsRequest;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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

    public function getBoards(array &$config)
    {
        $boards = $this->client->send(new GetMemberBoardsRequest());
        foreach ($boards as $board) {
            $config['items'][] = [
                $board['name'], $board['id']
            ];
        }
    }

    public function getLists(array &$config)
    {
        $boardId = $config['row']['settings.boardId'];

        # On Plugin creation on change will return a string instead of an array. Don't know why.
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
