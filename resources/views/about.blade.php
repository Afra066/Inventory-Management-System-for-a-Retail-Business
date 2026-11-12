<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - iPower System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

        /* Navbar */
        .navbar {
            background: #1a1a2e !important;
            padding: 15px 0;
        }

        .navbar-brand {
            font-size: 28px;
            font-weight: 700;
            color: #fff !important;
        }

        .navbar-brand span {
            color: #00d2ff;
        }

        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: 0.3s;
        }

        .navbar .nav-link:hover {
            color: #00d2ff !important;
        }

        .btn-nav {
            border: 2px solid #00d2ff;
            color: #00d2ff;
            padding: 8px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: 0.3s;
            background: transparent;
            text-decoration: none;
            display: inline-block;
        }

        .btn-nav:hover {
            background: #00d2ff;
            color: #fff;
        }

        /* About Hero */
        .about-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 80px 0 60px;
            color: #fff;
            text-align: center;
        }

        .about-hero h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .about-hero h1 span {
            color: #00d2ff;
        }

        .about-hero p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            max-width: 650px;
            margin: 0 auto;
        }

        /* About Content */
        .about-content {
            padding: 60px 0;
        }

        .about-content h2 {
            font-weight: 700;
            margin-bottom: 30px;
        }

        .about-content h2 span {
            color: #00d2ff;
        }

        .about-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.05);
            height: 100%;
            transition: transform 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .about-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        }

        .about-card i {
            font-size: 40px;
            color: #00d2ff;
            margin-bottom: 15px;
        }

        .about-card h5 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .about-card p {
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats-section {
            padding: 60px 0;
            background: #1a1a2e;
            color: #fff;
        }

        .stats-section .stat-number {
            font-size: 42px;
            font-weight: 800;
            color: #00d2ff;
        }

        .stats-section .stat-label {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Footer */
        .footer {
            background: #1a1a2e;
            color: rgba(255, 255, 255, 0.7);
            padding: 40px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer h6 {
            color: #fff;
            font-weight: 600;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: 0.3s;
        }

        .footer a:hover {
            color: #00d2ff;
        }

        .footer .social-icons a {
            display: inline-block;
            margin-right: 15px;
            font-size: 20px;
        }

        .footer .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .about-hero h1 {
                font-size: 32px;
            }
            .about-hero p {
                font-size: 16px;
            }
            .stats-section .stat-number {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-mobile-alt" style="color: #00d2ff;"></i> iPower <span>System</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item">
                        <a class="btn-nav" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <!-- Register button removed -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Hero -->
    <section class="about-hero">
        <div class="container">
            <h1>About <span>iPower System</span></h1>
            <p>Smart inventory management software for businesses of all sizes.</p>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Who We <span>Are</span></h2>
                    <p style="color: #6c757d; line-height: 1.8;">
                        <strong>iPower System</strong> is a powerful web-based inventory management system designed 
                        to help businesses streamline their operations. We understand the challenges of managing 
                        inventory, sales, and finances manually, and we're here to simplify your business processes.
                    </p>
                    <p style="color: #6c757d; line-height: 1.8;">
                        Our system helps business owners maintain accurate records, generate invoices, track income 
                        and expenses, manage stock, and produce detailed reports through an intuitive online platform.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #00d2ff, #3a7bd5); border: none; padding: 12px 30px; border-radius: 30px;">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="about-card text-center">
                                <i class="fas fa-bullseye"></i>
                                <h5>Our Mission</h5>
                                <p>To empower businesses with smart inventory tools that save time, reduce errors, and increase profitability.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about-card text-center">
                                <i class="fas fa-eye"></i>
                                <h5>Our Vision</h5>
                                <p>To become the leading inventory management solution for businesses worldwide.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about-card text-center">
                                <i class="fas fa-heart"></i>
                                <h5>Our Values</h5>
                                <p>Innovation, simplicity, reliability, and customer satisfaction are at the core of everything we do.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="about-card text-center">
                                <i class="fas fa-users"></i>
                                <h5>Our Users</h5>
                                <p>Trusted by small and medium businesses across retail, wholesale, and e-commerce sectors.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Products Managed</div>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Customers Served</div>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Customer Satisfaction</div>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">System Availability</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="about-content" style="background: #f8f9fa;">
        <div class="container">
            <h2 class="text-center" style="font-weight: 700; margin-bottom: 40px;">Why Choose <span>iPower System</span></h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="about-card text-center">
                        <i class="fas fa-boxes"></i>
                        <h5>Inventory Management</h5>
                        <p>Track stock levels in real-time and get low stock alerts to prevent stockouts.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-card text-center">
                        <i class="fas fa-file-invoice"></i>
                        <h5>Invoice Generation</h5>
                        <p>Create professional invoices quickly and accurately for your customers.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-card text-center">
                        <i class="fas fa-chart-bar"></i>
                        <h5>Reports & Analytics</h5>
                        <p>Generate daily, monthly, and profit & loss reports to track business performance.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-card text-center">
                        <i class="fas fa-users"></i>
                        <h5>Customer Management</h5>
                        <p>Maintain customer records, purchase history, and build lasting relationships.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-card text-center">
                        <i class="fas fa-truck"></i>
                        <h5>Supplier Management</h5>
                        <p>Track supplier information, purchase orders, and payment records.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="about-card text-center">
                        <i class="fas fa-shield-alt"></i>
                        <h5>Data Security</h5>
                        <p>Your data is securely stored and accessible only to authorized users with role-based access.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h6><i class="fas fa-mobile-alt" style="color: #00d2ff;"></i> iPower System</h6>
                    <p style="font-size: 14px;">Smart inventory management software for businesses of all sizes.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h6>Pages</h6>
                    <a href="/">Home</a>
                    <a href="{{ route('about') }}">About Us</a>
                    <a href="#contact">Contact</a>
                </div>
                <div class="col-md-2">
                    <h6>Features</h6>
                    <a href="#">Inventory</a>
                    <a href="#">Invoices</a>
                    <a href="#">Reports</a>
                </div>
                <div class="col-md-2">
                    <h6>Support</h6>
                    <a href="#">Help Center</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms</a>
                </div>
                <div class="col-md-2">
                    <h6>Get Started</h6>
                    <a href="{{ route('login') }}">Login</a>
                    <!-- Register link removed -->
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2026 iPower System. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>