<div id="dfd-stepper-container">
    <h1>{{ $stepper->getTitle() }}</h1>

    @if($stepper->hasDescription())
        <p class="mb-3">{{ $stepper->getDescription() }}</p>
    @endif

    <div class="dfd-stepper">
        @foreach($stepper->getItems() as $key => $step)
            <div class="dfd-step {{ $step->hasButton() ? "has-button" : "" }}">
                <div class="bullet">
                    <i class="{{ $step->getIcon() }}"></i>
                </div>

                <div class="dfd-label">
                    <span class="number">STEP {{ $key + 1 }}</span>
                    <span class="title">{{ $step->getTitle() }}</span>
                    @if($step->hasDescription())
                        <span class="description d-inline-flex flex-nowrap flex-column">
                            <span>{{ $step->getDescription() }}</span>
                            @if($step->hasButton())
                                <span class="mt-1">
                                    {!! $step->getButton()->render() !!}
                                </span>
                            @else
                                <span class="mt-1"></span>
                            @endif
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
