<div>
    <a data-id="{{ $button->getRandomId()  }}" class="btn mr-1 btn-{{ $button->getColor() }}">
        <i class="{{$button->getIcon() }}"></i>
        <span>{{ $button->getLabel() }}</span>
    </a>
</div>
<script>
    window.addEventListener("load",function(event) {
        const confirmMessage = "{{$button->getConfirmMessage()}}";
        if (confirmMessage.trim().length > 0) {
            const $button = $("a[data-id={{ $button->getRandomId() }}]");

            $button.on('click', () => {
                let data = @json($button->getSweetAlert());

                data.url = "{{ route($button->getRoute(), $button->getRouteParameters()) }}";

                SweetAlert.fire(data);
            })
        } else {
            $("a[data-id={{ $button->getRandomId() }}]").attr("href", "{{ $button->getConfirmMessage() === null ? route($button->getRoute(), $button->getRouteParameters()) : $button->getRoute() }}" );
        }
    });
</script>
