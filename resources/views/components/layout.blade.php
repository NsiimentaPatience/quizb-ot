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
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        .footer-custom {
            background-color: rgba(0, 0, 0, 0.8); /* Dark background with transparency */
        }

        footer h5 {
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
    <nav class="navbar navbar-expand-lg" style="background-color: #6e34eb;">
        <div class="container d-flex justify-content-between">
            <!-- Right-Aligned Logo -->
            <a class="navbar-brand" href="#">
                <img src="/images/logo.png" alt="Logo" height="60"> <!-- Adjust logo size as needed -->
            </a>
            <div class="navbar-nav mx-auto d-flex flex-row justify-content-center">
                <a class="nav-link mx-3" href="{{ url('/books') }}">
                    <i class="fas fa-home" style="color: white; font-size: 24px;"></i>
                </a>
                <a class="nav-link mx-3" href="{{ url('/settings') }}">
                    <i class="fas fa-cog" style="color: white; font-size: 24px;"></i>
                </a>
                <a class="nav-link mx-3" href="{{ url('/') }}">
                    <i class="fas fa-user" style="color: white; font-size: 24px;"></i>
                </a>
                <a class="nav-link mx-3" href="{{ url('/user/multiple') }}">
                    <i class="fas fa-users" style="color: white; font-size: 24px;"></i>
                </a>
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
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
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
                    <p>Email: info@example.com</p>
                    <p>Phone: +123456789</p>
                    <p>Address: 123 Main St, City, Country</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col text-center">
                    <p>&copy; 2024 MyApp. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
