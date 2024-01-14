<div id="dfd-empty-table-container">
    @if ($valueObject->hasImage())
        <img src="{{ $valueObject->getImage() }}"/>
    @endif

    <h2>{{ $valueObject->getTitle() }}</h2>

    <p>{{ $valueObject->getDescription() }}</p>

    @if ($valueObject->hasButton())
        {!! $valueObject->getButton()->render() !!}
    @endif
</div>
