<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS kustom untuk penyesuaian tambahan */
        .centered-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            width: 440px; /* Lebarkan container form */
            border: 2px solid #000; /* Perbesar border */
            border-radius: 10px; /* membuat sudut tumpul */
            padding: 20px; /* tambahkan ruang padding agar isi tidak terlalu dekat dengan border */
        }
        .form-group {
            margin-bottom: 20px; /* Tambahkan margin pada setiap elemen form */
        }
        .form-control {
            margin-bottom: 10px; /* Tambahkan margin pada input */
        }
        .btn-block {
            margin-bottom: 10px; /* Tambahkan margin pada tombol register */
        }
    </style>
</head>
<body>

<div class="centered-form">
    <div class="form-container">
        <form id="registerForm">
            <center><h1>REGISTER</h1></center>
            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <p class="text-center mt-3">Sudah punya akun? <a href="/">Login di sini</a></p>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Kirim permintaan register ke API
        fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                name: this.name.value,
                email: this.email.value,
                password: this.password.value
            }),
        })
        .then(response => response.json())
        .then(data => {
            // Redirect ke halaman home setelah berhasil register
            window.location.href = '/login';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>
</html>