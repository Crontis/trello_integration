<?php

declare(strict_types=1);

/*
 * This file is part of the package crontis/trello_integration.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Crontis\TrelloIntegration\Controller;

use TrelloPhp\Client;
use TrelloPhp\Requests\Lists\GetCardsInAList;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class TrelloController extends ActionController
{
    /**
     * @var FrontendInterface
     */
    private $cache;

    /**
     * @var Client
     */
    private $client;

    public function __construct(FrontendInterface $cache, ExtensionConfiguration $extensionConfiguration)
    {
        $this->cache = $cache;
        $this->client = new Client(
            $extensionConfiguration->get('trello_integration', 'apiKey'),
            $extensionConfiguration->get('trello_integration', 'apiToken')
        );
    }

    public function showCardsOfListAction(): string
    {
        $listId = $this->settings['listId'];

        if (!($cards = $this->cache->get('list-' . $listId))) {
            $cards = $this->client->send(new GetCardsInAList($listId));
            $this->cache->set('list-' . $listId, $cards, [], (int)$this->settings['expireCache'] ?: 900);
        }

        $this->view->assign('cards', $cards);

        return $this->view->render();
    }
}
