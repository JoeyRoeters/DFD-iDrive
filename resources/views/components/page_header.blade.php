<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1>{{ $pageHeader->getTitle() }}</h1>
            @if($pageHeader->getSubtitle() !== "")
                <h3 class="text-dark-emphasis">{{ $pageHeader->getSubtitle() }}</h3>
            @endif
        </div>
        <div class="col-md-6 button-container">
            @foreach($pageHeader->getButtons() as $button)
                @include('components.button_value_object', ['button' => $button])
            @endforeach

        </div>
    </div>
</div>
