<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Pilih Tahun Anggaran - SIM-KEU DPMPTSP</title>
    <!-- Google Fonts for modern typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tabler Core & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

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

        .input-group-merge .form-select {
            border: none;
            padding: 0.75rem 2.5rem 0.75rem 0.25rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            background-color: transparent;
            width: 100%;
        }

        .input-group-merge .form-select:focus {
            box-shadow: none;
            outline: none;
        }

        /* Custom dropdown arrow for year */
        select.form-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
        }

        .input-group-merge:focus-within select.form-select {
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
                <div class="card-body p-4 p-md-5 text-center">
                    <h2 class="h3 fw-bold mb-2" style="color: #0f172a; letter-spacing: -0.01em;">Selamat Datang</h2>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">Silakan pilih tahun anggaran untuk memulai bekerja.</p>
                    
                    <form action="{{ route('tahun.simpan') }}" method="post">
                        @csrf
                        
                        <!-- Tahun Anggaran Dropdown -->
                        <div class="mb-4 text-start">
                            <label class="form-label">Tahun Anggaran</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar3"></i>
                                </span>
                                <select name="tahun" class="form-select" required>
                                    <option value="" disabled>Pilih Tahun</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year->tahun }}" {{ session('tahun_anggaran') == $year->tahun ? 'selected' : '' }}>
                                            {{ $year->tahun }}
                                        </option>                                
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="form-footer">
                            <button type="submit" class="btn btn-submit w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Dashboard
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
</body>

</html>