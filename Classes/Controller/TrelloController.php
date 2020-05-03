<?php
declare(strict_types=1);
namespace Crontis\TrelloIntegration\Controller;

/**
 * This file is part of the "trello_integration" Extension for TYPO3 CMS.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TrelloPhp\Client;
use TrelloPhp\Requests\Lists\GetCardsInAList;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

Class TrelloController extends ActionController
{
    /**
     * @var FrontendInterface
     */
    private $cache;

    /**
     * @var ExtensionConfiguration
     */
    private $extensionConfiguration;

    /**
     * @var Client
     */
    private $client;

    public function __construct(FrontendInterface $cache, ExtensionConfiguration $extensionConfiguration)
    {
        $this->cache = $cache;
        $this->extensionConfiguration = $extensionConfiguration;
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
            $this->cache->set('list-' . $listId , $cards, [], 1800);
        }

        $this->view->assign('cards', $cards);

        return $this->view->render();
    }
}
