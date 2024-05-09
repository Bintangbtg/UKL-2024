<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <style>
        /* CSS */
        .container {
            display: flex;
            justify-content: space-between;
            max-width: 900px;
            margin: 40px auto;
        }

        .form-container,
        .order-summary {
            flex: 1;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .customer-info,
        .order-details {
            margin-bottom: 20px;
        }

        .form-container form label {
            display: block;
            margin-bottom: 5px;
        }

        .form-container form input[type="text"],
        .form-container form input[type="date"],
        .form-container form select {
            width: calc(100% - 12px);
            margin-bottom: 10px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container form button {
            width: 100%;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-container form button:hover {
            background-color: #45a049;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details th,
        .order-details td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .order-details th {
            background-color: #f0f0f0;
        }

        .footer {
            text-align: center;
        }

        .footer button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .footer button:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Form Daftar Pesanan</h2>
            <form id="orderForm">
                <div class="customer-info">
                    <label for="customerName">Customer Name:</label>
                    <input type="text" id="customerName" name="customer_name" required>
                </div>
                <div class="customer-info">
                    <label for="orderType">Order Type:</label>
                    <select id="orderType" name="order_type" required>
                        <option value="">Select Order Type</option>
                        <option value="Dine-in">Dine-in</option>
                        <option value="Takeaway">Takeaway</option>
                        <option value="Delivery">Delivery</option>
                    </select>
                </div>
                <div class="customer-info">
                    <label for="orderDate">Order Date:</label>
                    <input type="date" id="orderDate" name="order_date" required>
                </div>
                <button type="button" onclick="submitOrder()">Submit Order</button>
            </form>
        </div>

        <div class="order-summary">
            <h2>Keranjang</h2>
            <div class="order-details">
                <table>
                    <thead>
                        <tr>
                            <th>Coffee Name</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="cartItems"></tbody>
                </table>
            </div>
            <div class="footer">
                <button onclick="processPayment()">Process Payment at Cashier</button>
                <a href="/home"><button>Back to Menu</button></a>
            </div>
        </div>
    </div>

    <script>
        function fetchCartItemDetails() {
            const cartItems = JSON.parse(localStorage.getItem('orders')) || [];
            const cartItemsTable = document.getElementById('cartItems');

            cartItemsTable.innerHTML = '';

            cartItems.forEach(item => {
                fetch(`http://localhost:8000/api/coffee/${item.id}`)
                    .then(response => response.json())
                    .then(data => {
                        const coffee = data.data;
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${coffee.name}</td>
                            <td>${coffee.size}</td>
                            <td>Rp. ${coffee.price},-</td>
                            <td>
                                <button onclick="decreaseQuantity(${item.id})">-</button>
                                ${item.quantity}
                                <button onclick="increaseQuantity(${item.id})">+</button>
                            </td>
                            <td id="total${item.id}">Rp. ${coffee.price * item.quantity},-</td>
                            <td><button onclick="removeItem(${item.id})">Hapus</button></td>
                        `;
                        cartItemsTable.appendChild(row);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        }

        function increaseQuantity(itemId) {
            const cartItems = JSON.parse(localStorage.getItem('orders')) || [];
            const index = cartItems.findIndex(item => item.id === itemId);
            if (index !== -1) {
                cartItems[index].quantity++;
                localStorage.setItem('orders', JSON.stringify(cartItems));
                updateTotalPrice(itemId, cartItems[index].quantity);
            }
        }

        function removeItem(itemId) {
                const cartItems = JSON.parse(localStorage.getItem('orders')) || [];
                const updatedCartItems = cartItems.filter(item => item.id !== itemId);
                localStorage.setItem('orders', JSON.stringify(updatedCartItems));
                fetchCartItemDetails();
                location.reload();
            }

        function decreaseQuantity(itemId) {
            const cartItems = JSON.parse(localStorage.getItem('orders')) || [];
            const index = cartItems.findIndex(item => item.id === itemId);
            if (index !== -1 && cartItems[index].quantity > 1) {
                cartItems[index].quantity--;
                localStorage.setItem('orders', JSON.stringify(cartItems));
                updateTotalPrice(itemId, cartItems[index].quantity);
            }
        }

        function updateTotalPrice(itemId, quantity) {
            const cartItemsTable = document.getElementById('cartItems');
            const itemTotalElement = document.getElementById(`total${itemId}`);
            const itemRow = itemTotalElement.parentNode;
            const price = parseFloat(itemRow.children[2].textContent.split(' ')[1].replace(',', ''));
            itemTotalElement.textContent = `Rp. ${price * quantity},-`;
        }

        function processPayment() {
            const orderId = localStorage.getItem('orderId');
            if (!orderId) {
                alert('Order ID not found. Please make sure to place an order first.');
                return;
            }

            const cartItems = JSON.parse(localStorage.getItem('orders')) || [];

            // Ubah format data untuk sesuaikan dengan yang diharapkan oleh backend
                const orderDetails = cartItems.map(item => ({
                id_produk: item.id,
                jumlah: item.quantity,
                price: item.price
                }));

                fetch(`http://localhost:8000/api/tambahitem/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(orderDetails)
                })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to add items to order.');
                }
                return response.json();
            })
            .then(data => {
                alert('Items added to order successfully.');
                // Clear items from local storage
                localStorage.removeItem('orders');
                localStorage.removeItem('orderId');
                window.location.href = '/history';
                // Reload or redirect to another page if needed
            })
            .catch(error => {
                console.error(JSON.stringify(orderDetails));
                alert('Failed to add items to order. Please try again later.');
            });
        }

        function submitOrder() {
            const customerName = document.getElementById('customerName').value;
            const orderType = document.getElementById('orderType').value;
            const orderDate = document.getElementById('orderDate').value;
            const cartItems = JSON.parse(localStorage.getItem('orders')) || [];

            if (customerName && orderType && orderDate) {
                const orderData = {
                    customer: customerName,
                    type: orderType,
                    order_date: orderDate,
                    items: cartItems.map(item => ({ id: item.id, quantity: item.quantity }))
                };

                fetch('http://localhost:8000/api/order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderData)
                })
                .then(response => response.json())
                .then(data => {
                    const orderId = data.order_id;
                    alert(`Order successfully placed! Order ID: ${orderId}`);
                    localStorage.setItem('orderId', orderId);
                    fetchCartItemDetails();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to submit order. Please try again later.');
                });
            }
        }

        // Fetch cart items when the page loads
        fetchCartItemDetails();
    </script>
</body>
</html>