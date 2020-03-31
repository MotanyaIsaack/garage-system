@extends('layouts.user')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="card-deck mb-3 text-center">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">Total <br> Appointments </h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">{{ $appointments }}</h1>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">Pending <br> Appointments </h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">{{ $pending_appointments }}</h1>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">Complete Appointments </h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">{{ $completed_appointments }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
