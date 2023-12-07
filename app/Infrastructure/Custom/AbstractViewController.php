<?php

namespace App\Infrastructure\Custom;

use App\Infrastructure\Custom\ValueObjects\PageHeaderValueOject;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class AbstractViewController extends Controller
{
    /**
     * @return array<string, mixed>
     */
    private function defaultViewData(): array
    {
        return [
            'pageHeader' => $this->pageHeader()
        ];
    }

    /**
     * @param Request $request
     */
    protected function loadData(Request $request): void
    {
    }

    /**
     * @return string
     */
    abstract protected function view(): string;

    /**
     * @return PageHeaderValueOject
     */
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
     * @return array<string, mixed>
     */
    abstract protected function appendViewData(): array;

    /**
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function run(Request $request): View|RedirectResponse
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
