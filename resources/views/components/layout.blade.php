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
            </div>
            <!-- Smaller Logout Button without Shadow or Extra Space -->
            <div class="d-flex align-items-center" style="padding: 0; margin: 0;">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm" 
                            style="font-weight: bold; padding: 5px 10px; box-shadow: none; margin: 0;">
                        Logout
                    </button>
                </form>
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
                    <h5>About Us</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do e.</p>
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
                    <p>Address: Kampala, Uganda</p>
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
