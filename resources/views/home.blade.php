<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Menu</title>
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
    <div class="container">
        <div class="main py-3">
            <h3>Menu Transaksi</h3>

            <a href="{{ route('coffe.create') }}" class="btn btn-success mb-3">Add New Menu</a>

            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Menu Name</th>
                        <th>Image</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="menuTable">
                    <!-- Table content will be generated dynamically -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
    // Mendefinisikan fungsi deleteCoffee di luar dari fungsi fetchMenu
    function deleteCoffee(coffeeId) {
        var token = localStorage.getItem('token');
        console.log(token)
        if (confirm("Are you sure you want to delete this coffee?")) {
            fetch(`http://localhost:8000/api/coffee/${coffeeId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token
                    // Add any other headers if needed, like CSRF token
                },
            })
            .then(response => {
                if (response.ok) {
                    alert("Coffee deleted successfully.");
                    window.location.reload(); // Reload page or update UI as needed
                } else {
                    alert("Failed to delete coffee.Login ya dek");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("An error occurred while deleting coffee.");
            });
        }
    }

    function fetchMenu() {
        fetch('http://localhost:8000/api/coffee/:search')
            .then(response => response.json())
            .then(data => {
                const menuTable = document.getElementById('menuTable');
                menuTable.innerHTML = ''; // Clear existing table content

                // Iterate over each menu item in the response data
                data.data.forEach(menu => {
                    const tr = document.createElement('tr');
                    const editUrl = '/coffe/' + 'edit/' + menu.id;
                    const Delete = menu.id;
                    tr.innerHTML = `
                        <td>${menu.name}</td>
                        <td>${menu.image}</td>
                        <td>${menu.size}</td>
                        <td>${menu.price}</td>
                        <td class="action-links">
                            <a href="${editUrl}" class="btn btn-primary">Edit</a> | 
                            <button class="btn btn-danger" onclick="deleteCoffee(${Delete})">Delete</button>
                        </td>
                    `;
                    menuTable.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    fetchMenu(); // Call the function to fetch menu when the page loads

    function searchMenu() {
        const searchInput = document.getElementById('searchInput').value;
        // You can implement search functionality here
        // For simplicity, I'm just refetching all menu
        fetchMenu();
    }

    document.querySelector('.btn-logout').addEventListener('click', function() {
        const token = localStorage.getItem('token');

            // Jika token tidak ada, beri pesan peringatan
            if (!token) {
                alert('You are not logged in.');
                window.location.href = '/';
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
</html>