<?php

namespace App\Jobs;

use App\ItemImporter;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportItemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $item_id;
    public string $suffix;

    public function __construct($item_id, $suffix)
    {
        $this->item_id = $item_id;
        $this->suffix = $suffix;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->checkItemExists()) {
            return;
        }

        ItemImporter::import($this->item_id, $this->suffix);

        // Wait 2 seconds before ending so we rate limit hitting wowhead
        sleep(1);
    }

    private function checkItemExists(): bool
    {
        return Item::whereId($this->item_id)->count() > 0;
    }
}
