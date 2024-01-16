<?php

namespace App\Domain\Shared\Interface;

use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use Illuminate\Http\Request;

interface BreadCrumbInterface
{
    public function getBreadCrumb(Request $request): BreadCrumbValueObject;
}
