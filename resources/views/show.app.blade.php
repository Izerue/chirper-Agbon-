<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->username }}'s Profile</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-blueTheme-light text-blueTheme-dark font-sans">
    <div class="profile-container max-w-4xl mx-auto p-6 bg-blueTheme-light rounded-lg shadow-lg">
        <!-- Profile Header Section -->
        <div class="profile-header text-center mb-5">
            <!-- Display Profile Picture -->
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('default-avatar.png') }}" 
                 alt="{{ $user->username }}'s profile picture" 
                 class="profile-picture w-32 h-32 rounded-full object-cover mb-4 border-2 border-blueTheme-accent">

            <h1 class="text-blueTheme-dark text-2xl font-bold">{{ $user->username }}</h1>
            <p class="text-blueTheme-dark text-lg">{{ $user->bio }}</p>

            <!-- Show form to update profile picture if logged-in user is the same as this profile -->
            @if(auth()->check() && auth()->user()->id === $user->id)
                <form action="{{ route('profile.updatePicture', $user->username) }}" method="POST" enctype="multipart/form-data" class="profile-picture-form mt-4">
                    @csrf
                    <label for="profile_picture" class="block text-blueTheme-dark font-medium mb-2">Change Profile Picture:</label>
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="block w-full text-sm text-blueTheme-dark border border-blueTheme-accent rounded-lg p-2 mb-3">
                    <button type="submit" class="bg-blueTheme-dark text-white font-bold py-2 px-4 rounded hover:bg-blueTheme-accent transition">Upload</button>
                </form>
                
                @if(session('success'))
                    <p class="success-message text-green-600 mt-2">{{ session('success') }}</p>
                @endif
            @endif
        </div>

        <!-- Display Recent Chirps -->
        <div class="profile-chirps">
            <h2 class="text-xl font-semibold mb-4">Recent Chirps</h2>
            @forelse($chirps as $chirp)
                <div class="chirp p-4 bg-white rounded-lg shadow mb-3">
                    <p class="text-blueTheme-dark">{{ $chirp->content }}</p>
                    <small class="text-gray-600">Posted on {{ $chirp->created_at->format('M d, Y') }}</small>
                </div>
            @empty
                <p class="text-gray-600">No chirps yet!</p>
            @endforelse
        </div>
    </div>

    <!-- Optional: Add JavaScript for Enhanced File Input (Optional for preview, validation, etc.) -->
    <script>
        // You can add some JavaScript here for additional features, like previewing the image before uploading
    </script>
</body>
</html>
