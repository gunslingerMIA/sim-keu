<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Login - SIM-KEU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="card card-md border-primary">
                <div class="card-body text-center">
                    <h2 class="mb-3">Selamat Datang</h2>
                    <p class="text-muted">Silakan pilih tahun anggaran untuk memulai bekerja.</p>
                    <form action="{{ route('tahun.simpan') }}" method="post">
                        @csrf
                        <select name="tahun" class="form-select form-select-lg mb-3">
                            <option value="" disabled>Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->tahun }}" {{ session('tahun_anggaran') == $year->tahun ? 'selected' : '' }}>
                                    {{ $year->tahun }}
                                </option>                                
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>