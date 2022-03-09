<script type="text/javascript">
    {{--var gridPhotos = document.getElementById('{{ $grid_name }}');--}}
    {{--new Sortable(gridPhotos, {--}}
    {{--    animation: 150,--}}
    {{--    ghostClass: 'bg-warning'--}}
    {{--});--}}

    function removeFile (file_id) {
        Swal.fire({
            title: "Deseja realmente remover este arquivo?",
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            // cancelButtonColor: '#f8f9fa',
            confirmButtonText: '{{ ucfirst( __('crud.yes') ) }}, {{ ucfirst( __('crud.delete') ) }}!',
            cancelButtonText: '{{ ucfirst( __('crud.cancel') ) }}',
            reverseButtons: true,
        }).then(function (willDelete) {
            if (willDelete.isConfirmed) {
                $('#' + file_id).hide('fast', function () {
                    $(this).remove();
                });
            }
        });
    }
</script>
