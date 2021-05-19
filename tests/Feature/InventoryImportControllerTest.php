<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class InventoryImportControllerTest extends TestCase
{
    Use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_can_import_an_inventory()
    {
        Queue::fake();
        $this->withoutExceptionHandling();
        $inventory = file_get_contents(__DIR__ . '/../Data/inventory.json');

        $response = $this->withHeader('Authorization', 'Bearer ' . config('app.api_token'))
            ->postJson('/api/import', ['EncodedImportString' => base64_encode($inventory)]);

        $response->assertStatus(204);
    }
}
