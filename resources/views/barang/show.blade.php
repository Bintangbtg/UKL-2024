<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tambahan gaya kustom */
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Detail Barang</h2>
            </div>
        </div>
        <div class="form-group">
            <strong>Nama:</strong>
            {{ $barang->nama }}
        </div>
        <div class="form-group">
            <strong>Deskripsi:</strong>
            {{ $barang->deskripsi }}
        </div>
        <div class="form-group">
            <strong>Harga:</strong>
            {{ $barang->harga }}
        </div>
        <div class="form-group">
            <a class="btn btn-primary" href="{{ route('barang.index') }}">Kembali</a>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>