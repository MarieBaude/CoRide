<?php

namespace App\Test\Controller;

use App\Entity\Ride;
use App\Repository\RideRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RideControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RideRepository $repository;
    private string $path = '/ride/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Ride::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ride index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'ride[departure]' => 'Testing',
            'ride[arrival]' => 'Testing',
            'ride[nbPlace]' => 'Testing',
            'ride[price]' => 'Testing',
            'ride[modelCar]' => 'Testing',
            'ride[createdAt]' => 'Testing',
            'ride[updatedAt]' => 'Testing',
            'ride[notes]' => 'Testing',
            'ride[user]' => 'Testing',
            'ride[criteria]' => 'Testing',
            'ride[fromPlace]' => 'Testing',
            'ride[toPlace]' => 'Testing',
        ]);

        self::assertResponseRedirects('/ride/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ride();
        $fixture->setDeparture('My Title');
        $fixture->setArrival('My Title');
        $fixture->setNbPlace('My Title');
        $fixture->setPrice('My Title');
        $fixture->setModelCar('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setNotes('My Title');
        $fixture->setUser('My Title');
        $fixture->setCriteria('My Title');
        $fixture->setFromPlace('My Title');
        $fixture->setToPlace('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Ride');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ride();
        $fixture->setDeparture('My Title');
        $fixture->setArrival('My Title');
        $fixture->setNbPlace('My Title');
        $fixture->setPrice('My Title');
        $fixture->setModelCar('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setNotes('My Title');
        $fixture->setUser('My Title');
        $fixture->setCriteria('My Title');
        $fixture->setFromPlace('My Title');
        $fixture->setToPlace('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'ride[departure]' => 'Something New',
            'ride[arrival]' => 'Something New',
            'ride[nbPlace]' => 'Something New',
            'ride[price]' => 'Something New',
            'ride[modelCar]' => 'Something New',
            'ride[createdAt]' => 'Something New',
            'ride[updatedAt]' => 'Something New',
            'ride[notes]' => 'Something New',
            'ride[user]' => 'Something New',
            'ride[criteria]' => 'Something New',
            'ride[fromPlace]' => 'Something New',
            'ride[toPlace]' => 'Something New',
        ]);

        self::assertResponseRedirects('/ride/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDeparture());
        self::assertSame('Something New', $fixture[0]->getArrival());
        self::assertSame('Something New', $fixture[0]->getNbPlace());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getModelCar());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getNotes());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getCriteria());
        self::assertSame('Something New', $fixture[0]->getFromPlace());
        self::assertSame('Something New', $fixture[0]->getToPlace());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Ride();
        $fixture->setDeparture('My Title');
        $fixture->setArrival('My Title');
        $fixture->setNbPlace('My Title');
        $fixture->setPrice('My Title');
        $fixture->setModelCar('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setNotes('My Title');
        $fixture->setUser('My Title');
        $fixture->setCriteria('My Title');
        $fixture->setFromPlace('My Title');
        $fixture->setToPlace('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/ride/');
    }
}
