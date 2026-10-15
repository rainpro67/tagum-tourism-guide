<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h1>SIGN UP</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ url('/signup') }}">
        @csrf

        <div>
            <input type="text" name="name" placeholder="Full Name" required value="{{ old('name') }}">
        </div>

        <div>
            <input type="email" name="email" placeholder="Email Address" required value="{{ old('email') }}">
        </div>

        <div>
            <input type="password" name="password" placeholder="Password (min 6 characters)" required>
        </div>

        <div>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        </div>

        <button type="submit">Sign Up</button>
    </form>
</body>
</html>