<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iPower System - Smart Inventory Management</title>
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
            background: #fff;
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

        .navbar .nav-link.active {
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

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 100px 0 80px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(0, 210, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .hero h1 span {
            color: #00d2ff;
        }

        .hero p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 30px;
            max-width: 500px;
        }

        .hero .btn-hero {
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            color: #fff;
            padding: 15px 40px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 18px;
            text-decoration: none;
            transition: transform 0.3s;
            display: inline-block;
            border: none;
        }

        .hero .btn-hero:hover {
            transform: translateY(-3px);
            color: #fff;
        }

        .hero .btn-hero-outline {
            border: 2px solid #00d2ff;
            color: #00d2ff;
            padding: 15px 40px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 18px;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            margin-left: 15px;
            background: transparent;
        }

        .hero .btn-hero-outline:hover {
            background: #00d2ff;
            color: #fff;
        }

        .hero-image {
            text-align: center;
            padding: 20px;
        }

        .hero-image img {
            max-height: 450px;
            width: 100%;
            object-fit: contain;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s;
            background: rgba(0, 0, 0, 0.2);
        }

        .hero-image img:hover {
            transform: scale(1.02);
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .features h2 {
            text-align: center;
            font-weight: 700;
            font-size: 36px;
            margin-bottom: 15px;
        }

        .features h2 span {
            color: #00d2ff;
        }

        .features .subtitle {
            text-align: center;
            color: #6c757d;
            margin-bottom: 50px;
            font-size: 18px;
        }

        .feature-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
        }

        .feature-card i {
            font-size: 50px;
            color: #00d2ff;
            margin-bottom: 20px;
        }

        .feature-card h5 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: #6c757d;
            font-size: 14px;
        }

        /* Stats Section */
        .stats {
            padding: 60px 0;
            background: #1a1a2e;
            color: #fff;
        }

        .stats .stat-number {
            font-size: 42px;
            font-weight: 800;
            color: #00d2ff;
        }

        .stats .stat-label {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* CTA Section */
        .cta {
            padding: 80px 0;
            background: linear-gradient(135deg, #00d2ff, #3a7bd5);
            color: #fff;
            text-align: center;
        }

        .cta h2 {
            font-size: 36px;
            font-weight: 700;
        }

        .cta p {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .cta .btn-cta {
            background: #fff;
            color: #00d2ff;
            padding: 15px 50px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 18px;
            text-decoration: none;
            transition: transform 0.3s;
            display: inline-block;
            border: none;
        }

        .cta .btn-cta:hover {
            transform: translateY(-3px);
            color: #00d2ff;
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

        /* Responsive */
        @media (max-width: 768px) {
            .hero {
                text-align: center;
                padding: 60px 0;
            }
            .hero h1 {
                font-size: 32px;
            }
            .hero p {
                max-width: 100%;
            }
            .hero .btn-hero-outline {
                margin-left: 0;
                margin-top: 10px;
            }
            .hero-image img {
                max-height: 250px;
                margin-top: 20px;
            }
            .features h2 {
                font-size: 28px;
            }
            .stats .stat-number {
                font-size: 30px;
            }
            .navbar-brand {
                font-size: 22px;
            }
            .btn-nav {
                padding: 6px 18px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 26px;
            }
            .hero .btn-hero {
                padding: 12px 25px;
                font-size: 15px;
            }
            .hero .btn-hero-outline {
                padding: 12px 25px;
                font-size: 15px;
            }
            .hero-image img {
                max-height: 200px;
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
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Smart, Simple, Online <span>Inventory Management</span></h1>
                    <p>Busy business owners like you can manage your inventory, sales, and finances online in one place.</p>
                    <div>
                        <a href="{{ route('login') }}" class="btn-hero">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="#features" class="btn-hero-outline">
                            <i class="fas fa-play"></i> See Features
                        </a>
                    </div>
                    <div class="mt-4">
                        <small style="color: rgba(255,255,255,0.5);">
                            <i class="fas fa-check-circle" style="color: #00d2ff;"></i> Secure Employee Access Only
                        </small>
                    </div>
                </div>
                <div class="col-lg-6 hero-image">
                    <img src="{{ asset('images/dashboard-preview.png') }}" 
                         alt="iPower Dashboard Preview"
                         loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2>Why Choose <span>iPower System</span></h2>
            <p class="subtitle">Everything you need to manage your inventory efficiently</p>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-boxes"></i>
                        <h5>Inventory Management</h5>
                        <p>Stay on top of your orders and quantities while managing your inventory in real-time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-file-invoice"></i>
                        <h5>Invoice Generation</h5>
                        <p>Create professional invoices quickly and get paid twice as fast as paper invoicing.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-bar"></i>
                        <h5>Reports & Analytics</h5>
                        <p>See how your business is doing with customizable sales and profit reports.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-users"></i>
                        <h5>Customer Management</h5>
                        <p>Manage customer information, purchase history, and build lasting relationships.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-truck"></i>
                        <h5>Supplier Management</h5>
                        <p>Keep track of suppliers, payment records, and streamline your supply chain.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt"></i>
                        <h5>Data Security</h5>
                        <p>Your data is securely stored and backed up, accessible only to authorized users.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
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

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Simplify Your Business?</h2>
            <p>Join thousands of business owners who trust iPower System for their inventory management.</p>
            <a href="{{ route('login') }}" class="btn-cta">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
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
                    <h6>Product</h6>
                    <a href="#features">Features</a>
                    <a href="#">Pricing</a>
                    <a href="#">Integrations</a>
                </div>
                <div class="col-md-2">
                    <h6>Company</h6>
                    <a href="{{ route('about') }}">About Us</a>
                    <a href="#">Blog</a>
                    <a href="#">Careers</a>
                </div>
                <div class="col-md-2">
                    <h6>Support</h6>
                    <a href="#">Help Center</a>
                    <a href="#contact">Contact Us</a>
                    <a href="#">Privacy Policy</a>
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