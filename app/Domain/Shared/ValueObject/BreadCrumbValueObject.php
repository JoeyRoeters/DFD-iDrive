<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Interface\BreadCrumbInterface;

class BreadCrumbValueObject
{
    private ?\ReflectionClass $parentClassInstance = null;
    public function __construct(
        private string $title,
        private RouteValueObject $route,
        private ?string $parentClass = null,
    )
    {
        if ($this->parentClass) {
            $reflection = new \ReflectionClass($this->parentClass);
            if (!$reflection->implementsInterface(BreadCrumbInterface::class)) {
                throw new \Exception('Parent class has to implement BreadCrumbInterface');
            }

            $this->parentClassInstance = $reflection;
        }
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return RouteValueObject
     */
    public function getRoute(): RouteValueObject
    {
        return $this->route;
    }

    /**
     * @return string|null
     */
    public function getParentClass(): ?string
    {
        return $this->parentClass;
    }

    public function hasParentClass(): bool
    {
        return $this->parentClass !== null;
    }

    public function getParentClassInstance(): ?BreadCrumbInterface
    {
        return $this->parentClassInstance?->newInstance();

    }

    public function getParentBreadCrumb(): ?BreadCrumbValueObject
    {
        $reflection = $this->getParentClassInstance();

        $reflection->loadData(request());

        return $reflection?->getBreadCrumb(request());
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'route' => $this->route,
            'parentClass' => $this->parentClass,
        ];
    }
}
