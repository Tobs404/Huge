<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }

        .container {
            width: 500px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 80px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        .btn:hover {
            background: #0056b3;
        }

        #preview {
            margin-top: 10px;
            max-width: 120px;
            display: none;
            border: 1px solid #ddd;
            padding: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New Item</h2>

    <form action="<?= Config::get('URL') ?>adminshop/addItem" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Item Image</label>
            <input type="file" name="datei" accept="image/*" onchange="previewImage(event)">
            <img id="preview">
        </div>

        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required></textarea>
        </div>

        <div class="form-group">
            <label>Price ($)</label>
            <input type="number" name="price" step="0.01" required>
        </div>

        <button type="submit" class="btn">Add Item</button>

    </form>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = 'block';
}
</script>

</body>
</html>