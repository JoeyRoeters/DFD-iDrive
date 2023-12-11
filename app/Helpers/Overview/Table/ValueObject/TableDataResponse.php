<?php

namespace App\Helpers\Overview\Table\ValueObject;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TableDataResponse extends JsonResponse
{
    public function __construct(
        private int $draw,
        private int $recordsTotal,
        private int $recordsFiltered,
        private array $records
    ) {
        parent::__construct(
            [
                'draw' => $this->draw,
                'recordsTotal' => $this->recordsTotal,
                'recordsFiltered' => $this->recordsFiltered,
                'data' => $this->records,
            ],
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
