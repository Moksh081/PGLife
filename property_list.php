<?php
session_start();
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$city_name = $_GET["city"];

// $city_filter = isset($_GET['city_id']) ? (int)$_GET['city_id'] : 0;
$sort_order = isset($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc']) ? $_GET['sort'] : 'asc';

$query = "SELECT p.id, p.name, c.name AS city_name, p.address, p.description, p.gender, p.rent, p.user_id, p.approved 
          FROM properties p 
          JOIN cities c ON p.city_id = c.id 
          WHERE p.approved = 1 AND c.name = ?";

$query .= " ORDER BY p.rent $sort_order";
$stmt = $conn->prepare($query);

$stmt->bind_param("i",$city_name );

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Best PG's in <?php echo $city_name ?> | PG Life</title>

    <?php
    include "includes/head_links.php";
    ?>
    <link href="css/property_list.css" rel="stylesheet" />
</head>

<body>
    <?php
    include "includes/header.php";
    ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb py-2">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo $city_name; ?>
            </li>
        </ol>
    </nav>

    <noscript>You need to enable JavaScript to run this app.</noscript>
    <!-- < id="root"> -->

</div>

        <div class="page-container">
            <!-- Filter Bar -->
            <div class="filter-bar row justify-content-around">
                <div class="col-auto sort-active" data-toggle="modal" data-target="#filter-modal">
                    <img src="https://res.cloudinary.com/dcvyn4owv/image/upload/v1731656819/filter_spclm8.png" alt="filter">
                    <span>Filter</span>
                </div>
                <div class="col-auto" onclick="window.location.href='?sort=desc'">
                    <img src="https://res.cloudinary.com/dcvyn4owv/image/upload/v1731656822/desc_kygfqd.png" alt="sort-desc">
                    <span>Highest rent first</span>
                </div>
                <div class="col-auto" onclick="window.location.href='?sort=asc'">
                    <img src="https://res.cloudinary.com/dcvyn4owv/image/upload/v1731656825/asc_mr7v3d.png" alt="sort-asc">
                    <span>Lowest rent first</span>
                </div>
            </div>

            <!-- Properties List -->
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="property-card property-id-<?php echo $row['id']; ?> row">
                        <div class="image-container col-md-4">
                            <img src="./uploads/<?php echo $row['user_id']; ?>/<?php echo $row['id']; ?>/main.jpg" alt="property">
                        </div>
                        <div class="content-container col-md-8">
                            <div class="row no-gutters justify-content-between">
                                <div class="star-container" title="4.5">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="interested-container">
                                    <i class="is-interested-image far fa-heart" onclick="toggleInterested(<?php echo $row['id']; ?>)"></i>
                                    <div class="interested-text">
                                        <span class="interested-user-count">10</span> interested
                                    </div>
                                </div>
                            </div>
                            <div class="detail-container">
                                <div class="property-name"><?php echo htmlspecialchars($row['name']); ?></div>
                                <div class="property-address"><?php echo htmlspecialchars($row['address']); ?></div>
                                <div class="property-gender">
                                    <img src="./img/<?php echo $row['gender'] === 'male' ? 'male.png' : ($row['gender'] === 'female' ? 'female.png' : 'unisex.png'); ?>" alt="gender">
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="rent-container col-6">
                                    <div class="rent">₹ <?php echo number_format($row['rent']); ?>/-</div>
                                    <div class="rent-unit">per month</div>
                                </div>
                                <div class="button-container col-6">
                                    <a href="property_detail.php?property_id=<?php echo $row['id']; ?>" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-property-container">
                    <p>No PG to list</p>
                </div>
            <?php endif; ?>
        </div>

        <?php
    include "includes/signup_modal.php";
    include "includes/login_modal.php";
    include "includes/footer.php";
    $stmt->close();
$conn->close();
    ?>
</body>

</html>
