<?php

namespace Tests\Feature;

use App\ItemImporter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ItemImporterTest extends TestCase
{
    Use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_can_import_an_item()
    {
        Http::fake(
            [
                'www.wowhead.com/*' => Http::response(
                    file_get_contents(__DIR__ . '/../Data/wowhead_item.xml'),
                    200,
                    [
                        'content-type' => 'application/xml; charset=UTF-8'
                    ]
                )
            ]
        );

        ItemImporter::import(20960);

        $this->assertDatabaseCount('items', 1);

        $this->assertDatabaseHas('items', [
            'name' => 'Engraved Truesilver Ring',
        ]);
    }
}
