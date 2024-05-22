<!-- resources/views/profile.blade.php -->

@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Other code -->
<div class="container">
    <h2>Profile</h2>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $user->phone_number }}">
        </div>

<!-- Other code -->

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary" id="updateButton">Update Profile</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection


    @section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const formData = new FormData(form);
        const updateButton = document.getElementById('updateButton');

        // Disable the button by default
        updateButton.disabled = true;

        // Create a copy of the initial form data
        let initialData = {};
        for (let field of form.elements) {
            if (field.name) {
                initialData[field.name] = formData.get(field.name) || '';
            }
        }

        form.addEventListener('input', function() {
            const currentData = new FormData(form);
            let isSame = true;

            for (let [key, value] of Object.entries(initialData)) {
                if (value !== currentData.get(key)) {
                    isSame = false;
                    break;
                }
            }

            updateButton.disabled = isSame;
        });
    });
</script>
@endsection

