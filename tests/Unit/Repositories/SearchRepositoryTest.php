<?php namespace Tests\Unit\Repositories;

use App\Correios\CorreiosJunior;
use App\Models\Role;
use App\Repositories\RoleRepository;
use App\Repositories\SearchRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SearchRepositoryTest extends TestCase
{
    /**
     * @var RoleRepository
     */
    protected $searchRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->searchRepo = \App::make(SearchRepository::class);
    }

    public function test_buscaCep()
    {
        $correios = new CorreiosJunior();
        $resp = $this->searchRepo->buscaCep($correios, '14404-090');

        $this->assertNotEmpty($resp);
        $resp = json_decode($resp);
        $this->assertEquals('Franca', $resp->cidade);
    }
}
