<div id="overview-wrapper" class="card mt-1">
    <?php /** @var \App\Domain\Trip\ValueObject\Statistic\ProfileValueObject $profile */ ?>
    @foreach($profiles as $profile)
        <div class="profile">
            <h2 class="text-center">{{ $profile->getTitle() }}</h2>

            <div class="statistics-container">
                @foreach($profile->getStatistics() as $statistic)
                    <div class="statistic">
                        <div class="statistic-value-wrapper">
                            <span class="statistic-value">{{ $statistic->getValue() }}</span>
                        </div>

                        <div class="statistic-title-wrapper">
                            <span class="statistic-title">{{ $statistic->getTitle() }}</span>
                            @if($statistic->getUnit() !== null)
                                <span class="statistic-unit">{{ $statistic->getUnit() }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="timeline-container">
                <div class="timeline">
                    <div class="timeline-bar">
                        <div class="timeline-bar-inner top">0%</div>
                        <div class="timeline-bar-inner center">50%</div>
                        <div class="timeline-bar-inner bottom">100%</div>
                    </div>

                    @foreach($profile->getEvents() as $event)
                        <div class="event" style="top: {{$event->getDistance() }}%">
                            <div class="event-marker-wrapper">
                                <div class="event-marker {{ $event->getSeverity() }}"></div>
                            </div>
                            <div class="event-content">
                                <div class="event-content-title">{{ $event->getTitle() }}</div>

                                @if($event->hasSubtitle())
                                    <div class="event-content-subtitle">{{ $event->getSubtitle() }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if(!$loop->first)
                <div class="separator"></div>
            @endif

        </div>
    @endforeach
</div>
