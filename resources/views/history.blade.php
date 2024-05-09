<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Coffee Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/menu">Menu <span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/history">History <span class="sr-only"></span></a>
                </li>
            </ul>
            <a href="/keranjang" class="btn btn-outline-success my-2 my-sm-0">Keranjang</a>
            <button class="btn btn-outline-danger my-2 my-sm-0 btn-logout" type="submit" style="margin-left: 10px;">Logout</button>
        </div>
    </nav>
<br><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Order List</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Order Type</th>
                                        <th>Order Date</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="orderTable">
                                    <!-- Data will be inserted here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchOrders();
        });

        function fetchOrders() {
            var token = localStorage.getItem('token');
            fetch(`http://localhost:8000/api/order`, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
            })
                .then(response => response.json())
                .then(data => {
                    const orderTable = document.getElementById('orderTable');
                    orderTable.innerHTML = ''; // Clear existing table content

                    data.data.forEach(order => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${order.customer_name}</td>
                            <td>${order.order_type}</td>
                            <td>${order.order_date}</td>
                            <td>
                                <ul>
                                    ${order.detail_orders.map(detail => `<li>${detail.coffee_id} (${detail.quantity})</li>`).join('')}
                                </ul>
                            </td>
                        `;
                        orderTable.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.href = '/';
                });
        }

        document.querySelector('.btn-logout').addEventListener('click', function() {
        const token = localStorage.getItem('token');

            // Jika token tidak ada, beri pesan peringatan
            if (!token) {
                alert('You are not logged in.');
                return;
            }

            // Request ke endpoint logout dengan token
            fetch('http://localhost:8000/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (response.ok) {
                    // Menghapus token dari local storage
                    localStorage.removeItem('token');
                    localStorage.removeItem('id');
                    // Mengarahkan pengguna kembali ke halaman utama
                    window.location.href = '/';
                } else {
                    alert('Logout failed. Please try again later.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to logout. Please try again later.');
            });
        });
    </script>
</body>
</html>