<div id="overview-wrapper" class="card mt-1">
    <?php /** @var \App\Domain\Trip\ValueObject\Statistic\ProfileValueObject $profile */ ?>
    @foreach($profiles as $profile)
        <div class="profile">
            <h2 class="text-center">{{ $profile->getTitle() }}</h2>
        </div>
    @endforeach
</div>
