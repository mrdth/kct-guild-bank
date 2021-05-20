<?php


namespace App;

use App\Models\Item;
use Illuminate\Support\Facades\Http;

class ItemImporter
{
     public static function import(int $id, $suffix)
    {
        $wowhead_info = static::extractItemFromXml(static::fetchXmlForItem($id));
        $item = array_merge($wowhead_info, ['suffix' => $suffix]);
        Item::create($item);
    }

    public static function fetchXmlForItem(int $id)
    {
        $response = Http::get("https://tbc.wowhead.com/item=$id&xml");

        return $response->body();
    }

    public static function extractItemFromXml($xml_string)
    {
        // Quick & dirty convert XML string to array
        $xml = simplexml_load_string($xml_string, 'SimpleXMLElement', LIBXML_NOCDATA);
        $item = json_decode(json_encode($xml),TRUE);

        return [
            'id' => $item['item']['@attributes']['id'],
            'name' => $item['item']['name'],
            'icon' => $item['item']['icon'],
            'quality' => $item['item']['quality'],
            'class' => $item['item']['class'],
            'sub_class' => $item['item']['subclass'],
        ];
    }
}
