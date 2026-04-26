<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>SIM-KEU DPMPTSP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        .page {
            display: flex;
            flex-direction: row;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

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
            font-size: 0.875rem;
            padding: 10px 20px;
            border-radius: 6px;
            margin: 0 12px 4px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background: #1e293b;
            color: #f8fafc;
        }

        .nav-link.active {
            background: #3b82f6;
            color: white;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .menu-header {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            margin: 24px 24px 8px;
            letter-spacing: 0.05em;
        }

        /* BACKDROP */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
        }

        .sidebar-backdrop.show {
            display: block;
        }

        /* DATATABLES CLEANUP */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
            padding: 0 1rem;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
            padding: 1rem;
        }

        .dataTables_filter input {
            border: 1px solid #dadcde;
            border-radius: 4px;
            padding: 4px 8px;
            margin-left: 10px;
        }

        table.dataTable thead th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: .04em;
            color: #616876;
            background-color: #f6f8fb;
        }
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
                <a class="nav-link {{ request()->is('dashboard') || request()->is('/') ? 'active' : '' }}"
                    href="/dashboard">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>

                <div class="menu-header">Data Master</div>
                <a href="/programs" class="nav-link {{ request()->is('programs') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i> Program Kegiatan
                </a>
                <a href="/accounts" class="nav-link {{ request()->is('accounts') ? 'active' : '' }}">
                    <i class="bi bi-collection"></i> Akun
                </a>
                <a href="/budgets" class="nav-link {{ request()->is('budgets') ? 'active' : '' }}">
                    <i class="bi bi-collection"></i> DPA
                </a>
                <a href="/users" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                    <i class="bi bi-collection"></i> User
                </a>

                <div class="menu-header">Transaksi</div>
                <a class="nav-link {{ request()->is('transactions') ? 'active' : '' }}" href="/transactions">
                    <i class="bi bi-pencil-square"></i> Jurnal
                </a>

                <div class="menu-header">Pelaporan</div>
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#laporanSub">
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

                        <small class="text-secondary d-block">User: {{ auth()->user()->role }}</small>

                    </div>

                </div>

            </div>
        </aside>

        <main class="content-area">
            {{-- <header class="navbar navbar-light bg-white border-bottom px-4 shadow-sm" style="min-height: 70px;">
                <div class="container-xl d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="navbar-toggler mobile-nav-toggle d-xl-none me-3" type="button"
                            onclick="toggleSidebar()">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <h2 class="navbar-brand text-dark fw-bold mb-0">SIM-KEU</h2>
                    </div>

                    <div class="navbar-nav flex-row order-md-last ms-auto">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset" data-bs-toggle="dropdown"
                                aria-label="Open user menu">
                                <span class="avatar avatar-sm"
                                    style="background-image: url(/static/avatars/044m.jpg)"></span>
                                <div class="d-none d-xl-block ps-2">
                                    <div>Paweł Kuna</div>
                                    <div class="mt-1 small text-secondary">UI Designer</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="#" class="dropdown-item">Status</a>
                                <a href="./profile.html" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Feedback</a>
                                <div class="dropdown-divider"></div>
                                <a href="./settings.html" class="dropdown-item">Settings</a>
                                <a href="./sign-in.html" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    </div>

                </div>
            </header> --}}

            <header class="navbar navbar-expand-md d-print-none">
                <div class="container-xl">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- BEGIN NAVBAR LOGO --><a href="../../.." aria-label="Tabler"
                        class="navbar-brand navbar-brand-autodark me-3"><svg xmlns="http://www.w3.org/2000/svg"
                            width="110" height="32" viewBox="0 0 232 68" class="navbar-brand-image">
                            <path
                                d="M64.6 16.2C63 9.9 58.1 5 51.8 3.4 40 1.5 28 1.5 16.2 3.4 9.9 5 5 9.9 3.4 16.2 1.5 28 1.5 40 3.4 51.8 5 58.1 9.9 63 16.2 64.6c11.8 1.9 23.8 1.9 35.6 0C58.1 63 63 58.1 64.6 51.8c1.9-11.8 1.9-23.8 0-35.6zM33.3 36.3c-2.8 4.4-6.6 8.2-11.1 11-1.5.9-3.3.9-4.8.1s-2.4-2.3-2.5-4c0-1.7.9-3.3 2.4-4.1 2.3-1.4 4.4-3.2 6.1-5.3-1.8-2.1-3.8-3.8-6.1-5.3-2.3-1.3-3-4.2-1.7-6.4s4.3-2.9 6.5-1.6c4.5 2.8 8.2 6.5 11.1 10.9 1 1.4 1 3.3.1 4.7zM49.2 46H37.8c-2.1 0-3.8-1-3.8-3s1.7-3 3.8-3h11.4c2.1 0 3.8 1 3.8 3s-1.7 3-3.8 3z"
                                fill="#066fd1" style="fill: var(--tblr-primary, #066fd1)" />
                            <path
                                d="M105.8 46.1c.4 0 .9.2 1.2.6s.6 1 .6 1.7c0 .9-.5 1.6-1.4 2.2s-2 .9-3.2.9c-2 0-3.7-.4-5-1.3s-2-2.6-2-5.4V31.6h-2.2c-.8 0-1.4-.3-1.9-.8s-.9-1.1-.9-1.9c0-.7.3-1.4.8-1.8s1.2-.7 1.9-.7h2.2v-3.1c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v3.1h3.4c.8 0 1.4.3 1.9.8s.8 1.2.8 1.9-.3 1.4-.8 1.8-1.2.7-1.9.7h-3.4v13c0 .7.2 1.2.5 1.5s.8.5 1.4.5c.3 0 .6-.1 1.1-.2.5-.2.8-.3 1.2-.3zm28-20.7c.8 0 1.5.3 2.1.8.5.5.8 1.2.8 2.1v20.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2-.8-.8-1.2-.8-2.1c-.8.9-1.9 1.7-3.2 2.4-1.3.7-2.8 1-4.3 1-2.2 0-4.2-.6-6-1.7-1.8-1.1-3.2-2.7-4.2-4.7s-1.6-4.3-1.6-6.9c0-2.6.5-4.9 1.5-6.9s2.4-3.6 4.2-4.8c1.8-1.1 3.7-1.7 5.9-1.7 1.5 0 3 .3 4.3.8 1.3.6 2.5 1.3 3.4 2.1 0-.8.3-1.5.8-2.1.5-.5 1.2-.7 2-.7zm-9.7 21.3c2.1 0 3.8-.8 5.1-2.3s2-3.4 2-5.7-.7-4.2-2-5.8c-1.3-1.5-3-2.3-5.1-2.3-2 0-3.7.8-5 2.3-1.3 1.5-2 3.5-2 5.8s.6 4.2 1.9 5.7 3 2.3 5.1 2.3zm32.1-21.3c2.2 0 4.2.6 6 1.7 1.8 1.1 3.2 2.7 4.2 4.7s1.6 4.3 1.6 6.9-.5 4.9-1.5 6.9-2.4 3.6-4.2 4.8c-1.8 1.1-3.7 1.7-5.9 1.7-1.5 0-3-.3-4.3-.9s-2.5-1.4-3.4-2.3v.3c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.5-.8-1.2-.8-2.1V18.9c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v10c.8-1 1.8-1.8 3.2-2.5 1.3-.7 2.8-1 4.3-1zm-.7 21.3c2 0 3.7-.8 5-2.3s2-3.5 2-5.8-.6-4.2-1.9-5.7-3-2.3-5.1-2.3-3.8.8-5.1 2.3-2 3.4-2 5.7.7 4.2 2 5.8c1.3 1.6 3 2.3 5.1 2.3zm23.6 1.9c0 .8-.3 1.5-.8 2.1s-1.3.8-2.1.8-1.5-.3-2-.8-.8-1.3-.8-2.1V18.9c0-.8.3-1.5.8-2.1s1.3-.8 2.1-.8 1.5.3 2 .8.8 1.3.8 2.1v29.7zm29.3-10.5c0 .8-.3 1.4-.9 1.9-.6.5-1.2.7-2 .7h-15.8c.4 1.9 1.3 3.4 2.6 4.4 1.4 1.1 2.9 1.6 4.7 1.6 1.3 0 2.3-.1 3.1-.4.7-.2 1.3-.5 1.8-.8.4-.3.7-.5.9-.6.6-.3 1.1-.4 1.6-.4.7 0 1.2.2 1.7.7s.7 1 .7 1.7c0 .9-.4 1.6-1.3 2.4-.9.7-2.1 1.4-3.6 1.9s-3 .8-4.6.8c-2.7 0-5-.6-7-1.7s-3.5-2.7-4.6-4.6-1.6-4.2-1.6-6.6c0-2.8.6-5.2 1.7-7.2s2.7-3.7 4.6-4.8 3.9-1.7 6-1.7 4.1.6 6 1.7 3.4 2.7 4.5 4.7c.9 1.9 1.5 4.1 1.5 6.3zm-12.2-7.5c-3.7 0-5.9 1.7-6.6 5.2h12.6v-.3c-.1-1.3-.8-2.5-2-3.5s-2.5-1.4-4-1.4zm30.3-5.2c1 0 1.8.3 2.4.8.7.5 1 1.2 1 1.9 0 1-.3 1.7-.8 2.2-.5.5-1.1.8-1.8.7-.5 0-1-.1-1.6-.3-.2-.1-.4-.1-.6-.2-.4-.1-.7-.1-1.1-.1-.8 0-1.6.3-2.4.8s-1.4 1.3-1.9 2.3-.7 2.3-.7 3.7v11.4c0 .8-.3 1.5-.8 2.1-.5.6-1.2.8-2.1.8s-1.5-.3-2.1-.8c-.5-.6-.8-1.3-.8-2.1V28.8c0-.8.3-1.5.8-2.1.5-.6 1.2-.8 2.1-.8s1.5.3 2.1.8c.5.6.8 1.3.8 2.1v.6c.7-1.3 1.8-2.3 3.2-3 1.3-.7 2.8-1 4.3-1z"
                                fill-rule="evenodd" clip-rule="evenodd" fill="#4a4a4a" />
                        </svg></a><!-- END NAVBAR LOGO -->
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">
                                <span class="nav-link-icon">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/home -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title"> Home </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span
                                    class="nav-link-icon"><!-- Download SVG icon from http://tabler.io/icons/icon/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M9 11l3 3l8 -8" />
                                        <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                    </svg>
                                </span>
                                <span class="nav-link-title"> Profile </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span
                                    class="nav-link-icon"><!-- Download SVG icon from http://tabler.io/icons/icon/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M9 11l3 3l8 -8" />
                                        <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                    </svg>
                                </span>
                                <span class="nav-link-title"> Settings </span>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-nav flex-row order-md-last ms-auto">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset" data-bs-toggle="dropdown"
                                aria-label="Open user menu">
                                <span class="avatar avatar-sm"
                                    style="background-image: url(/static/avatars/044m.jpg)"></span>
                                <div class="d-none d-xl-block ps-2">
                                    <div>Paweł Kuna</div>
                                    <div class="mt-1 small text-secondary">UI Designer</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="#" class="dropdown-item">Status</a>
                                <a href="./profile.html" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Feedback</a>
                                <div class="dropdown-divider"></div>
                                <a href="./settings.html" class="dropdown-item">Settings</a>
                                <a href="./sign-in.html" class="dropdown-item">Logout</a>
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

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js">
        >
    </script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    @stack('scripts')
    <script>
        // DataTables Init
        $(function() {
            if ($('#table').length) {
                $('#table').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
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

        // Notifikasi jika Error (Pesan Manual)
        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif
    </script>
    {{-- @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ada kesalahan pada inputan Anda!'
            });
        </script>
        @endif --}}
</body>

</html>
