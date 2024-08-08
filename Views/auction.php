<!DOCTYPE html>
<html>
<head>
    <title>Create Auction</title>
</head>
<body>
<form method="post" action="?action=create_auction" enctype="multipart/form-data">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" required>
    <br>
    <label for="image">Image:</label>
    <input type="file" id="image" name="image" required>
    <br>
    <label for="starting_price">Starting Price:</label>
    <input type="number" id="starting_price" name="starting_price" step="0.01" required>
    <br>
    <label for="expiry_date">Expiry Date:</label>
    <input type="datetime-local" id="expiry_date" name="expiry_date" required>
    <br>
    <button type="submit">Create Auction</button>
</form>
</body>
</html>
