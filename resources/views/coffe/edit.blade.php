<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Coffee</title>
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
            <div class="card-header">Edit Coffee</div>

            <div class="card-body">
              <form id="updateForm" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $coffe->id }}">

                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ $coffe->name }}" required>
                </div>

                <div class="form-group">
                  <label for="size">Size</label>
                  <input type="text" class="form-control" id="size" name="size" value="{{ $coffe->size }}" required>
                </div>

                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="number" class="form-control" id="price" name="price" value="{{ $coffe->price }}" required>
                </div>

                <div class="form-group">
                  <label for="image">Image (url)</label>
                  <input type="text" class="form-control" id="image" name="image" value="{{ $coffe->image }}" required>
                </div>

                <div class="text-center mb-3">
                  <button type="submit" class="btn btn-primary">Update</button>
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
      $('#updateForm').submit(function(e){
        e.preventDefault();
        var token = localStorage.getItem('token');

        const id = $('input[name=id]').val();
        const name = $('input[name=name]').val();
        const size = $('input[name=size]').val();
        const price = $('input[name=price]').val();
        const image = $('input[name=image]').val();

        fetch(`/api/coffee/${id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
          },
          body: JSON.stringify({
            name,
            size,
            price,
            image
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.status) {
            alert(data.message);
            window.location.href = '/menu';
          } else {
            alert(data.message);
          }
        })
        .catch(error => {
          console.error(error);
          alert('An error occurred while updating coffee. Please try again.');
          window.location.href = '/';
        });
      });
    });
  </script>
</body>
</html>