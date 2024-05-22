@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rent {{ $product->name }}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rents.store') }}" method="POST">
        @csrf

        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="form-group">
            <label for="rent_start_date">Start Date</label>
            <input type="date" id="rent_start_date" name="rent_start_date" class="form-control @error('rent_start_date') is-invalid @enderror" required>
            @error('rent_start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="rent_end_date">End Date</label>
            <input type="date" id="rent_end_date" name="rent_end_date" class="form-control @error('rent_end_date') is-invalid @enderror" required>
            @error('rent_end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>



        <p>Total price: $<span id="total_price">0.00</span></p>

        <button type="submit" class="btn btn-primary">Rent</button>
    </form>
    <form action="{{ route('payment.handle') }}" method="POST">
    @csrf
</form>


    <script>
        // Get the date input fields
        var startDateInput = document.getElementById('rent_start_date');
        var endDateInput = document.getElementById('rent_end_date');

        // Get the product price from the server-side
        var dailyRate = {{ $product->price }};

        // Function to calculate the price
        function calculatePrice() {
            var startDate = new Date(startDateInput.value);
            var endDate = new Date(endDateInput.value);

            // Calculate the number of days between the start date and the end date
            var diffTime = Math.abs(endDate - startDate);
            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            // Initialize the total price
            var totalPrice = 0;

            // Loop through each day to calculate the price
            for (var i = 0; i < diffDays; i++) {
                var currentDate = new Date(startDate.getTime() + (i * 24 * 60 * 60 * 1000));

                // Check if the day is a weekend or a special day
                if (currentDate.getDay() === 0 || currentDate.getDay() === 6) {
                    // Increase the rate for weekends
                    totalPrice += dailyRate * 1.5;
                } else {
                    // Normal rate for weekdays
                    totalPrice += dailyRate;
                }
            }

            // Display the total price on the page
            document.getElementById('total_price').textContent = totalPrice.toFixed(2);
        }

        // Add event listeners to the date input fields
        startDateInput.addEventListener('change', calculatePrice);
        endDateInput.addEventListener('change', calculatePrice);

        // Set the minimum date to today for both date input fields
        var today = new Date().toISOString().split('T')[0];
        startDateInput.setAttribute('min', today);
        endDateInput.setAttribute('min', today);
    </script>
</div>
@endsection
