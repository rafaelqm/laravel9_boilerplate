@push('page_css')
    @include('layouts.datatables_css')
@endpush

<div class="table-responsive">
    {!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-sm table-head-fixed table-bordered table-hover'], true) !!}
</div>

@push('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
{{--    <script src="/vendor/datatables/buttons.server-side.js"></script>--}}
