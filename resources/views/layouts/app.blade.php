<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>SIM-KEU DPMPTSP</title>
    <!-- Google Fonts for modern typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tabler Core & Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/css/tabler.min.css') }}" integrity="sha384-kz+I4+mczbNiZfLAJMxOlJaZmnbRYhARHNkR2k6tal4gz7OL33/0puDD3SvkiNX9" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap-icons.min.css') }}" integrity="sha384-Q/b68FXi/uzI6bjcGbx7kHAobgdK2x1qOUrqdTvipaJci87t0PRovmYAIrCVE4x5" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendor/css/dataTables.bootstrap5.min.css') }}" integrity="sha384-ok3J6xA9oQqai5C9ytYveFsBeKgoGk4T+NExsr6hoIKjZdv9SJcmx2mafwUWRNf9" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendor/css/tom-select.bootstrap5.min.css') }}" integrity="sha384-3bljoW7l4nTgpxifNAuotLa4NYLtoKwBGpmJ1B9bLTb+sIyQ2RnFBAkbkj1Xq257" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif !important;
            background-color: #f8fafc;
            color: #1e293b;
        }

        :root {
            --tblr-font-sans-serif: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            --tblr-primary: #0d9488;
        }

        .page {
            display: flex;
            flex-direction: row;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* SIDEBAR STYLING */
        .sidebar-fixed {
            width: 260px;
            background: linear-gradient(180deg, #0f172a 0%, #020617 100%);
            color: #cbd5e1;
            height: 100vh;
            overflow-y: auto;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            z-index: 1050;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border-right: 1px solid rgba(255, 255, 255, 0.05) !important;
        }

        /* Responsive Breakpoint */
        @media (max-width: 1199.98px) {
            .sidebar-fixed {
                position: fixed;
                transform: translateX(-100%);
            }

            .sidebar-fixed.show {
                transform: translateX(0);
                box-shadow: 15px 0 30px rgba(0, 0, 0, 0.25);
            }

            .mobile-nav-toggle {
                display: block !important;
            }
        }

        .content-area {
            flex-grow: 1;
            height: 100vh;
            overflow-y: auto;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
        }

        /* NAV STYLING */
        .nav-link {
            color: #94a3b8;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 10px;
            margin: 0 16px 6px;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.04);
            color: #38bdf8;
            transform: translateX(2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%) !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.15rem;
            transition: transform 0.2s;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .menu-header {
            font-size: 0.65rem;
            text-transform: uppercase;
            color: #475569;
            font-weight: 700;
            margin: 20px 24px 8px;
            letter-spacing: 0.1em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .menu-header::after {
            content: '';
            flex-grow: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.04);
        }

        /* COLLAPSE SUBMENU */
        .collapse .nav-link {
            margin: 0 16px 4px 32px;
            padding: 8px 16px;
            font-size: 0.8rem;
        }

        /* BACKDROP */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1040;
            transition: opacity 0.3s;
        }

        .sidebar-backdrop.show {
            display: block;
        }

        /* GLOBAL COMPONENT OVERRIDES (NOT FLAT) */
        
        /* 1. Cards */
        .card {
            border-radius: 16px !important;
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01) !important;
            transition: all 0.25s ease !important;
            background-color: #ffffff !important;
        }
        
        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.02) !important;
            transform: translateY(-2px);
        }

        /* 2. Tables */
        .table-responsive {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            background: #ffffff;
        }

        table.dataTable {
            border-collapse: collapse !important;
            margin: 0 !important;
            width: 100% !important;
        }

        table.dataTable thead th {
            text-transform: uppercase !important;
            font-size: 0.725rem !important;
            font-weight: 700 !important;
            letter-spacing: .06em !important;
            color: #475569 !important;
            background-color: #f1f5f9 !important;
            border-bottom: 2px solid #e2e8f0 !important;
            padding: 12px 16px !important;
        }

        table.dataTable tbody td {
            padding: 12px 16px !important;
            vertical-align: middle !important;
            color: #334155;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        table.dataTable tbody tr:hover {
            background-color: #f8fafc !important;
        }

        /* DataTables length and search search inputs styling */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_filter input {
            border: 1.5px solid #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            outline: none !important;
            transition: all 0.2s !important;
            font-size: 0.875rem !important;
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_filter input:focus {
            border-color: #0d9488 !important;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15) !important;
        }

        /* Pagination buttons */
        .paginate_button.page-item.active .page-link {
            background-color: #0d9488 !important;
            border-color: #0d9488 !important;
            box-shadow: 0 2px 4px rgba(13, 148, 136, 0.2) !important;
        }

        /* 3. Form inputs & select fields */
        .form-control, .form-select {
            border-radius: 10px !important;
            border: 1.5px solid #cbd5e1 !important;
            padding: 0.6rem 0.9rem !important;
            font-size: 0.9rem !important;
            transition: all 0.2s ease-in-out !important;
            color: #1e293b !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: #0d9488 !important;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15) !important;
        }

        /* 4. Primary buttons */
        .btn-primary {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%) !important;
            border: none !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            padding: 0.6rem 1.2rem !important;
            border-radius: 10px !important;
            transition: all 0.25s ease !important;
            box-shadow: 0 4px 10px rgba(13, 148, 136, 0.2) !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0f766e 0%, #115e59 100%) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 14px rgba(13, 148, 136, 0.3) !important;
        }

        .btn-primary:active {
            transform: translateY(1px) !important;
        }

        /* 5. Secondary buttons */
        .btn-secondary {
            border-radius: 10px !important;
            padding: 0.6rem 1.2rem !important;
            font-weight: 600 !important;
            border: 1.5px solid #cbd5e1 !important;
            background: #ffffff !important;
            color: #475569 !important;
            transition: all 0.25s ease !important;
        }

        .btn-secondary:hover {
            background: #f8fafc !important;
            color: #1e293b !important;
            border-color: #94a3b8 !important;
        }

        /* 6. Badges */
        .badge {
            padding: 5px 10px !important;
            font-weight: 600 !important;
            border-radius: 6px !important;
        }
        
        .bg-green-lt {
            background-color: rgba(13, 148, 136, 0.1) !important;
            color: #0d9488 !important;
            border: 1px solid rgba(13, 148, 136, 0.2) !important;
        }
    </style>

    @stack('after_style')
</head>

<body>
    <div class="page">
        <div id="sidebarBackdrop" class="sidebar-backdrop" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="sidebar-fixed shadow">
            <div class="p-4 text-center" style="border-bottom: 1px solid rgba(255,255,255,0.05) !important;">
                <div class="logo-container mx-auto mb-2" style="width: 52px; height: 52px; background: linear-gradient(135deg, #0d9488 0%, #4f46e5 100%); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px rgba(13, 148, 136, 0.25);">
                    <i class="bi bi-bank2 text-white" style="font-size: 1.6rem;"></i>
                </div>
                <h6 class="text-white fw-bold mb-0" style="letter-spacing: 0.05em; font-size: 0.95rem;">SIM-KEU</h6>
                <div class="text-muted fw-semibold small mb-1" style="font-size: 0.75rem; letter-spacing: 0.1em; color: #a5b4fc !important;">DPMPTSP</div>
                
                <div class="btn-list text-center d-flex justify-content-center mt-2">
                    <span class="badge bg-green-lt fw-bold" style="font-size: 0.7rem;">
                        <i class="bi bi-calendar3 me-1"></i> TA {{ session('tahun_anggaran') }}
                    </span>
                    <span class="badge fw-bold ms-1" style="font-size: 0.7rem; background-color: rgba(59, 130, 246, 0.1) !important; color: #3b82f6 !important; border: 1px solid rgba(59, 130, 246, 0.2) !important;">
                        <i class="bi bi-layers-fill me-1"></i> {{ session('nama_tahapan', 'BELUM DIATUR') }}
                    </span>
                </div>
            </div>

            @php
                $userRole = strtolower(auth()->user()->role);
            @endphp

            <div class="mt-3 flex-grow-1">
                <a class="nav-link {{ request()->is('dashboard') || request()->is('/') ? 'active' : '' }}"
                    href="/dashboard">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>

                @if($userRole === 'admin' || $userRole === 'bendahara')
                    <div class="menu-header">Data Master</div>

                    <a href="#pengaturan" class="nav-link {{ request()->routeIs(['programs.*', 'budgets.*', 'accounts.*', 'users.*', 'years.*']) ? 'active' : '' }}" data-bs-toggle="collapse"><i class="bi bi-gear-fill"></i> Pengaturan Data</a>
                    <div class="collapse" id="pengaturan">
                        @if($userRole === 'admin')
                            <a href="/programs" class="nav-link {{ request()->is('programs') ? 'active' : '' }}">
                                Program Kegiatan
                            </a>
                        @endif
                        <a href="/accounts" class="nav-link {{ request()->is('accounts') ? 'active' : '' }}">
                           Akun Rekening
                        </a>
                        <a href="/budgets" class="nav-link {{ request()->is('budgets') ? 'active' : '' }}">
                           DPA Belanja
                        </a>
                        @if($userRole === 'admin')
                            <a href="/users" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                              Manajemen User
                            </a>
                            <a href="{{ route('years.index') }}" class="nav-link {{ request()->routeIs('years.*') ? 'active' : '' }}">
                               Tahun Anggaran
                            </a>
                        @endif
                    </div>
                @endif

                @if($userRole === 'admin' || $userRole === 'bendahara')
                    <div class="menu-header">Transaksi</div>
                    <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="/transactions">
                        <i class="bi bi-pencil-square"></i> Jurnal Transaksi
                    </a>
                @endif

                <div class="menu-header">Pelaporan</div>
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs(['reports.*']) ? 'active' : '' }}" data-bs-toggle="collapse"
                    href="#laporanSub">
                    <span><i class="bi bi-journal-text"></i> Laporan Keuangan</span>
                </a>
                <div class="collapse" id="laporanSub">
                    @if($userRole === 'admin' || $userRole === 'bendahara')
                        <a href="/reports/journal" class="nav-link {{ request()->routeIs(['reports.journal']) ? 'active' : '' }}">Jurnal Transaksi</a>
                        <a href="/reports/ledger" class="nav-link {{ request()->routeIs(['reports.ledger']) ? 'active' : '' }}">Buku Besar Akun</a>
                    @endif
                    <a href="/reports/lra" class="nav-link {{ request()->routeIs(['reports.lra']) ? 'active' : '' }}">Neraca Saldo</a>
                </div>
            </div>

            <!-- Sidebar bottom section -->
            <div class="p-3 mt-auto">
                <div class="p-2 text-center rounded-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <small class="text-muted d-block" style="font-size: 0.7rem; letter-spacing: 0.05em; text-transform: uppercase;">
                        Role: <span class="text-white fw-bold">{{ auth()->user()->role }}</span>
                    </small>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="content-area">
            <header class="navbar navbar-light bg-white border-bottom px-4" style="min-height: 70px; border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);">
                <div class="container-xl d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="navbar-toggler mobile-nav-toggle d-xl-none me-3" type="button"
                            onclick="toggleSidebar()">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <h2 class="navbar-brand text-dark fw-bold mb-0" style="font-size: 1.25rem; letter-spacing: -0.02em;">SIM-KEU DPMPTSP</h2>
                    </div>

                    <div class="navbar-nav flex-row order-md-last">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0 align-items-center" data-bs-toggle="dropdown"
                                aria-label="Open user menu"
                                style="background: none !important; border: none !important; box-shadow: none !important; cursor: pointer;">
                                
                                <div class="avatar avatar-sm bg-teal text-white fw-bold me-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #0d9488 0%, #4f46e5 100%) !important;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                                
                                <div class="d-none d-xl-block ps-1 text-start">
                                    <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                                    <div class="small text-muted" style="font-size: 0.75rem; text-transform: capitalize; margin-top: 2px;">{{ Auth::user()->role }}</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-md border-0" style="border-radius: 12px; min-width: 180px; padding: 8px;">
                                <div class="dropdown-header text-muted text-uppercase fw-bold" style="font-size: 0.65rem; padding: 8px 12px;">Menu Pengguna</div>
                                <div class="dropdown-divider" style="border-top: 1px solid #f1f5f9; margin: 6px 0;"></div>
                                
                                <form action="{{ route('logout') }}" id="form-logout" method="POST">
                                    @csrf
                                </form>
                                <a href="#" onclick="confirmLogout(event)" class="dropdown-item text-danger d-flex align-items-center" style="border-radius: 8px; padding: 8px 12px; font-weight: 500;">
                                    <i class="bi bi-box-arrow-right me-2" style="font-size: 1.1rem;"></i> Keluar Aplikasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="page-content p-4">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/js/jquery.min.js') }}" integrity="sha384-NXgwF8Kv9SSAr+jemKKcbvQsz+teULH/a5UNJvZc6kP47hZgl62M1vGnw6gHQhb1" crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/js/tom-select.complete.min.js') }}" integrity="sha384-DZEVpSJ4pM9MDuXkgydQD2RzczjPKUOeRgRpYNZ5fyMlf14Pn/3dZbgIpdtH2YRb" crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/js/jquery.dataTables.min.js') }}" integrity="sha384-cjmdOgDzOE22dUheI5E6Gzd3upfmReW8N1y/4jwKQE50KYcvFKZJA9JxWgQOzqwQ" crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/js/dataTables.bootstrap5.min.js') }}" integrity="sha384-PgPBH0hy6DTJwu7pTf6bkRqPlf/+pjUBExpr/eIfzszlGYFlF9Wi9VTAJODPhgCO" crossorigin="anonymous"></script>
    <script src="{{ asset('vendor/js/sweetalert2.all.min.js') }}" integrity="sha384-nLoOnA/BDh8A/jxqtckg4DumuCGOBYUnNJLZdQz/zfYNp3wcjGSoWTAzgko06G/2" crossorigin="anonymous"></script>

    @stack('scripts')
    
    <script>
        // DataTables Init
        $(function() {
            if ($('#table').length) {
                $('#table').DataTable({
                    "language": {
                        "url": "{{ asset('vendor/js/datatables.id.json') }}"
                    },
                    "dom": "<'row px-3 py-3'<'col-sm-6'l><'col-sm-6'f>>" + "<'row'<'col-sm-12'tr>>" +
                        "<'row px-3 py-3'<'col-sm-5'i><'col-sm-7'p>>",
                });
            }
        });

        // Sidebar Toggle Function
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-fixed');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        }

        // Auto close sidebar on mobile when link clicked
        document.querySelectorAll('.sidebar-fixed .nav-link:not([data-bs-toggle])').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1200) toggleSidebar();
            });
        });
    </script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Notifikasi jika Sukses
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        // Notifikasi jika Error
        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d9488',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-logout').submit();
                }
            });
        }
    </script>
</body>

</html>
