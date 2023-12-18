<table id="datatable" class="w-100"></table>

<script>
    window.onload = function () {
        const $datatable = $("#datatable");
        const datatable = new DataTable({
            selector: $datatable,
            fetchUrl: "{{ url(request()->path()) }}",
            csrf: "{{ csrf_token() }}",
            columns: @JSON($columns),
            configuration: @JSON($tableConfiguration->toArray())
        })
    }
</script>
