@extends('layouts.app1')

@section('content')
    <h2>Login</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        
        <button type="submit" class="btn btn-success">Login</button>
    </form>
@endsection
