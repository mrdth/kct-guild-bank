<?php

namespace Tests\Unit;

use App\ItemImporter;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ItemImporterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_fetch_xml_from_wowhead()
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

        $xml = ItemImporter::fetchXmlForItem(20960);

        $this->assertIsString($xml);;

    }

    public function test_it_can_extract_item_data_from_wowhead_xml()
    {
        $xml = file_get_contents(__DIR__ . '/../Data/wowhead_item.xml');

        $item = ItemImporter::extractItemFromXml($xml);

        $this->assertIsArray($item);;

        foreach (['id', 'name', 'icon', 'quality', 'class', 'sub_class'] as $key) {
            $this->assertArrayHasKey($key, $item);
        }
    }
}
