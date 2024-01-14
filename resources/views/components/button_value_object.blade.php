<div>
    <a data-id="{{ $button->getRandomId()  }}" class="btn mr-1 btn-{{ $button->getColor() }} {{ $button->getSize() }}">
        <i class="{{$button->getIcon() }}"></i>
        <span>{{ $button->getLabel() }}</span>
    </a>
</div>
<script>
    window.addEventListener("load",function(event) {
        const $button = $("a[data-id={{ $button->getRandomId() }}]");

        $button.on('click', () => {
            if ({{ $button->hasRoute()  ? "1" : "0" }}) {
                const uri = "{{ $button->getRouteUri() }}";
                if ({{ $button->hasConfirmMessage() ? "1" : "0"  }}) {
                    event.preventDefault();

                    let data = @json($button->getSweetAlert());

                    data.url = uri;

                    SweetAlert.fire(data);

                    return;
                }

                window.location = uri;
            }

            if ({{ $button->hasJsFunction()  ? "1" : "0" }}) {
                event.preventDefault();

                {!! $button->getJsFunction() !!};
            }
        })
    });
</script>
