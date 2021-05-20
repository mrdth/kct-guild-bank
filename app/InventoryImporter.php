<?php


namespace App;

use App\Jobs\ImportItemJob;
use App\Models\Character;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryImporter
{
    public static function import(object $import_data)
    {
        static::createOrUpdateCharacter($import_data->character);
        static::importInventory($import_data);
    }

    public static function createOrUpdateCharacter($character_data)
    {
        $character = Character::firstOrNew(['name' => $character_data->name]);
        $character->currency = $character_data->currency;
        $character->save();
    }

    public static function importInventory(object $import_data)
    {
        $character = Character::where(['name' => $import_data->character->name])->first();

        $character->inventory()->detach();

        collect($import_data->inventory)->each(
            function ($inventory_item) use ($character) {
                $suffix = static::parseSuffixFromItemLink($inventory_item->itemLink);
                static::insertOrUpdateCharacterItem($character, $inventory_item);
                if (!static::checkItemExists($inventory_item->id)) {
                    ImportItemJob::dispatch($inventory_item->id, $suffix);
                }
            }
        );
    }

    private static function insertOrUpdateCharacterItem(Character $character, $inventory_item)
    {
        $owned = DB::table('character_item')
            ->where(
                [
                    'character_id' => $character->id,
                    'item_id' => $inventory_item->id,
                ]
            )->first();

        if ($owned) {

            $owned->quantity += $inventory_item->quantity;
            DB::update(
                'update character_item set quantity = ? where character_id = ? and item_id = ?',
                [$owned->quantity, $owned->character_id, $owned->item_id]
            );

        } else {
            DB::table('character_item')->insert(
                [
                    'character_id' => $character->id,
                    'item_id' => $inventory_item->id,
                    'quantity' => $inventory_item->quantity,
                ]
            );
        }
    }

    private static function checkItemExists($id):bool
    {
        return Item::whereId($id)->count() > 0;
    }

    public static function parseSuffixFromItemLink($itemLink)
    {
        return (explode(':', Str::between($itemLink, 'Hitem:', ':|h')))[6];
    }
}
