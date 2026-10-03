<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me | Portfolio</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts (Prompt) -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #0f172a; 
            color: #e2e8f0;
        }
        
        .profile-card {
            background: #1e293b; 
            border-radius: 1.5rem;
            border: 1px solid #334155;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
            max-width: 650px; 
            width: 100%;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 4px solid #3b82f6; 
            padding: 3px;
            background-color: #1e293b;
        }

        .work-link {
            background-color: #0f172a;
            border: 1px solid #334155;
            border-radius: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #f8fafc;
        }

        .work-link:hover {
            transform: translateY(-4px);
            border-color: #3b82f6;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
            background-color: #1e293b;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-5">

    <div class="container d-flex justify-content-center">
        <!-- Card หลัก -->
        <div class="profile-card p-4 p-md-5">
            
            <!-- ส่วน Top Bar (Login/Logout) -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="badge text-bg-primary rounded-pill px-3 py-2">About-me</span>
                
                @guest
                    <div class="d-flex gap-2">
                        <!-- เพิ่ม ['source' => 'about_me'] ตรงนี้ เพื่อบอกทางกลับมาหน้า About Me -->
                        <a href="{{ route('register', ['source' => 'about_me']) }}" class="btn btn-light btn-sm rounded-pill px-3">
                            <i class="bi bi-person-plus-fill me-1"></i> Register
                        </a>
                        <a href="{{ route('login', ['source' => 'about_me']) }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </div>
                @endguest

                @auth
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-success small"><i class="bi bi-circle-fill"></i> {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </div>

            <!-- ส่วน Profile -->
            <div class="text-center mb-5">
                <img src="{{ asset('images/profile.jpg') }}" alt="Profile Picture" class="profile-img rounded-circle mb-3 shadow">
                <h3 class="fw-bold mb-1">นายตญานนท์ หาขุน</h3>
                <p class="text-info mb-2"><i class="bi bi-person-vcard me-2"></i>รหัสนักศึกษา: 68222420005</p>
                <p class="text-secondary small">eiei</p>
            </div>

            <!-- ส่วน Links งาน (EP02, EP03, EP07) -->
            <div class="d-flex flex-column gap-3">
                
                <a href="{{ url('/gallery') }}" class="work-link p-3 d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-images"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Gallery</h6>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-secondary"></i>
                </a>

                <a href="{{ url('/active/index') }}" class="work-link p-3 d-flex align-items-center">
                    <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-bootstrap"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Active</h6>
                    
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-secondary"></i>
                </a>

                <a href="{{ url('/weights') }}" class="work-link p-3 d-flex align-items-center">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-activity"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">Weight</h6>
                        <small class="text-secondary">
                            @guest <span class="text-danger"><i class="bi bi-lock-fill"></i> Requires Login</span> @endguest
                            @auth <span class="text-success"><i class="bi bi-unlock-fill"></i> Ready to view</span> @endauth
                        </small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-secondary"></i>
                </a>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>