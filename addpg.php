<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New PG</title>
    <link rel="stylesheet" href="css/addpg.css">
</head>
<body>
    <div class="form-container">
        <h2>Add New PG</h2>
        <form action="add_pg.php" method="POST" enctype="multipart/form-data">
            <label for="pg_name">PG Name:</label>
            <input type="text" id="pg_name" name="pg_name" required>

            <label for="city_id">City ID:</label>
            <input type="number" id="city_id" name="city_id" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="gender">Gender (Male/Female/Unisex):</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Unisex">Unisex</option>
            </select>

            <label for="rent">Rent (per month):</label>
            <input type="number" id="rent" name="rent" step="0.01" required>

            <label for="rating_clean">Rating (Cleanliness):</label>
            <input type="number" id="rating_clean" name="rating_clean" step="0.1" max="5" min="0" required>

            <label for="rating_food">Rating (Food):</label>
            <input type="number" id="rating_food" name="rating_food" step="0.1" max="5" min="0" required>

            <label for="rating_safety">Rating (Safety):</label>
            <input type="number" id="rating_safety" name="rating_safety" step="0.1" max="5" min="0" required>

            <!-- <label for="pg_images">PG Images:</label>
            <input type="file" id="pg_images" name="pg_images[]" multiple accept="image/*" required> -->

            <input type="submit" value="Add PG">
        </form>
    </div>
</body>
</html>
