<?php

namespace Tests\Unit;

use App\Jobs\ImportItemJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class InventoryImporter extends TestCase
{
    Use RefreshDatabase;

    protected $inventory_data;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->inventory_data = json_decode(file_get_contents(__DIR__ . '/../Data/inventory.json'));
    }

    public function test_it_can_create_characters()
    {
        \App\InventoryImporter::createOrUpdateCharacter($this->inventory_data->character);

        $this->assertDatabaseCount('characters', 1);
        $this->assertDatabaseHas('characters', [
            'name' => 'Sethkar',
            'currency' => 205175
        ]);
    }

    public function test_it_can_update_a_characters_inventory()
    {
        Queue::fake();
        \App\InventoryImporter::createOrUpdateCharacter($this->inventory_data->character);
        \App\InventoryImporter::importInventory($this->inventory_data);

        $this->assertDatabaseCount('character_item', 27);
    }

    public function test_it_imports_unknown_items()
    {
        Queue::fake();
        Queue::assertNothingPushed();

        \App\InventoryImporter::createOrUpdateCharacter($this->inventory_data->character);
        \App\InventoryImporter::importInventory($this->inventory_data);

        Queue::assertPushed(ImportItemJob::class, 31);
    }

}
