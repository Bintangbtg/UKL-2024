<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Coffee</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }

        .vertical-center {
            min-height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-light">
    <div class="vertical-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Add New Coffee</div>

                        <div class="card-body">
                            <form id="createForm" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="size">Size</label>
                                    <input type="text" class="form-control" id="size" name="size" required>
                                </div>

                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" id="price" name="price" required>
                                </div>

                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control-file" id="image" name="image">
                                </div>

                                <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="/menu" class="btn btn-secondary">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#createForm').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var token = localStorage.getItem('token');
                $.ajax({
                    url: '{{ route("coffe.store") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'Authorization': 'Bearer ' + token // Sertakan token dalam header Authorization
                    },
                    success: function(response){
                        alert(response.message);
                        window.location.href = '/menu';
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                        alert('An error occurred while adding coffee. Please try again.');
                        window.location.href = '/';
                    }
                });
            });
        });
    </script>
</body>
</html>