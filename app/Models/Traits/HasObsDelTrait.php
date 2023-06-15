<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Schema;

trait HasObsDelTrait
{
    public function initializeHasObsDel()
    {
        $this->append('hasObsDel');
    }

    public function GetHasObsDelAttribute(){
        return Schema::hasColumn($this->table, 'obsDel');
    }
}
