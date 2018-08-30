<?php
/**
 * Bakkerij (https://github.com/bakkerij)
 * Copyright (c) https://github.com/bakkerij
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) https://github.com/bakkerij
 * @link          https://github.com/bakkerij Bakkerij Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Fholznagel\Notifier\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Fholznagel\Notifier\Model\Table\NotificationsTable;
use Fholznagel\Notifier\Utility\NotificationManager;

/**
 * Notifier\Model\Table\NotificationsTable Test Case
 */
class NotificationsTableTest extends TestCase
{
    
    public $fixtures = [
        'plugin.Fholznagel\Notifier.notifications',
    ];

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testEntity()
    {
        /**
         * @var NotificationsTable
         */
        $notifications = TableRegistry::get('Fholznagel/Notifier.Notifications');

        NotificationManager::instance()->addTemplate('newNotification', [
            'title' => 'New Notification',
            'body' => ':from has sent :to a notification about :about'
        ]);

        $notify = NotificationManager::instance()->notify([
            'users' => 1,
            'template' => 'newNotification',
            'vars' => [
                'from' => 'Bob',
                'to' => 'Leonardo',
                'about' => 'Programming Stuff'
            ]
        ]);

        $entity = $notifications->get(2);

        $this->assertEquals('newNotification', $entity->template);
        $this->assertEquals('New Notification', $entity->title);
        $this->assertEquals('Bob has sent Leonardo a notification about Programming Stuff', $entity->body);
    }
}
