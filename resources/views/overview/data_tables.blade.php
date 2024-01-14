@extends('base')

@section('head')

@endsection

@section('content')
    <div class="container">
        @if($isEmpty)
            {!! $emptyViewObject->render() !!}
        @else
            <div class="row">
                <div class="col-12">
                    <table id="datatable" class="w-100"></table>
                </div>
            </div>
        @endif
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
                configuration: @JSON($tableConfiguration->toArray())
            })
        }
    </script>
@endsection
