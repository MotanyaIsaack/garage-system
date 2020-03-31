@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Spares</div>

                <div class="card-body">
                    <form id="stocks_form" method="POST">
                        @csrf
                        <input type="text" name="action" id="action" value="insert" class="d-none">
                        <input type="number" name="spare_id" id="spare_id" class="d-none">
                        <div class="form-group row">
                            <div class="col-md-5">
                                <label for="name" class=" col-form-label">{{ __('Name') }}</label>

                                <div>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="col-md-5 mr-4">
                                <label for="stock" class=" col-form-label">{{ __('Stock') }}</label>

                                <div>
                                    <input id="stock" type="number" class="form-control @error('name') is-invalid @enderror" name="stock" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="col-md-5">

                            </div>

                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-0">
                                <button id="add-spares" type="submit" class="btn btn-primary">
                                    {{ __('Add Spare') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header">Manage Spares</div>

                <div class="card-body">
                    <table id="table_spares" class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script !src="">
        $(()=>{
            /*Initialise DataTables*/
            const url = `{{ url('/get_spares_json') }}`;
            const spares_datatable = $('#table_spares').DataTable({
                ajax: {
                    url: url,
                    dataType:'json',
                    dataSrc: ''
                },
                columns: [
                    {data: 'spare_id'},
                    {data: 'name'},
                    {data: 'stock'},
                    {data: 'actions'}
                ]
            });
            const form = $('#stocks_form');
            /*Initialise DataTables*/

            /*Form Submission*/
            $('#add-spares').on('click',function (event) {
                event.preventDefault();
                const url = '{{ url('/add/spares') }}';
                const data = form.serializeArray();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data
                }).then(res=>{
                    if(res.ok){
                        alertify.success(res.msg);
                    }else{
                        if(res.msg.hasOwnProperty('name')){
                            alertify.error(res.msg.name[0]);
                        }else if(res.msg.hasOwnProperty('stock')){
                            alertify.error(res.msg.stock[0]);
                        }
                    }
                    spares_datatable.ajax.reload();
                    $('input[name=action]#action').val('insert');
                    $('#add-spares').html('Add Spares');
                    form[0].reset();
                });
            });
            /*Form Submission*/

            /*Get Data Clicked For Edit On The Form*/
            spares_datatable.on('click','.edit-button',function (event) {
                const _this = event.target;
                const tr = $(_this).closest('tr');
                const rowIndex = spares_datatable.row(tr).index();
                const rowData = spares_datatable.rows(rowIndex).data()[0];
                $('input[name=action]#action').val('edit');
                $('#add-spares').html('Edit Spares');

                //Fill form with details
                Object.keys(rowData).forEach(fieldName => {
                    $('#stocks_form').find(`input#${fieldName}`).val(rowData[fieldName]);
                });
            });
            /*Get Data Clicked For Edit On The Form*/

            /*Perform Delete Operation*/
            spares_datatable.on('click','.delete-button',function (event) {
                const _this = event.target;
                const tr = $(_this).closest('tr');
                const rowIndex = spares_datatable.row(tr).index();
                const rowData = spares_datatable.rows(rowIndex).data()[0];
                const url = `{{ url('/suspend/spares') }}`;
                const dataToSend = {spare_id:rowData.spare_id};
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: dataToSend
                }).then(res=>{
                    alertify.success(res.msg);
                    spares_datatable.ajax.reload();
                });
            });
            /*Perform Delete Operation*/

            /*Perform Restore Operation*/
            spares_datatable.on('click','.restore-button',function (event) {
                const _this = event.target;
                const tr = $(_this).closest('tr');
                const rowIndex = spares_datatable.row(tr).index();
                const rowData = spares_datatable.rows(rowIndex).data()[0];
                const url = `{{ url('/restore/spares') }}`;
                const dataToSend = {spare_id:rowData.spare_id};
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: dataToSend
                }).then(res=>{
                    alertify.success(res.msg);
                    spares_datatable.ajax.reload();
                });
            })
            /*Perform Restore Operation*/


        });
    </script>
@endpush
