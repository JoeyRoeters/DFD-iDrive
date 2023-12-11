@extends('base')

@section('head')

@endsection

@section('content')
    <div class="container">
        <div class="row mt-xl-4">
            <div class="col-12">
                <table id="datatable"></table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.onload = function () {
            const $datatable = $("#datatable");
            const datatable = new DataTable({
                selector: $datatable,
                fetchUrl: "{{ request()->path() }}",
                csrf: "{{ csrf_token() }}",
                columns: @JSON($columns),
                totalRecords: {{ $totalRecords }},
                options: {}
            })
        }
    </script>
@endsection
