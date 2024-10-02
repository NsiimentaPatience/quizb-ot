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
</head>
<body>
    <header class="banner">
        <div class="container">
            <div class="row h-100 align-items-center">
                <!-- Carousel Column -->
                <div class="col-lg-6">
                    <div id="carouselExampleControls" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <div class="carousel-caption">
                                        <h5>Welcome to QuizBot Bible </h5>
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
                                        <p> Faith: We're committed to upholding the integrity and authority of Scripture.<br>
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
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <div class="card-container">
                        <div class="card mx-auto">
                            <div class="card-body text-center">
                                <img src="/images/logo.png" alt="Logo" class="card-logo mb-3"> <!-- Update with your logo path -->
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="signup-tab" data-bs-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Sign Up</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <!-- Login Form -->
                                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                        <form method="POST" action="/login">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="loginEmail" class="form-label">Email address</label>
                                                <input type="email" class="form-control" id="loginEmail" name="email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="loginPassword" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="loginPassword" name="password" required>
                                            </div>
                                            <button type="submit" class="btn btn-dark">Login</button>
                                        </form>
                                    </div>
                                
                                    <!-- Signup Form -->
                                    <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                                        <form method="POST" action="/signup">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="signupName" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="signupName" name="name" required>
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
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
