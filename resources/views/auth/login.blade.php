<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Login - SIM-KEU DPMPTSP</title>
    <!-- Google Fonts for modern typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tabler Core & Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/css/tabler.min.css') }}" integrity="sha384-kz+I4+mczbNiZfLAJMxOlJaZmnbRYhARHNkR2k6tal4gz7OL33/0puDD3SvkiNX9" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-icons.min.css') }}" integrity="sha384-Q/b68FXi/uzI6bjcGbx7kHAobgdK2x1qOUrqdTvipaJci87t0PRovmYAIrCVE4x5" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0b0f19;
            color: #f8fafc;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Ambient background glow blobs */
        .glow-blob {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(120px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.15;
            animation: float-glow 20s infinite alternate ease-in-out;
        }

        .glow-blob-1 {
            background: radial-gradient(circle, #0d9488 0%, transparent 70%);
            top: -10%;
            left: -10%;
        }

        .glow-blob-2 {
            background: radial-gradient(circle, #4f46e5 0%, transparent 70%);
            bottom: -10%;
            right: -10%;
            animation-delay: -10s;
        }

        @keyframes float-glow {
            0% {
                transform: translate(0, 0) scale(1);
            }
            100% {
                transform: translate(80px, 50px) scale(1.2);
            }
        }

        /* Batik Kawung Pattern Layer */
        .batik-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            pointer-events: none;
            opacity: 0.05;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill='none' stroke='%2338bdf8' stroke-width='1'%3E%3Cpath d='M 50,0 A 50,50 0 0,0 0,50 A 50,50 0 0,0 50,100 A 50,50 0 0,0 100,50 A 50,50 0 0,0 50,0 Z' /%3E%3Ccircle cx='50' cy='50' r='8' stroke='%23fbbf24' stroke-width='1.5' /%3E%3Ccircle cx='0' cy='0' r='8' stroke='%23fbbf24' stroke-width='1.5' /%3E%3Ccircle cx='100' cy='0' r='8' stroke='%23fbbf24' stroke-width='1.5' /%3E%3Ccircle cx='0' cy='100' r='8' stroke='%23fbbf24' stroke-width='1.5' /%3E%3Ccircle cx='100' cy='100' r='8' stroke='%23fbbf24' stroke-width='1.5' /%3E%3Cpath d='M 50,0 L 50,100 M 0,50 L 100,50' opacity='0.3' stroke-width='0.75' /%3E%3Cpath d='M 50,50 L 15,15 M 50,50 L 85,15 M 50,50 L 15,85 M 50,50 L 85,85' opacity='0.2' stroke-width='0.5' /%3E%3C/g%3E%3C/svg%3E");
            background-repeat: repeat;
        }

        .login-wrapper {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* Modern card container */
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 40px rgba(13, 148, 136, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #1e293b;
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            transform: translateY(20px);
            opacity: 0;
            animation: slide-up-in 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slide-up-in {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Branding area */
        .branding-header {
            text-align: center;
            margin-bottom: 2rem;
            animation: fade-in-down 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fade-in-down {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .logo-container {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #0d9488 0%, #4f46e5 100%);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 10px 20px rgba(13, 148, 136, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .logo-container::after {
            content: '';
            position: absolute;
            top: -2px; left: -2px; right: -2px; bottom: -2px;
            background: linear-gradient(135deg, rgba(255,255,255,0.4), transparent);
            border-radius: 20px;
            pointer-events: none;
        }

        .logo-container i {
            font-size: 2.2rem;
            color: #ffffff;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
        }

        .app-title-main {
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            background: linear-gradient(to right, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.15rem;
        }

        .app-title-sub {
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: #a5b4fc;
            text-transform: uppercase;
        }

        .app-desc {
            font-size: 0.85rem;
            color: #94a3b8;
            max-width: 320px;
            margin: 0.5rem auto 0;
            line-height: 1.4;
        }

        /* Form elements styling */
        .form-label {
            font-weight: 600;
            font-size: 0.825rem;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .input-group-merge {
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease-in-out;
            background-color: #ffffff;
        }

        .input-group-merge:focus-within {
            border-color: #0d9488;
            box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.15);
        }

        .input-group-merge .input-group-text {
            background-color: transparent;
            border: none;
            padding-right: 0.5rem;
            color: #94a3b8;
            transition: color 0.2s ease-in-out;
        }

        .input-group-merge:focus-within .input-group-text {
            color: #0d9488;
        }

        .input-group-merge .form-control {
            border: none;
            padding: 0.75rem 0.75rem 0.75rem 0.25rem;
            font-size: 0.95rem;
            color: #1e293b;
            background-color: transparent;
        }

        .input-group-merge .form-control:focus {
            box-shadow: none;
            outline: none;
        }

        /* Custom dropdown arrow for year */
        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            padding-right: 2.5rem !important;
        }

        .input-group-merge:focus-within select.form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%230d9488' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        }

        /* Button styling */
        .btn-submit {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.8rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(13, 148, 136, 0.35);
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        /* Alerts design */
        .alert-modern {
            border-radius: 12px;
            font-size: 0.85rem;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .alert-modern i {
            font-size: 1.15rem;
        }
    </style>
</head>

<body>
    <!-- Glow effects in background -->
    <div class="glow-blob glow-blob-1"></div>
    <div class="glow-blob glow-blob-2"></div>
    
    <!-- Batik Kawung pattern layer -->
    <div class="batik-overlay"></div>

    <div class="login-wrapper">
        <div class="container container-tight d-flex flex-column align-items-center">
            
            <!-- Branding Header -->
            <div class="branding-header">
                <div class="logo-container">
                    <i class="bi bi-bank2"></i>
                </div>
                <div class="app-title-main">SIM-KEU</div>
                <div class="app-title-sub">DPMPTSP</div>
                <div class="app-desc">
                    Sistem Informasi Manajemen Keuangan<br>
                    Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu
                </div>
            </div>

            <!-- Login Card -->
            <div class="card login-card shadow-lg">
                <div class="card-body p-4 p-md-5">
                    <h2 class="h3 text-center fw-bold mb-4" style="color: #0f172a; letter-spacing: -0.01em;">Masuk ke Akun</h2>
                    
                    @if (session('error'))
                        <div class="alert alert-modern mb-4">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-modern mb-4">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div class="w-100">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="post" autocomplete="off">
                        @csrf
                        
                        <!-- NIP Input -->
                        <div class="mb-3">
                            <label class="form-label">NIP (Nomor Induk Pegawai)</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input type="text" name="nip" class="form-control" placeholder="199xxx" required autocomplete="username">
                            </div>
                        </div>
                        
                        <!-- Password Input -->
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                            </div>
                        </div>
                        
                        <!-- Tahun Anggaran Dropdown -->
                        <div class="mb-4">
                            <label class="form-label">Tahun Anggaran</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar3"></i>
                                </span>
                                <select class="form-control" name="tahun_anggaran" id="tahun_anggaran" required>
                                    @foreach($tahun as $t)
                                        <option value="{{ $t->tahun }}" {{ $t->tahun == date('Y') ? 'selected' : '' }}>{{ $t->tahun }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="form-footer">
                            <button type="submit" class="btn btn-submit w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Aplikasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Footer credits -->
            <div class="text-center mt-4 position-relative" style="z-index: 10; font-size: 0.75rem; color: #64748b;">
                &copy; {{ date('Y') }} SIM-KEU DPMPTSP. Semua Hak Dilindungi.
            </div>
        </div>
    </div>

    <!-- Tabler Core Script -->
    <script src="{{ asset('vendor/js/tabler.min.js') }}" integrity="sha384-pku3birjgGovaJ9ngF7SaxKkF/eYUvBjiMJ+jTtWbNesIj2Rud2K63+4JD7EF4gk" crossorigin="anonymous"></script>
</body>

</html>
