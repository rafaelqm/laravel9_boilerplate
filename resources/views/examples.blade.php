@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Form Components</h1>
    <hr>
    <h2>Bootstrap Toggle</h2>
    <div class="row">

        <input id="chkToggle" type="checkbox" data-toggle="toggle">
    </div>
    <h2>Bootstrap ICheck</h2>
    <div class="row">
        <div class="icheck-primary">
            <input type="checkbox" id="someCheckboxId" />
            <label for="someCheckboxId">Click to check</label>
        </div>
    </div>
    <div class="row">
        <h2>Custom file upload</h2>
        <div class="custom-file">
            <input id="inputGroupFile02" type="file" multiple class="custom-file-input">
            <label class="custom-file-label" for="inputGroupFile02">Choose several files</label>
        </div>

    </div>
</div>
@endsection
