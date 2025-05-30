<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentora | Telkom University's Premier Learning & Freelancing Platform</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a3e 50%, #2d1b69 100%);
            color: #fff;
            overflow-x: hidden;
        }

        /* Animated background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.1;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, #3b82f6, #8b5cf6);
            animation: float 20s infinite linear;
        }

        .floating-shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: -7s;
        }

        .floating-shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 30%;
            left: 80%;
            animation-delay: -14s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-20px) rotate(90deg); }
            50% { transform: translateY(0px) rotate(180deg); }
            75% { transform: translateY(20px) rotate(270deg); }
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(15, 15, 35, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(59, 130, 246, 0.2);
            padding: 1rem 2rem;
        }

        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: #3b82f6;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary:hover {
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Main content */
        .main-content {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            margin-top: 80px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .hero-section {
            text-align: center;
            margin-bottom: 4rem;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #3b82f6;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { box-shadow: 0 0 5px rgba(59, 130, 246, 0.2); }
            to { box-shadow: 0 0 20px rgba(59, 130, 246, 0.4); }
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff, #e2e8f0, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #e2e8f0;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .btn-hero {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 15px;
        }

        /* Features section */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .feature-desc {
            color: #cbd5e1;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        /* Stats section */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
            text-align: center;
        }

        .stat-item {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #3b82f6;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #e2e8f0;
            font-weight: 500;
        }

        /* University badge */
        .university-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 3rem 0;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .university-logo {
            width: 40px;
            height: 40px;
            background: #dc2626;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .nav-content {
                flex-direction: column;
                gap: 1rem;
            }

            .main-content {
                padding: 0 1rem;
                margin-top: 120px;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-hero {
                width: 100%;
                max-width: 300px;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }

            .feature-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background -->
    <div class="bg-animation">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="nav-content">
            <div class="logo">
                <div class="logo-icon">M</div>
                <span>Mentora</span>
            </div>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn btn-secondary">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="main-content">
        <div class="container">
            <!-- Hero section -->
            <section class="hero-section">
                <div class="hero-badge">
                    🎓 Exclusively for Telkom University Students
                </div>
                <h1 class="hero-title">
                    Connect, Learn & <br>Earn Together
                </h1>
                <p class="hero-subtitle">
                    Mentora is Telkom University's premier platform connecting talented students with those seeking expertise. Whether you're looking to teach, learn, or hire freelance services—we've got you covered.
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-hero">
                        🚀 Join as Student
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-hero">
                        💼 Become a Tutor
                    </a>
                </div>
            </section>

            <!-- University badge -->
            <div class="university-badge">
                <div class="university-logo">T</div>
                <span>Proudly serving <strong>Telkom University</strong> community</span>
            </div>

            <!-- Stats -->
            <section class="stats">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Active Students</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Expert Tutors</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Sessions Completed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </section>

            <!-- Features -->
            <section class="features">
                <div class="feature-card">
                    <div class="feature-icon">🎓</div>
                    <h3 class="feature-title">Expert Tutoring</h3>
                    <p class="feature-desc">
                        Get personalized tutoring from top-performing Telkom University students across various subjects including Programming, Mathematics, Design, and more.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💼</div>
                    <h3 class="feature-title">Freelance Services</h3>
                    <p class="feature-desc">
                        Access a wide range of professional services from talented peers—from web development and graphic design to content writing and academic assistance.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">Secure & Verified</h3>
                    <p class="feature-desc">
                        All tutors and freelancers are verified Telkom University students. Our admin moderation ensures quality and safety for all transactions.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">⭐</div>
                    <h3 class="feature-title">Review System</h3>
                    <p class="feature-desc">
                        Transparent rating and review system helps you make informed decisions and ensures continuous quality improvement.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3 class="feature-title">Fair Pricing</h3>
                    <p class="feature-desc">
                        Competitive and student-friendly pricing with secure payment processing and transaction history tracking.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📚</div>
                    <h3 class="feature-title">Learning Resources</h3>
                    <p class="feature-desc">
                        Access curated articles, tips, and educational content to support your academic and professional development journey.
                    </p>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="hero-section" style="margin-top: 4rem;">
                <h2 style="font-size: 2.5rem; margin-bottom: 1rem; color: #fff;">
                    Ready to Start Your Journey?
                </h2>
                <p style="font-size: 1.1rem; color: #cbd5e1; margin-bottom: 2rem;">
                    Join thousands of Telkom University students already using Mentora to learn, teach, and grow.
                </p>
                <div class="cta-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-hero">
                        Create Account
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-hero">
                        Sign In
                    </a>
                </div>
            </section>
        </div>
    </main>
</body>
</html>