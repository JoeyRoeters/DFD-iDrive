<div class="page-header">
    <div class="row">
        <div class="col-md-6">
            <h1>{{ $pageHeader->getTitle() }}</h1>
        </div>
        <div class="col-md-6 button-container">
            @foreach($pageHeader->getButtons() as $button)
                <div>
                    <a href="{{ route($button->getRoute()) }}" class="btn btn-{{ $button->getColor() }}">
                        <i class="{{$button->getIcon() }}"></i>
                        <span>{{ $button->getLabel() }}</span>
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</div>
