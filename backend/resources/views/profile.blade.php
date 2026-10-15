@php
    // Uploaded avatars live in storage/, presets live in public/images/
    $avatarUrl = $user->avatar
        ? (str_starts_with($user->avatar, 'avatars/') ? asset('storage/' . $user->avatar) : asset($user->avatar))
        : asset('images/default-avatar.png');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Omkeeli Store</title>
</head>
<body>
    <h1>PROFILE</h1>

    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Profile summary -->
    <div>
        <img src="{{ $avatarUrl }}" alt="Avatar" width="120" height="120" id="avatarPreviewImg">
        <h2>{{ $user->name }}</h2>
        <div>{{ $user->email }}</div>
        <div>Registered User</div>
    </div>

    <h2>Account Profile &amp; Delivery Settings</h2>

    <form method="POST" action="{{ url('/profile') }}" enctype="multipart/form-data">
        @csrf

        <!-- Change Profile Picture -->
        <fieldset>
            <legend>Change Profile Picture</legend>

            <div>
                <input type="file" name="avatar_file" id="avatarFileInput" accept="image/*" onchange="previewSelectedAvatar(this)">
                <span id="avatarFileName">No custom file selected</span>
            </div>

            <p>Or pick a signature avatar preset:</p>
            <input type="hidden" name="preset_avatar" id="presetAvatarInput" value="">
            <div>
                @foreach ($presets as $preset)
                    <button type="button" onclick="selectPreset('{{ $preset }}', '{{ asset($preset) }}')" title="{{ basename($preset) }}">
                        <img src="{{ asset($preset) }}" alt="{{ basename($preset) }}" width="48" height="48">
                    </button>
                @endforeach
            </div>
        </fieldset>

        <div>
            <label>Full Name *</label><br>
            <input type="text" name="name" required value="{{ old('name', $user->name) }}">
        </div>

        <div>
            <label>Email Address</label><br>
            <input type="email" disabled value="{{ $user->email }}">
        </div>

        <div>
            <label>Mobile Number (11 Digits)</label><br>
            <input type="tel"
                   name="phone"
                   maxlength="11"
                   inputmode="numeric"
                   pattern="[0-9]{11}"
                   oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11)"
                   placeholder="09XXXXXXXXX (11 digits)"
                   value="{{ old('phone', $user->phone) }}">
        </div>

        <div>
            <label>Default Delivery Address</label><br>
            <input type="text" name="address" placeholder="Street, Barangay, City" value="{{ old('address', $user->address) }}">
        </div>

        <div>
            <label>Change Password (leave blank to keep current password)</label><br>
            <input type="password" name="new_password" placeholder="New Password">
        </div>

        <button type="submit">Save Profile Changes</button>
    </form>

    <p><a href="{{ url('/') }}">&larr; Back</a></p>

    <script>
        function previewSelectedAvatar(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                document.getElementById('avatarFileName').innerText = file.name;
                document.getElementById('presetAvatarInput').value = '';

                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatarPreviewImg').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function selectPreset(path, url) {
            document.getElementById('presetAvatarInput').value = path;
            document.getElementById('avatarFileInput').value = '';
            document.getElementById('avatarFileName').innerText = 'Preset: ' + path.split('/').pop();
            document.getElementById('avatarPreviewImg').src = url;
        }
    </script>
</body>
</html>