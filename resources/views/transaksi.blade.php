<!-- resources/views/orders/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Order</div>

                    <div class="card-body">
                        <form id="createOrderForm">
                            <div class="form-group">
                                <label for="customer_name">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>

                            <div class="form-group">
                                <label for="order_type">Order Type</label>
                                <input type="text" class="form-control" id="order_type" name="order_type" required>
                            </div>

                            <div class="form-group">
                                <label for="order_date">Order Date</label>
                                <input type="date" class="form-control" id="order_date" name="order_date" required>
                            </div>

                            <div class="form-group">
                                <label for="order_detail">Order Detail</label>
                                <textarea class="form-control" id="order_detail" name="order_detail" required></textarea>
                                <small class="form-text text-muted">Enter JSON formatted order details. Example: [{"coffee_id":1,"price":5,"quantity":2},{"coffee_id":2,"price":7,"quantity":1}]</small>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('createOrderForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch(`http://localhost:8000/api/order`, {
                method: 'POST',
                body: formData,
                headers: {
                    'Authorization': 'Bearer ' + token
                },
            })
            .then(response => response.json())
            .then(data => {
                // Handle response data as needed
                console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>