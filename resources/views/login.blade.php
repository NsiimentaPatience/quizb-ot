<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QUIZBOT</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    
    <style>
        .country-select {
            max-width: 300px; /* Adjust the maximum width as needed */
            width: 100%; /* Allow it to be responsive */
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center">
            <!-- Carousel Column -->
            <div class="col-lg-6">
                <div id="carouselExampleControls" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="carousel-caption">
                                    <h5>Welcome to QuizBot Bible</h5>
                                    <p>We're passionate about helping people of all ages and backgrounds explore the Bible in a way that's engaging, interactive, and fun! Our website is designed to make Scripture come alive through games, quizzes, and community discussions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="carousel-caption">
                                    <h5>Our Story</h5>
                                    <p>Our team of Bible enthusiasts, educators, and tech experts came together with a shared vision: to create a platform that makes Bible study enjoyable and accessible for everyone. We believe that learning about God's Word should be an exciting adventure, not a chore.</p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="carousel-caption">
                                    <h5>Our Mission</h5>
                                    <p>Our mission is to inspire a love for the Bible and its teachings by providing innovative and interactive tools for learning. We strive to:<br>
                                        Make Bible study fun and engaging for all ages<br>
                                        Provide accurate and reliable resources for Scripture exploration<br>
                                        Foster a supportive community for discussion and growth<br>
                                        Continuously innovate and improve our platform to meet the evolving needs of our users
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="carousel-caption">
                                    <h5>Our Values</h5>
                                    <p>Faith: We're committed to upholding the integrity and authority of Scripture.<br>
                                        Fun: We believe learning should be enjoyable and engaging!<br>
                                        Community: We're dedicated to building a supportive and inclusive community of Bible learners.<br>
                                        Innovation: We're passionate about leveraging technology to enhance Bible study.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="carousel-caption">
                                    <h5>Join Our Journey!</h5>
                                    <p>At QuizBot Africa, we're excited to embark on this adventure with you! Explore our website, share your ideas, and let's learn together!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>


                            <!-- Card Column -->
            <div class="col-lg-6 col-md-12 d-flex justify-content-center align-items-center">
                <div class="card-container">
                    <div class="card mx-auto">
                        <div class="card-body text-center">
                            <img src="/images/logo.png" alt="Logo" class="card-logo mb-3">

                            <!-- Flash Messages -->
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <!-- Tab Navigation for Login and Sign Up -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="signup-tab" data-bs-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Sign Up</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <!-- Single Login Form for Both User and Admin -->
                                <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="login" class="form-label">Username or Email</label>
                                            <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" required>
                                            @error('login')
                                                <span style="color: white">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            @error('password')
                                                <span style="color: white">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-dark" style="color: #b38ff9">Login</button>
                                    </form>
                                </div>

                                <!-- Signup Form -->
                                <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                                    <form method="POST" action="{{ route('signup.submit') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="signupUsername" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="signupUsername" name="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="signupEmail" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="signupEmail" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="signupPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="signupPassword" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="signupPasswordConfirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="signupPasswordConfirmation" name="password_confirmation" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="signupCountry" class="form-label">Country</label>
                                            <select class="form-select" id="signupCountry" name="country" required>
                                                <option value="" disabled selected>Select your country</option>
                                                <!-- Country options will be populated here -->
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-dark">Sign Up</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Handle tab navigation
        const tabLinks = document.querySelectorAll('.nav-link');
        const tabContents = document.querySelectorAll('.tab-pane');

        tabLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Remove 'active' class from all links and hide all tab contents
                tabLinks.forEach(link => link.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('show', 'active'));

                // Add 'active' class to the clicked link
                this.classList.add('active');

                // Show the corresponding tab content
                const target = this.getAttribute('href');
                document.querySelector(target).classList.add('show', 'active');
            });
        });

        // Fetch countries from the RestCountries API
        const countrySelect = document.getElementById('signupCountry');

        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(countries => {
                // Sort countries alphabetically by name
                countries.sort((a, b) => a.name.common.localeCompare(b.name.common));

                // Populate the country dropdown
                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name.common; // or use country.cca2 for country code
                    option.textContent = country.name.common;
                    countrySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching countries:', error));
    });
</script>

</html>
