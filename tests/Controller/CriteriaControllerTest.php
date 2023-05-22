<?php

namespace App\Test\Controller;

use App\Entity\Criteria;
use App\Repository\CriteriaRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CriteriaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CriteriaRepository $repository;
    private string $path = '/criteria/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Criteria::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Criterion index');

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
            'criterion[smoking]' => 'Testing',
            'criterion[animals]' => 'Testing',
            'criterion[womenOnly]' => 'Testing',
            'criterion[manOnly]' => 'Testing',
        ]);

        self::assertResponseRedirects('/criteria/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Criteria();
        $fixture->setSmoking('My Title');
        $fixture->setAnimals('My Title');
        $fixture->setWomenOnly('My Title');
        $fixture->setManOnly('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Criterion');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Criteria();
        $fixture->setSmoking('My Title');
        $fixture->setAnimals('My Title');
        $fixture->setWomenOnly('My Title');
        $fixture->setManOnly('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'criterion[smoking]' => 'Something New',
            'criterion[animals]' => 'Something New',
            'criterion[womenOnly]' => 'Something New',
            'criterion[manOnly]' => 'Something New',
        ]);

        self::assertResponseRedirects('/criteria/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSmoking());
        self::assertSame('Something New', $fixture[0]->getAnimals());
        self::assertSame('Something New', $fixture[0]->getWomenOnly());
        self::assertSame('Something New', $fixture[0]->getManOnly());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Criteria();
        $fixture->setSmoking('My Title');
        $fixture->setAnimals('My Title');
        $fixture->setWomenOnly('My Title');
        $fixture->setManOnly('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/criteria/');
    }
}
