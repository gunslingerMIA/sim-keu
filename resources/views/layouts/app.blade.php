<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>SIM-KEU DPMPTSP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">  
    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root { --tblr-font-sans-serif: 'Inter var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; }
        
        .page { display: flex; flex-direction: row; height: 100vh; overflow: hidden; position: relative; }
        
        /* SIDEBAR LOGIC */
        .sidebar-fixed { 
            width: 250px; 
            background: #0f172a; 
            color: #cbd5e1; 
            height: 100vh; 
            overflow-y: auto; 
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            z-index: 1050;
            transition: transform 0.3s ease;
        }

        /* Responsive Breakpoint: Di bawah 1200px Sidebar sembunyi */
        @media (max-width: 1199.98px) {
            .sidebar-fixed {
                position: fixed;
                transform: translateX(-100%);
            }
            .sidebar-fixed.show {
                transform: translateX(0);
            }
            .mobile-nav-toggle { display: block !important; }
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
        .nav-link { color: #94a3b8; font-size: 0.875rem; padding: 10px 20px; border-radius: 6px; margin: 0 12px 4px; transition: all 0.2s; }
        .nav-link:hover { background: #1e293b; color: #f8fafc; }
        .nav-link.active { background: #3b82f6; color: white; }
        .nav-link i { margin-right: 12px; font-size: 1.1rem; }
        .menu-header { font-size: 0.7rem; text-transform: uppercase; color: #64748b; font-weight: 700; margin: 24px 24px 8px; letter-spacing: 0.05em; }
        
        /* BACKDROP */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .sidebar-backdrop.show { display: block; }

        /* DATATABLES CLEANUP */
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter { margin-bottom: 1rem; padding: 0 1rem; }
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { margin-top: 1rem; padding: 1rem; }
        .dataTables_filter input { border: 1px solid #dadcde; border-radius: 4px; padding: 4px 8px; margin-left: 10px; }
        table.dataTable thead th { text-transform: uppercase; font-size: 0.75rem; letter-spacing: .04em; color: #616876; background-color: #f6f8fb; }
    </style>
</head>
<body>
    <div class="page">
        <div id="sidebarBackdrop" class="sidebar-backdrop" onclick="toggleSidebar()"></div>

        <aside class="sidebar-fixed shadow border-end border-dark">
            <div class="p-4 text-center">
                <div class="avatar avatar-md bg-primary-lt mb-2">
                    <i class="bi bi-bank text-white"></i>
                </div>
                <h6 class="text-white fw-bold mb-0">SIM-KEU DPMPTSP</h6>
                <small class="text-muted">TA {{ session('tahun_anggaran', '2026') }}</small>
            </div>

            <div class="mt-2 flex-grow-1">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>

                <div class="menu-header">Data Master</div>
                <a href="/programs" class="nav-link {{ request()->is('programs') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i> Program Kegiatan
                </a>
                <a href="/accounts" class="nav-link {{ request()->is('accounts') ? 'active' : '' }}">
                    <i class="bi bi-collection"></i> Akun
                </a>

                <div class="menu-header">Transaksi</div>
                <a class="nav-link {{ request()->is('transactions') ? 'active' : '' }}" href="/transactions">
                    <i class="bi bi-pencil-square"></i> Jurnal
                </a>

                <div class="menu-header">Pelaporan</div>
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#laporanSub">
                    <span><i class="bi bi-chevron-down small"></i> Laporan</span>
                </a>
                <div class="collapse {{ request()->is('reports*') ? 'show' : '' }}" id="laporanSub">
                    <a href="/reports/lra-ringkas" class="nav-link ps-5 small">LRA</a>
                    <a href="/reports/neraca" class="nav-link ps-5 small">Neraca Saldo</a>
                </div>
            </div>
            
            <div class="p-3">
                <div class="card bg-dark border-0">
                    <div class="card-body p-2 text-center">
                        <small class="text-secondary d-block">User: Admin Renval</small>
                    </div>
                </div>
            </div>
        </aside>

        <main class="content-area">
            <header class="navbar navbar-light bg-white border-bottom px-4 shadow-sm" style="min-height: 70px;">
                <div class="container-xl d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="navbar-toggler mobile-nav-toggle d-xl-none me-3" type="button" onclick="toggleSidebar()">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <h2 class="navbar-brand text-dark fw-bold mb-0">SIM-KEU</h2>
                    </div>
                    
                    <div class="navbar-nav">
                        <span class="badge bg-blue-lt px-3 py-2">TA {{ session('tahun_anggaran', '2026') }}</span>
                    </div>
                </div>
            </header>
            
            <div class="page-content p-4">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // DataTables Init
        $(function() {
            if ($('#table').length) {
                $('#table').DataTable({
                    "language": { "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" },
                    "dom": "<'row px-3 py-3'<'col-sm-6'l><'col-sm-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row px-3 py-3'<'col-sm-5'i><'col-sm-7'p>>",
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
</body>
</html>