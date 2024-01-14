<?php

namespace App\Helpers\View\Abstract;

use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class AbstractViewController extends Controller
{
    protected Request $request;

    /**
     * @return array<string, mixed>
     */
    protected function defaultViewData(): array
    {
        return [
            'pageHeader' => $this->pageHeader(),
            'breadCrumbs' => $this->getBreadCrumbs(),
        ];
    }

    private function getBreadCrumbs(): ?array
    {
        if (!$this instanceof BreadCrumbInterface) {
            return null;
        }

        $breadCrumbs = [];

        $breadCrumb = $this->getBreadCrumb(request());
        while ($breadCrumb?->hasParentClass()) {
            $breadCrumbs[] = $breadCrumb;

            $breadCrumb = $breadCrumb->getParentBreadCrumb();
        }

        $breadCrumbs[] = $breadCrumb;

        return array_reverse($breadCrumbs);
    }

    /**
     * @param Request $request
     */
    public function loadData(Request $request): void
    {
        $this->request = $request;
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
    abstract protected function appendViewData(Request $request): array;

    /**
     * @param Request $request
     * @return mixed
     */
    public function run(Request $request): mixed
    {
        $this->loadData($request);

        if (!$this->exists()) {
            return redirect()->back();
        }

        return view(
            $this->view(),
            $this->defaultViewData(),
            $this->appendViewData($request)
        );
    }
}
