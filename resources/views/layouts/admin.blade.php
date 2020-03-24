@extends('layouts.app')
@section('nav-links')
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/spares') }}">Spares</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">Vehicle Types</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">Appointments</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="">Employees</a>
    </li>
@endsection
