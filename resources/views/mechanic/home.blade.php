@extends('layouts.mechanic')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <div class="card-deck mb-3 text-center">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <h4 class="my-0 font-weight-normal">Appointments</h4>
                                </div>
                                <div class="card-body">
                                    <h1 class="card-title pricing-card-title">0</h1>
                                </div>
                            </div>
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <h4 class="my-0 font-weight-normal">Jobs Completed</h4>
                                </div>
                                <div class="card-body">
                                    <h1 class="card-title pricing-card-title">0</h1>
                                </div>
                            </div>
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <h4 class="my-0 font-weight-normal">Total Earnings</h4>
                                </div>
                                <div class="card-body">
                                    <h1 class="card-title pricing-card-title">$0</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
