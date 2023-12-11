<?php

namespace App\Helpers\Overview\Table\ValueObject;

class TableConfiguration
{
    public function __construct(
        private bool $showHeaders = true,
        private bool $info = true,
        private bool $paging = true,
        private bool $searching = true,
        private bool $ordering = true,
        private int $pageLength = 10,

    )
    {
    }

    public function toArray(): array
    {
        return [
            'tableOptions' => [
                'paging' => $this->paging,
                'searching' => $this->searching,
                'ordering' => $this->ordering,
                'info' => $this->info,
                'pageLength' => $this->pageLength,
            ],
            'configuration' => [
                'showHeaders' => $this->showHeaders,
            ]
        ];
    }
}
