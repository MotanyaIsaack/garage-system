@extends('layouts.app')
@push('libraries')
    <!-- Datatables Start -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <!-- Datatables End -->
@endpush
@section('nav-links')
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/spares') }}">Spares</a>
    </li>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Manage Vehicles <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" data-toggle="modal" data-target=".vehicle-categories" href="#">
                {{ __('Vehicle Categories') }}
            </a>
            <a class="dropdown-item" data-toggle="modal" data-target=".vehicle-types" href="#">
                {{ __('Vehicle Types') }}
            </a>
            <a class="dropdown-item" data-toggle="modal" data-target=".garage-services" href="#">
                {{ __('Garage Services') }}
            </a>
            <a class="dropdown-item" data-toggle="modal" data-target=".services_pricing" href="#">
                {{ __('Services Pricing') }}
            </a>

        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">Appointments</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">Employees</a>
    </li>
@endsection
@push('modals')
    <div class="modal fade vehicle-categories" tabindex="-1" role="dialog" aria-labelledby="myVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myVehicleModalLabel">Vehicle Categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="vehicle_category_form" method="POST">
                            <div class="display-alert"></div>
                            @csrf
                            <div class="form-group row">
                                <input type="text" name="action" id="vehicle_category_action" value="insert" hidden>
                                <input type="number" name="category_id" id="category_id" hidden>
                                <label for="name" class="mt-2">Vehicle Category Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                                <button id="vehicle_category_button" type="submit" class="btn btn-primary">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="table_vehiclecategories" class="table table-striped">
                           <thead class="">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
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
    <div class="modal fade vehicle-types" tabindex="-1" role="dialog" aria-labelledby="myVehicleTypesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myVehicleTypesModalLabel">Vehicle Categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="vehicle_types_form" method="POST">
                            <div class="display-alert"></div>
                            @csrf
                            <div class="form-group row">
                                <input type="text" name="action" id="vehicle_types_action" value="insert" hidden>
                                <input type="number" name="type_id" id="type_id" hidden>
                                <label for="make" class="mt-2">Vehicle Make: </label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="make" id="make">
                                </div>
                                <label for="model" class="mt-2">Vehicle Model: </label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="model" id="model">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="mt-2">Vehicle Category: </label>
                                <div class="col-md-6">
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach($vehicle_categories as $vehicle_category)
                                            <option value="{{ $vehicle_category->category_id }}">{{$vehicle_category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button id="vehicle_types_button" type="submit" class="btn btn-primary">
                                {{ __('Add') }}
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="table_vehicletypes" class="table table-striped table-bordered">
                           <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Category Name</th>
                                    <th>Make</th>
                                    <th>Model</th>
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
    <div class="modal fade garage-services" tabindex="-1" role="dialog" aria-labelledby="myGarageServicesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myGarageServicesModalLabel">Vehicle Categories</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="garage_services_form" method="POST">
                            <div class="display-alert"></div>
                            @csrf
                            <div class="form-group row">
                                <input type="text" name="action" id="garage_services_action" value="insert" hidden>
                                <input type="number" name="service_id" id="service_id" hidden>
                                <label for="name" class="mt-2">Service Name: </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="service_name" id="name">
                                </div>
                                <button id="garage_service_button" type="submit" class="btn btn-primary">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="table_garage_services" class="table table-striped">
                            <thead class="">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
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
    <div class="modal fade services_pricing" tabindex="-1" role="dialog" aria-labelledby="myServicesPricingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myServicesPricingModalLabel">Service Pricing Mapping</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form id="service_pricing_form" method="POST">
                            <div class="display-alert"></div>
                            @csrf
                            <div class="form-group row">
                                <input type="text" name="action" id="service_pricing_action" value="insert" hidden>
                                <input type="number" name="price_id" id="price_id" hidden>

                                <div class="col-md-4">
                                    <label for="service_id" class="mt-2">Service Name: </label>
                                    <select class="form-control" name="service_id" id="service_id">
                                        @foreach($garage_services as $service)
                                            <option value="{{ $service->service_id }}">{{$service->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="category_id" class="mt-2">Vehicle Category: </label>
                                    <select class="form-control" name="category_id" id="category_id">
                                        @foreach($vehicle_categories as $vehicle_category)
                                            <option value="{{ $vehicle_category->category_id }}">{{$vehicle_category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="amount" class="mt-2">Amount (Ksh): </label>
                                    <input class="form-control" type="number" name="amount" id="amount">
                                </div>
                            </div>
                            <button id="service_pricing_button" type="submit" class="btn btn-primary">
                                {{ __('Add') }}
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="table_service_pricing" class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Category Name</th>
                                <th>Service Name</th>
                                <th>Amount</th>
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
    <script !src="">
        $(()=>{
            /*Script for vehicle categories*/
            const table_vehiclecategories = $('#table_vehiclecategories').DataTable({
                ajax: {
                    url: `{{ url('/get_vehicle_categories_json') }}`,
                    dataType: 'json',
                    dataSrc: ''
                },
                columns: [
                    {data: 'category_id'},
                    {data: 'name'},
                    {data: 'actions'},
                ],
                autoWidth: false,
            });
            const vehicle_category_form = $('#vehicle_category_form');
            vehicle_category_form.on('submit',(event)=>{
                event.preventDefault();
                if($('input[name=name]').val() == null || $("input[name=name]").val() === ''){
                    alertify.notify('Please fill the form field','error','2');
                }else{
                    let url = `{{ url('/add/vehicle_category') }}`;
                    let data = vehicle_category_form.serializeArray();
                    ajaxPost(url,data).then(()=>{
                        table_vehiclecategories.ajax.reload();
                        vehicle_category_form[0].reset();
                        $('button#vehicle_category_button').html('Add');
                    });
                }
            });
            /*Edit Form Functionality*/
            table_vehiclecategories.on('click','.edit-button',function (event) {
                let action = $('input[name=action]#vehicle_category_action');
                $('button#vehicle_category_button').html('Update');
                fill_form_with_edit_data(event,table_vehiclecategories,vehicle_category_form,action);
            });

            /*Suspend Form Functionality*/
            table_vehiclecategories.on('click','.delete-button',function (event) {
                let row_data = form_data(event,table_vehiclecategories);
                let url = `{{ url('/suspend/vehicle_category') }}`;
                let data = {category_id: row_data.category_id};
                ajaxPost(url,data).then(()=>{
                    table_vehiclecategories.ajax.reload();
                });
            });

            /*Suspend Form Functionality*/
            table_vehiclecategories.on('click','.restore-button',function (event) {
                let row_data = form_data(event,table_vehiclecategories);
                let url = `{{ url('/restore/vehicle_category') }}`;
                let data = {category_id: row_data.category_id};
                ajaxPost(url,data).then(()=>{
                    table_vehiclecategories.ajax.reload();
                });
            });
            /*Script for vehicle categories*/

            /*Script for vehicle types*/
            const table_vehicletypes = $("#table_vehicletypes").DataTable({
                ajax: {
                    url:`{{ url('/get_vehicle_types_json') }}`,
                    dataType: 'json',
                    dataSrc:''
                },
                columns: [
                    {data: 'type_id'},
                    {data: 'category_name'},
                    {data: 'make'},
                    {data: 'model'},
                    {data: 'actions'}
                ],
                autoWidth: false,
            });

            const vehicle_types_form = $('#vehicle_types_form');
            vehicle_types_form.on('submit',function (event) {
                event.preventDefault();
                let category_id = $('select[name=category_id]').val();
                let make = $('input[name=make]').val();
                let model = $('input[name=model]').val();
                const data = {'Category Name': category_id, 'Vehicle Make' : make, 'Vehicle Model' : model};
                if(!validate_form_fields(data)){
                    let url = `{{ url('/add/vehicle_type') }}`;
                    let data = vehicle_types_form.serializeArray();
                    ajaxPost(url,data).then(()=>{
                        table_vehicletypes.ajax.reload();
                        vehicle_types_form[0].reset();
                        $('button#vehicle_types_button').html('Add');
                    });
                }
            });
            table_vehicletypes.on('click','.edit-button',function (event) {
                let action = $('input[name=action]#vehicle_types_action');
                fill_form_with_edit_data(event,table_vehicletypes,vehicle_types_form,action);
                $('button#vehicle_types_button').html("Edit")
            });
            /*Suspend Form Functionality*/
            table_vehicletypes.on('click','.delete-button',function (event) {
                let row_data = form_data(event,table_vehicletypes);
                let url = `{{ url('/suspend/vehicle_type') }}`;
                let data = {type_id: row_data.type_id};
                ajaxPost(url,data).then(()=>{
                    table_vehicletypes.ajax.reload();
                });
            });

            /*Suspend Form Functionality*/
            table_vehicletypes.on('click','.restore-button',function (event) {
                let row_data = form_data(event,table_vehicletypes);
                let url = `{{ url('/restore/vehicle_type') }}`;
                let data = {type_id: row_data.type_id};
                ajaxPost(url,data).then(()=>{
                    table_vehicletypes.ajax.reload();
                });
            });

            /*Script for vehicle types*/

            /*Script for garage_service*/
            const table_garage_services = $('#table_garage_services').DataTable({
                ajax: {
                    url: `{{ url('/get_garage_services_json') }}`,
                    dataType: 'json',
                    dataSrc: ''
                },
                columns: [
                    {data: 'service_id'},
                    {data: 'name'},
                    {data: 'actions'},
                ],
                autoWidth: false,
            });
            const garage_services_form = $('#garage_services_form');
            garage_services_form.on('submit',(event)=>{
                event.preventDefault();
                let name = $('input[name=service_name]').val();
                if(!validate_form_fields({'Service name':name})){
                    let url = `{{ url('/add/garage_service') }}`;
                    let data = garage_services_form.serializeArray();
                    ajaxPost(url,data).then(()=>{
                        table_garage_services.ajax.reload();
                        garage_services_form[0].reset();
                        $('button#garage_service_button').html('Add');
                    });
                }
            });
            /*Edit Form Functionality*/
            table_garage_services.on('click','.edit-button',function (event) {
                let action = $('input[name=action]#garage_services_action');
                $('button#garage_service_button').html('Update');
                fill_form_with_edit_data(event,table_garage_services,garage_services_form,action);
            });

            /*Suspend Form Functionality*/
            table_garage_services.on('click','.delete-button',function (event) {
                let row_data = form_data(event,table_garage_services);
                let url = `{{ url('/suspend/garage_service') }}`;
                let data = {service_id: row_data.service_id};
                ajaxPost(url,data).then(()=>{
                    table_garage_services.ajax.reload();
                });
            });

            /*Suspend Form Functionality*/
            table_garage_services.on('click','.restore-button',function (event) {
                let row_data = form_data(event,table_garage_services);
                let url = `{{ url('/restore/garage_service') }}`;
                let data = {service_id: row_data.service_id};
                ajaxPost(url,data).then(()=>{
                    table_garage_services.ajax.reload();
                });
            });
            /*Script for garage_services*/

            /*Script for service pricing*/
            const table_service_pricing = $("#table_service_pricing").DataTable({
                ajax: {
                    url:`{{ url('/get_services_pricing_json') }}`,
                    dataType: 'json',
                    dataSrc:''
                },
                columns: [
                    {data: 'price_id'},
                    {data: 'category_name'},
                    {data: 'service_name'},
                    {data: 'amount'},
                    {data: 'actions'}
                ],
                autoWidth: false,
            });

            const service_pricing_form = $('#service_pricing_form');
            service_pricing_form.on('submit',function (event) {
                event.preventDefault();
                let category_id = service_pricing_form.find($('select[name=category_id]')).val();
                let service_id = service_pricing_form.find($('select[name=service_id]')).val();
                let amount = service_pricing_form.find($('input[name=amount]')).val();

                const data = {'Category Name': category_id, 'Service Name' : service_id, 'Amount' : amount};
                if(!validate_form_fields(data)){
                    let url = `{{ url('/add/service_pricing') }}`;
                    let data = service_pricing_form.serializeArray();
                    ajaxPost(url,data).then(()=>{
                        table_service_pricing.ajax.reload();
                        service_pricing_form[0].reset();
                        $('button#service_pricing_button').html('Add');
                    });
                }
            });
            table_service_pricing.on('click','.edit-button',function (event) {
                let action = $('input[name=action]#service_pricing_action');
                fill_form_with_edit_data(event,table_service_pricing,service_pricing_form,action);
                $('button#service_pricing_button').html("Edit")
            });
            /*Suspend Form Functionality*/
            table_service_pricing.on('click','.delete-button',function (event) {
                let row_data = form_data(event,table_service_pricing);
                let url = `{{ url('/suspend/service_pricing') }}`;
                let data = {price_id: row_data.price_id};
                ajaxPost(url,data).then(()=>{
                    table_service_pricing.ajax.reload();
                });
            });

            /*Suspend Form Functionality*/
            table_service_pricing.on('click','.restore-button',function (event) {
                let row_data = form_data(event,table_service_pricing);
                let url = `{{ url('/restore/service_pricing') }}`;
                let data = {price_id: row_data.price_id};
                ajaxPost(url,data).then(()=>{
                    table_service_pricing.ajax.reload();
                });
            });

            /*Script for service pricing*/
        });
    </script>
@endpush

