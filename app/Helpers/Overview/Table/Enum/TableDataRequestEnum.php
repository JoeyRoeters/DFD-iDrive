<?php

namespace App\Helpers\Overview\Table\Enum;

use App\Helpers\Overview\Table\ValueObject\TableDataRequest;

enum TableDataRequestEnum
{
    case DRAW; // Draw counter. This is used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables (Ajax requests are asynchronous and thus can return out of sequence). This is used as part of the draw return parameter (see below).
    case START; // Paging first record indicator. This is the start point in the current data set (0 index based - i.e. 0 is the first record).
    case LENGTH; // Number of records that the table can display in the current draw. It is expected that the number of records returned will be equal to this number, unless the server has fewer records to return. Note that this can be -1 to indicate that all records should be returned (although that negates any benefits of server-side processing!)
    case SEARCH_VALUE; // Global search value. To be applied to all columns which have searchable as true.
    case SEARCH_REGEX; // true if the global filter should be treated as a regular expression for advanced searching, false otherwise.
    case ORDER; // Column to which ordering should be applied. This is an index reference to the columns array of information that is also submitted to the server.
    case COLUMNS; // Information for DataTables to use for rendering.
    case OFFSET; // Offset of the query result of (START - 1) * LENGTH

    public function value(): string
    {
        return match ($this) {
            self::DRAW => 'draw',
            self::START => 'start',
            self::LENGTH => 'length',
            self::ORDER => 'order',
            self::SEARCH_VALUE => 'search.value',
            self::SEARCH_REGEX => 'search.regex',
            self::COLUMNS => 'columns',
            self::OFFSET => throw new \Exception('Offset is not a valid request parameter'),
        };
    }

    public function cast(TableDataRequest $tableDataRequest): mixed
    {
        return match ($this) {
            self::DRAW => (int) $tableDataRequest->get($this->value()),
            self::START => (int) $tableDataRequest->get($this->value()),
            self::LENGTH => (int) $tableDataRequest->get($this->value()),
            self::ORDER => (array) $tableDataRequest->get($this->value()),
            self::SEARCH_VALUE => (string) $tableDataRequest->get('search')['value'],
            self::SEARCH_REGEX => (bool) $tableDataRequest->get($this->value()),
            self::COLUMNS => (array) $tableDataRequest->get($this->value()),
            self::OFFSET => (self::START->cast($tableDataRequest) - 1) * self::LENGTH->cast($tableDataRequest),
        };
    }
}
