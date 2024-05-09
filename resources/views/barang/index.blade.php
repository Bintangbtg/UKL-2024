<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <br><center>
                <h2>Daftar Barang</h2></center>
                <div class="float-right">
                    <a class="btn btn-success" href="{{ route('barang.create') }}">Tambah Barang</a>
                </div>
            </div>
        </div>
        <br>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <br>
        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($barangs as $barang)
            <tr>
                <td>{{ $barang->nama }}</td>
                <td>{{ $barang->deskripsi }}</td>
                <td>{{ $barang->harga }}</td>
                <td>
                    <form action="{{ route('barang.destroy',$barang->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('barang.show',$barang->id) }}">Tampilkan</a>
                        <a class="btn btn-primary" href="{{ route('barang.edit',$barang->id) }}">Edit</a>
                        <a class="btn btn-primary" href="{{ route('transaksi.beli',$barang->id) }}">Beli</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>