<!-- resources/views/transaksi/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Barang</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Beli Barang: {{ $barang->nama }}</h2>
                <p>Deskripsi: {{ $barang->deskripsi }}</p>
                <p>Harga: {{ $barang->harga }}</p>
                <form method="POST" action="{{ route('transaksi.beli', $barang) }}">
                    @csrf

                    <div class="form-group">
                    <input type="hidden" id="user_id" name="user_id">
                        <label for="jumlah">Jumlah:</label>
                        <input type="number" id="jumlah" name="jumlah" min="1" value="1" required class="form-control">
                        @error('jumlah')
                            <span style="color: red;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Beli</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Ambil nilai dari local storage dengan kunci 'id'
        var userId = localStorage.getItem('id');

        // Temukan elemen input hidden berdasarkan ID
        var userIdInput = document.getElementById('user_id');

        // Tetapkan nilai userId ke dalam elemen input hidden
        userIdInput.value = userId;
    </script>
</body>
</html>