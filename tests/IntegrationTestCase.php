<?php

namespace tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class IntegrationTestCase extends WebTestCase
{
    /** @var Client */
    private $client;

    /** @var ContainerInterface */
    private $container;

    /**
     * @return Client
     */
    protected function client()
    {
        return $this->client;
    }

    /**
     * @return ContainerInterface
     */
    protected function container()
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->client    = $this->createClient();
        $this->container = $this->client->getContainer();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        $this->container = null;
        $this->client    = null;

        parent::tearDown();
    }

    protected function restoreDatabase()
    {
        $backup = $this->container()->get('lucaszz.doctrine_database_backup');

        if (!$backup->isCreated()) {
            $backup->clearDatabase();
            $backup->create();
        }

        $backup->restore();
    }
}
