@extends('admin.layouts.index')
@section('bar')
<style>
    .bar {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
    }

    .bar li {
        flex: 1;
        text-align: center;
        position: relative;
        font-weight: bold;
        color: #000000;
    }

    .bar li:before {
        content: '';
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 5px solid #ccc;
        background-color: #fff;
        display: block;
        margin: 0 auto 10px;
    }

    .bar li.active:before {
        border: 10px solid #ffd000;
        box-shadow: 0 0 15px #ffd000;
    }

    .bar li:after {
        content: '';
        position: absolute;
        width: 100%;
        height: 15px;
        border-radius: 10%;
        background-color: #22bb33;
        top: 15px;
        left: -50%;
        z-index: -1;
    }

    .bar li.active~li:after {
        background-color: #c4e2c7;
    }

    .bar li:first-child:after {
        content: none;
    }
</style>



    <nav class="main-header navbar" style="background-color: #f4f6f9">
        <!-- Left navbar links -->
        <ul class="bar col-12">
            @foreach ($labelBar as $step)
                <li class="{{ $currentStep == $step ? 'active' : '' }}">{{ $step }}</li>
            @endforeach
        </ul>

    </nav>

    @parent
@endsection
