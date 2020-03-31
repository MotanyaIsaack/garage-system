@extends('layouts.app')
@push('libraries')
    <!-- Datatables Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <script src="{{asset('select2/js/select2.min.js')}}"></script>
    <!-- Datatables End -->
@endpush
@section('nav-links')

    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Appointments <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" data-toggle="modal" data-target=".appointment" href="#">
                {{ __('Make Appointment') }}
            </a>
        </div>
    </li>
@endsection
@push('modals')
    <div class="modal fade appointment" tabindex="-1" role="dialog" aria-labelledby="myAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myAppointmentModalLabel">Request for an appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="appointments_form" method="POST">
                            <div class="display-alert"></div>
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="type_id" class="mt-2">Vehicle Type: </label>
                                    <select class="form-control" name="type_id" id="type_id" required>
                                        @foreach($types as $type)
                                            <option value="{{ $type->type_id }}">{{$type->make.' - '.$type->model}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="category_id" class="mt-2">Vehicle Category: </label>
                                    <select class="form-control" name="category_id" id="category_id" required>

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="category_id" class="mt-2">Services: </label>
                                    <select class="form-control" name="service_id[]" id="service_id" required>

                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="amount" class="mt-2">Amount (Ksh): </label>
                                    <input class="form-control" type="number" name="amount" id="amount" disabled>
                                </div>
                            </div>
                            <button id="service_pricing_button" type="submit" class="btn btn-primary">
                                {{ __('Add') }}
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="table_requests" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Service Name</th>
                                <th>Amount</th>
                                <th>Mechanic</th>
                                <th>Payment Status</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
@push('modal-scripts')
    <script>
        function fill_category_select(type_select){
            return new Promise(resolve=>{
                type_select.on('change',function (event) {
                    let type_id = $('#type_id').val();
                    let url = `{{ url('/get_categories_json') }}`;
                    $.ajax({
                        url:url,
                        type:'POST',
                        data:{type_id:type_id},
                        success: res=>{
                            for(const index in res){
                                $('#category_id').find('option').remove().end().append(
                                    $('<option />').text(`${res['name']}`).val(`${res['category_id']}`)
                                );
                            }
                            resolve();
                        }
                    });
                });
                type_select.trigger('change');
            });
        }
        async function fill_services_list(category_select,type_select){
            await fill_category_select(type_select);
            category_select.on('change',function(event){
                let category_id = category_select.val();
                let url = `{{ url('/get_services_json') }}`;
                $.ajax({
                    url:url,
                    type:'POST',
                    data:{category_id:category_id},
                    success: res=>{
                        let fill_data = [];
                        res.forEach(function (entry) {
                            fill_data.push({id:entry['service_id'],text:entry['name'],amount:entry['pricing'][0]['amount']});
                        });
                            $('#service_id').select2({
                            multiple:'true',
                            data:fill_data,
                            templateSelection: function (data) {
                                $(data.element).attr('data-amount', data.amount);
                                return data.text;
                            },
                        });
                    }
                });
            });
            category_select.trigger('change');
        }
        const get_values=function(filter){
            let retval = [];
            if (filter === 'val'){
                $("#service_id").find('option:selected').each(function(){
                    retval.push($(this).val());
                });
            }else{
                $("#service_id").find('option:selected').each(function(){
                    retval.push($(this).text());
                });
            }
            return retval;
        };
        $(()=>{
            //Populate the table
            const requests_table = $('#table_requests').DataTable({
                ajax:{
                    url: `{{ url('/get_requests_json') }}`,
                    dataType: 'JSON',
                    dataSrc: ''
                },
                columns:[
                    {data: 'request_id'},
                    {data: 'services'},
                    {data: 'amount'},
                    {data: 'mechanic'},
                    {data: 'paid'},
                    {data: 'completed'},
                    {data: 'actions'}
                ],
                autoWidth:false
            });
            $('.appointment').on('shown.bs.modal',function (event) {
                const form = $('#appointments_form');
                const type_select = $('#type_id');
                const category_select = $('#category_id');
                const service_select = $('#service_id');
                fill_services_list(category_select,type_select);
                form.find(service_select).on('change',function (event) {
                    let service_id = get_values('val');
                    if(service_id.length !== 0){
                        let data = {service_id:service_id};
                        let url = `{{ url('/amount') }}`;
                        $.ajax({
                            url:url,
                            type:'POST',
                            data:data,
                            success: res=>{
                                $('input[name=amount]').val(res);
                            }
                        });
                    }else{
                        $('input[name=amount]').val('');
                    }
                });
                setTimeout(function (event) {
                    service_select.trigger('change.select2');
                },2000)
            });
            const appointments_form = $('#appointments_form');
            appointments_form.on('submit',function (event) {
                event.preventDefault();
                let services = get_values('text').toString();
                let category_id = $('#category_id').val();
                let amount = $('input[name=amount]').val();
                const data = {services:services,category_id:category_id,amount:amount};
                const url = `{{ url('/add/request') }}`;
                ajaxPost(url,data);
            });
        });
    </script>
@endpush

