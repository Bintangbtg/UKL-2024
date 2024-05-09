<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Item</div>

                    <div class="card-body">
                        <form id="addItemForm">
                            <div class="form-group">
                                <label for="id_produk">Product ID</label>
                                <input type="text" class="form-control" id="id_produk" name="id_produk" required>
                            </div>

                            <div class="form-group">
                                <label for="jumlah">Quantity</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addItemForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const orderId = "{{ $orderId }}"; // Mengambil order ID dari Blade

            fetch(`/tambahitem/${orderId}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                window.location.href = '/history';
                // Handle response data as needed
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>