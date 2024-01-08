<?php

namespace App\Helpers\Overview;

use App\Domain\Trip\Model\Trip;
use App\Helpers\Overview\Column\ValueObject\Column;
use App\Helpers\Overview\Column\Interface\RenderTypeInterface;
use App\Helpers\Overview\Table\Enum\TableDataRequestEnum;
use App\Helpers\Overview\Table\ValueObject\TableConfiguration;
use App\Helpers\Overview\Table\ValueObject\TableDataRequest;
use App\Helpers\Overview\Table\ValueObject\TableDataResponse;
use App\Helpers\View\Abstract\AbstractViewController;
use Illuminate\Http\Request;

abstract class AbstractOverviewController extends AbstractViewController
{
    /**
     * @return TableConfiguration
     */
    abstract protected function getTableConfiguration(): TableConfiguration;

    /**
     * @return array<Column>
     */
    abstract protected function getColumns(): array;

    /**
     * @return array
     */
    abstract protected function getTableData(TableDataRequest $request): array;

    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'overview/data_tables';
    }

    public function run(Request $request): mixed
    {
        if ($request->isMethod('post')) {
            return $this->handlePostRequest($request);
        }

        return parent::run($request); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    protected function appendViewData(Request $request): array
    {
        return [
            'tableConfiguration' => $this->getTableConfiguration(),
            'columns' => array_map(fn (Column $column) => $column->toArray(), $this->getColumns())
        ];
    }

    private function handlePostRequest(Request $request)
    {
        $this->loadData($request);
        $request = TableDataRequest::capture();
        $columns = $this->getColumns();
        $models = $this->getTableData($request);

        // Sort each sub-array based on the order of keys in $columns
        foreach ($models as &$model) {
            $model = $this->processArray($model, $columns);
        }

        $totalRecords = $this->getModelQuery()->count() - 1;

        return new TableDataResponse(
            records: $models,
            draw: $request->getTableValue(TableDataRequestEnum::DRAW),
            recordsTotal: $totalRecords,
            recordsFiltered: $request->isSearch() ? count($models) : $totalRecords,
        );
    }

    private function processArray(array $array, array $columns): array
    {
        // Sort the array based on the order of keys in $columns
        uksort($array, function ($key1, $key2) use ($columns) {
            $index1 = array_search($key1, $columns);
            $index2 = array_search($key2, $columns);

            return $index1 - $index2;
        });

        // go over values of array and check if they are instance of RenderTypeInterface and if so, format the
        foreach ($array as &$value) {
            if ($value instanceof RenderTypeInterface) {
                $value = $value->format();
            }

            if (is_int($value) || is_float($value) || is_bool($value) || is_array($value) || is_object($value)) {
                $value = (string) $value;
            }
        }

        return array_values($array);
    }
}
