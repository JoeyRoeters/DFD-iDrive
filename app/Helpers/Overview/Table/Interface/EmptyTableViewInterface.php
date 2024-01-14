<?php

namespace App\Helpers\Overview\Table\Interface;

use App\Helpers\Overview\Table\ValueObject\EmptyViewValueObject;

interface EmptyTableViewInterface
{
    public function isEmpty(): bool;

    public function getEmptyViewValueObject(): EmptyViewValueObject;
}
