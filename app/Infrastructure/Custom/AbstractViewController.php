<?php

namespace App\Infrastructure\Custom;

use App\Infrastructure\Custom\ValueObjects\PageHeaderValueOject;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Http\Request;


abstract class AbstractViewController extends Controller
{
    private function defaultViewData(): array
    {
        return [
            'pageHeader' => $this->pageHeader()
        ];
    }

    protected function loadData(Request $request): void
    {
    }

    abstract protected function view(): string;

    abstract protected function pageHeader(): PageHeaderValueOject;

    /**
     * return user to prev route if not exists. Default is true. Override this method if you want to change this behavior.
     *
     * @return bool
     */
    protected function exists(): bool
    {
        return true;
    }

    /**
     * return data array to append to view. Override this method if you want to append data to view.
     *
     * @return array
     */
    abstract protected function appendViewData(): array;

    public function run(Request $request)
    {
        $this->loadData($request);

        if (!$this->exists()) {
            return redirect()->back();
        }

        return view(
            $this->view(),
            $this->defaultViewData(),
            $this->appendViewData()
        );
    }
}
