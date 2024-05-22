@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Management</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Creation Date</th>
                <th>Status</th>
                <th>Ban User</th>
                <th>Products</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        @if($user->bans->isNotEmpty() && $user->bans->first()->expired_at > now())
                            Banned until {{ $user->bans->first()->expired_at }}
                            <form action="{{ route('user.unban', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Remove Ban</button>
                            </form>
                        @else
                            Active
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('user.ban', $user->id) }}" method="POST" class="form-inline">
                            @csrf
                            <div class="form-group mb-2">
                                <select name="ban_duration" class="form-control">
                                    <option value="8">8 hours</option>
                                    <option value="12">12 hours</option>
                                    <option value="24">1 day</option>
                                    <option value="72">3 days</option>
                                    <option value="168">1 week</option>
                                    <option value="720">1 month</option>
                                    <option value="8760">1 year</option>
                                    <option value="permanent">Permanent</option>
                                </select>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <button type="submit" class="btn btn-warning">Ban</button>
                            </div>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('user.products', $user->id) }}" class="btn btn-info">View Products</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <td>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
        </td>
    </table>
    {{ $users->links() }}
</div>
@endsection
