<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Ordering System</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .coffee-section {
            padding: 20px;
            text-align: center;
        }

        .coffee-section img {
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
        }

        .coffee-section h3 {
            margin-bottom: 5px;
        }

        .coffee-section button {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
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
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
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
        <div class="row" id="coffeeSections"></div>
    </div>

    <script>
    function fetchCoffees() {
        fetch('http://localhost:8000/api/coffee/:search')
            .then(response => response.json())
            .then(data => {
                const coffeeSections = document.getElementById('coffeeSections');
                coffeeSections.innerHTML = '';

                data.data.forEach(coffee => {
                    const coffeeSection = document.createElement('div');
                    coffeeSection.classList.add('col-md-4', 'coffee-section');

                    const img = document.createElement('img');
                    img.src = 'http://localhost:8000/storage/app/public/images/' + coffee.image; 
                    img.alt = 'Coffee Image';

                    const h3 = document.createElement('h4');
                    h3.textContent = coffee.name;

                    const pSize = document.createElement('p');
                    pSize.textContent = coffee.size;

                    const pPrice = document.createElement('p');
                    pPrice.textContent = coffee.price;

                    const button = document.createElement('button');
                    button.textContent = 'Add to Order';
                    button.classList.add('btn', 'btn-success');

                    // Event listener untuk tombol "Add to Order"
                    button.addEventListener('click', function() {
                        addToOrder(coffee.id, coffee.price);
                    });

                    coffeeSection.appendChild(img);
                    coffeeSection.appendChild(h3);
                    coffeeSection.appendChild(pSize);
                    coffeeSection.appendChild(pPrice);
                    coffeeSection.appendChild(button);

                    coffeeSections.appendChild(coffeeSection);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    fetchCoffees(); // Panggil fungsi untuk mengambil data kopi saat halaman dimuat

    function searchMenu() {
        const searchInput = document.getElementById('searchInput').value;
        // Anda bisa implementasikan fungsi pencarian di sini
        // Untuk kesederhanaan, saya hanya akan mengambil semua kopi kembali
        fetchCoffees();
    }

    function addToOrder(id, price) {
        // Mengambil data order yang sudah ada dari local storage atau membuat array kosong jika belum ada
        const orders = JSON.parse(localStorage.getItem('orders')) || [];

        // Menambahkan data order baru ke dalam array orders
        orders.push({ id, price, quantity: 1 });

        // Menyimpan kembali array orders ke dalam local storage
        localStorage.setItem('orders', JSON.stringify(orders));
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
</body>
</html>