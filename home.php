<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SLT-Mobitel</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    >
  <style>
    /* Logo Styling */
    .navbar .logo {
      padding-left: 1rem; /* Add some padding to the left */
    }

    .navbar .logo img {
      height: 80px; /* Adjust the height of the logo */
      width: auto; /* Maintain aspect ratio */
      object-fit: contain; /* Prevent distortion */
      transition: transform 0.3s ease; /* Smooth scaling effect on hover */
    }

    /* Optional hover effect for the logo */
    .navbar .logo img:hover {
      transform: scale(1.1); /* Slightly enlarge the logo on hover */
    }

    /* Responsive Logo Positioning */
    @media (max-width: 768px) {
        .navbar .container {
            padding: 0 1rem;
        }
        
        .navbar .logo img {
            height: 50px;
        }
    }

    /* General Styles */

    body {
      background-image: url('https://cdn.pixabay.com/photo/2020/10/21/01/56/digital-5671888_1280.png'); /* Correct syntax */
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
    }

    /* Content Wrapper */
    .content-wrapper {
      flex: 1;
    }

    /* Navbar */
    .navbar {
      background-color: rgb(0, 8, 53);
      padding: 1rem 0; /* Reduced horizontal padding */
      border-bottom: 2px solid rgb(255, 255, 255);
    }

    .navbar .container {
      max-width: 100%; /* Make container full width */
      padding: 0 2rem; /* Add some padding on the sides */
      margin: 0; /* Remove default margin */
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
    }

    .navbar-brand {
      color: white !important;
      font-weight: bold;
      
    }

    .navbar-nav {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 2rem; /* Increase space between nav items */
    }

    .nav-link {
      font-size: 19px;
      color: #cce5ff !important;
      transition: color 0.3s ease;
      padding: 0.5rem 1rem;
    }

    .nav-link:hover {
      color:rgb(67, 155, 255) !important;
    }

    /* Button Group */
    .d-flex {
        margin-left: 2rem; /* Space between nav items and buttons */
        display: flex;
        gap: 1rem; /* Reduced gap between buttons */
    }

    .btn-custom {
        border: 2px solid #0056A2; /* Reduced border thickness */
        border-radius: 15px;
        color: #cce5ff;
        background-color: #4CAF50;
        padding: 8px 20px; /* Slightly reduced padding */
        font-size: 16px;
        white-space: nowrap;
        min-width: 90px; /* Set minimum width for consistency */
        text-align: center;
    }

    .btn-custom:hover {
      color: #cce5ff; /* Changed from white to light blue */
      background-color: #0056A2;
      border: 3px solid #4CAF50;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .d-flex {
            margin-left: 0;
            margin-top: 1rem;
            gap: 0.3rem; /* Even smaller gap on mobile */
        }
        
        .btn-custom {
            padding: 6px 12px;
            font-size: 14px;
            min-width: 80px;
        }
    }

    /* Hero Section */
    .hero-section {
      background: linear-gradient(135deg, rgba(0, 8, 53, 0.8), rgba(0, 8, 53, 0.9)); /* Darker background */
      color: #cce5ff; /* Changed from white to light blue */
      padding: 6rem 2rem;
      text-align: center;
      border-radius: 15px;
      margin: 7rem auto;
      width: 90%;
      max-width: 1200px;
      box-shadow: 0 8px 15px rgba(255, 255, 255, 0.5); /* Changed to green shadow */
    }

    .hero-section h1 {
      font-size: 3rem;
      font-weight: bold;
    }

    .hero-section p {
      font-size: 1.2rem;
      margin: 1rem 0;
    }

    .hero-section a {
      background-color: #4CAF50; /* Changed from white to green */
      color: #cce5ff; /* Changed to light blue */
      padding: 10px 25px;
      border-radius: 20px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .hero-section a:hover {
      background-color: #45a049; /* Darker green on hover */
      color: white;
    }

    @media (max-width: 768px) {
        .hero-section {
          padding: 2rem 1rem;
        }

        .hero-section h1 {
          font-size: 2rem;
        }

        .hero-section p {
          font-size: 0.9rem;
        }

        .hero-section a {
          padding: 8px 20px;
        }
      }


    /* Footer */
    .footer {
        background-color: rgb(0, 8, 53);
        color: #cce5ff; /* Changed from white to light blue */
        padding: 1rem;
        text-align: left;
        font-size: 0.9rem;
        border-top: 2px solid rgb(255, 255, 255); /* Changed from white to green */
    }

    .footer p {
      margin: 0;
    }

    @media (max-width: 768px) {
        .footer {
          font-size: 0.8rem;
        }
      }

    /* Add these new styles for the navbar toggler */
    .navbar-toggler {
        border: 2px solid white !important;
        padding: 0.25rem 0.5rem;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
    }

    /* Update media queries */
    @media (max-width: 768px) {
        .navbar-nav {
            gap: 1rem;
            margin: 1rem 0;
        }
        
        .d-flex {
            margin-left: 0;
            margin-top: 1rem;
        }
        
        .btn-custom {
            padding: 6px 15px;
            font-size: 15px;
        }
    }

    /* Add these styles to your existing CSS */
    .card {
        background: rgba(0, 8, 53, 0.7) !important;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: transform 0.3s ease;
        box-shadow: 0 8px 15px rgba(255, 255, 255, 0.5); /* Changed to green shadow */
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .objectives-list li {
        padding: 10px;
        margin: 10px 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .objectives-list li:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.02);
    }

    h2 {
        color: #4CAF50;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .card-text {
        line-height: 1.8;
        font-size: 1.1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-text {
            font-size: 1rem;
        }
        
        .objectives-list li {
            padding: 8px;
            margin: 8px 0;
        }
    }

  </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <!-- Logo on the far left -->
        <a href="#" class="logo">
          <img src="https://www.sltdigitallab.lk/wp-content/uploads/2021/01/cropped-slt-log-removebg-1-382x144.png" alt="Company Logo">
        </a>
        
        <!-- Hamburger menu for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navigation items and buttons on the right -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Projects</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Studios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Join with us</a>
            </li>
            <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="contactDropdown" role="button" data-bs-toggle="dropdown">
            Contact
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="contact.php">Contact Us</a></li>
            <li><a class="dropdown-item" href="feedback.php">Feedback</a></li>
          </ul>
        </li>
          </ul>
          <div class="d-flex">
            <a href="register.php" class="btn btn-light btn-sm btn-custom">Signup</a>
            <a href="login.php" class="btn btn-light btn-sm btn-custom">Login</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Hero Section -->
        <section class="hero-section">
            <h1>Welcome to SLT-Mobitel Digital Lab</h1>
            <p>Official Website of Sri Lanka Telecom Digital Lab</p>
            
        </section>

        <!-- Vision, Mission, and Objectives -->
        <div class="container cards-container">
            <div class="row">
                <!-- Vision Section -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 bg-transparent border-0">
                        <div class="card-body">
                            <h2 class="card-title text-center text-white mb-4">Vision</h2>
                            <p class="card-text text-white text-center">
                                Be The Catalyst In Creating The Green Society By Way Of Developing Applications And Technologies, Uplifting Lifestyle Globally.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Mission Section -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 bg-transparent border-0">
                        <div class="card-body">
                            <h2 class="card-title text-center text-white mb-4">Mission</h2>
                            <p class="card-text text-white text-center">
                                Building The Incubation And Accelerator Ecosystem For Research & Development By Harnessing The Best Talents Through Innovation And Rapid Adoption Of Technology Advancements To Make Competitive Edge In The Market.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Objectives Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card bg-transparent border-0">
                        <div class="card-body">
                            <h2 class="card-title text-center text-white mb-4">Objectives</h2>
                            <div class="objectives-list text-white">
                                <ul class="list-unstyled text-center">
                                    <li class="mb-3">Enhance Business Value and Revenue</li>
                                    <li class="mb-3">Reduce inefficiencies and leakages</li>
                                    <li class="mb-3">Enhancing trust and openness</li>
                                    <li class="mb-3">Reduce energy consumption</li>
                                    <li class="mb-3">Connect digitally</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
      <p>&copy; 2025 SLT-Mobitel. All rights reserved.</p>
    </footer>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
