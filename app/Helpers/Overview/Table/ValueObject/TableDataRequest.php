<?php

namespace App\Helpers\Overview\Table\ValueObject;

use App\Helpers\Overview\Table\Enum\TableDataRequestEnum;
use Illuminate\Http\Request;

class TableDataRequest extends Request
{
    public function getTableValue(TableDataRequestEnum $dataRequestEnum): mixed
    {
        return $dataRequestEnum->cast($this);
    }

    public function isSearch(): bool
    {
        return !empty($this->getTableValue(TableDataRequestEnum::SEARCH_VALUE));
    }
}
