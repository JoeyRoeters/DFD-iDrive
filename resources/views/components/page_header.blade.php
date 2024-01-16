<div id="page-header" class="page-header container">
    <div class="row">
        <div class="col-md-6">
            <h1>{{ $pageHeader->getTitle() }}</h1>
            @if($pageHeader->getSubtitle() !== "")
                <h3 class="text-dark-emphasis">{!!  $pageHeader->getSubtitle() !!}</h3>
            @endif
        </div>
        <div class="col-md-6 button-container">
            @foreach($pageHeader->getButtons() as $button)
                @include('components.button_value_object', ['button' => $button])
            @endforeach
        </div>
    </div>
    <nav style="" aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach($breadCrumbs as $breadCrumb)
                @if($loop->last)
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadCrumb->getTitle() }}</li>
                    @continue
                @endif
                <li class="breadcrumb-item"><a href="{{ $breadCrumb->getRoute()->getUri() }}">{{ $breadCrumb->getTitle() }}</a>
                </li>
            @endforeach
        </ol>
    </nav>
</div>
