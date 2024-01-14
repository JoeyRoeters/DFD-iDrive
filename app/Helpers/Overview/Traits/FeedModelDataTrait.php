<?php

namespace App\Helpers\Overview\Traits;

use App\Domain\Shared\Interface\SearchableModelInterface;
use App\Domain\Shared\Interface\SearchableModelStringInterface;
use App\Domain\Trip\Model\Trip;
use App\Helpers\Overview\Table\Enum\TableDataRequestEnum;
use App\Helpers\Overview\Table\ValueObject\TableDataRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait FeedModelDataTrait
{
    abstract protected function getModelQuery(): Builder;

    abstract protected function processModel(Model $model): array;

    protected function getTableData(TableDataRequest $request): array
    {
        $query = $this->getModelQuery();
        $query->limit($request->getTableValue(TableDataRequestEnum::LENGTH));
        $query->offset($request->getTableValue(TableDataRequestEnum::START));

        $search = trim($request->getTableValue(TableDataRequestEnum::SEARCH_VALUE));

        $modelClass = $query->getModel();
        $model = new $modelClass();
        if ($model instanceof SearchableModelInterface && !empty($search)) {
            $query->where(function ($query) use ($model, $search) {
                foreach ($model::getSearchableFields() as $field) {
                    $query->orWhere($field, 'LIKE', "%{$search}%");
                }
            });
        }

        if ($model instanceof SearchableModelStringInterface && !empty($search)) {
            $query->where('search', 'LIKE', "%{$search}%");
        }

        $models = $query->getModels();

        return array_map(
            fn ($model) => $this->processModel($model),
            $models
        );
    }
}
