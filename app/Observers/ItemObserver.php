<?php

namespace App\Observers;

use App\Item;

class ItemObserver
{
    /**
     * Handle the item "saving" event.
     *
     * @param  \App\Item  $item
     * @return void
     */
    public function saving(Item $item)
    {
        $item->meta = json_encode($item->getMeta());
    }
}
