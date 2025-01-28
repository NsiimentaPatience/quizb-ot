<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QUIZBOT</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        .nav-tabs .nav-link {
                color: #FFD700; /* Gold */
            }

            .nav-tabs .nav-link.active {
                background-color: #b38ff9; /* Deep Blue */
            }

        .footer-custom {
            background-color: rgba(0, 0, 0, 0.8); /* Dark background with transparency */
        }

        footer h5 {
            color: white;
            font-weight: bold;
        }

        footer p, footer a {
            color: white;
        }

        footer a:hover {
            color: #ddd;
            text-decoration: none;
        }
        .modal-content {
            border-radius: 12px; /* Rounded corners for the modal */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        .modal-header {
            border-bottom: none; /* Remove border */
        }

        .modal-body {
            padding: 2rem; /* Padding for the modal body */
        }

        .btn-primary {
            background-color: #007bff; /* Bootstrap primary color */
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .btn-danger {
            background-color: #dc3545; /* Bootstrap danger color */
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333; /* Darker red on hover */
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #b38ff9;">
        <div class="container d-flex justify-content-between">
            <!-- Right-Aligned Logo -->
            <a class="navbar-brand" href="#">
                <img src="/images/logo.png" alt="Logo" height="60"> <!-- Adjust logo size as needed -->
            </a>
            <!-- Centered Navigation Links -->
            <div class="navbar-nav mx-auto d-flex flex-row justify-content-center">
                <a class="nav-link mx-3" href="{{ url('/books') }}" style="box-shadow: none; padding: 0;">
                    <i class="fas fa-home" style="color: white; font-size: 24px;"></i>
                </a>
                <a class="nav-link mx-3" href="{{ url('/settings') }}" style="box-shadow: none; padding: 0;">
                    <i class="fas fa-cog" style="color: white; font-size: 24px;"></i>
                </a>
                <a class="nav-link mx-3" href="{{ url('/') }}" style="box-shadow: none; padding: 0;">
                    <i class="fas fa-user" style="color: white; font-size: 24px;"></i>
                </a>
                <a class="nav-link mx-3" href="{{ url('/user/multiple') }}" style="box-shadow: none; padding: 0;">
                    <i class="fas fa-users" style="color: white; font-size: 24px;"></i>
                </a>
                <!-- New Review Button -->
                <a class="btn btn-warning mx-3" href="{{ route('reviews.index') }}" style="color: #000; font-weight: bold;">Reviews
                </a>
            </div>
            

            <!-- Profile Avatar -->
<div class="d-flex align-items-center">
    <img 
        src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('default-avatar.png') }}" 
        alt="Profile Avatar" 
        class="img-fluid rounded-circle" 
        style="width: 40px; height: 40px; cursor: pointer;" 
        data-bs-toggle="modal" 
        data-bs-target="#profileModal"
    />
</div>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Hello {{ auth()->user()->username }}!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="position-relative d-inline-block">
                        <img 
                            src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : asset('default-avatar.png') }}" 
                            alt="Profile Picture" 
                            class="img-fluid rounded-circle mb-3" 
                            style="width: 120px; height: 120px;"
                        />
                        <!-- Camera Emoji Overlay -->
                        <label for="profilePictureInput" class="position-absolute bottom-0 end-0 bg-dark text-white rounded-circle p-1" style="cursor: pointer; font-size: 1.5rem;">
                            📷
                        </label>
                        <!-- Hidden File Input -->
                        <input 
                            type="file" 
                            name="profile_picture" 
                            id="profilePictureInput" 
                            accept="image/*" 
                            class="d-none" 
                            onchange="document.getElementById('profileForm').submit();"
                        />
                    </div>

                    <h6 class="mb-1">{{ auth()->user()->username }}</h6>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-dark">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

                
            
    </nav>
    
    
    <div class="container mt-4">
        @yield('content')
    </div>

    <footer class="footer-custom py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="QuizBot Logo" class="me-2" style="width: 80px; height: 80px; object-fit: contain; border-radius: 50%;">
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Home</a></li>
                        <li><a href="#" class="text-white">Services</a></li>
                        <li><a href="#" class="text-white">Contact</a></li>
                        <li><a href="#" class="text-white">About</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>Email: quizbotappafrica@gmail.com</p>
                    <p>Phone: +256786259893</p>
                    <p>Address: Kampala, Uganda</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col text-center">
                    <p>&copy; 2024 QuizBot. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
</body>
</html>
