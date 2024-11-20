<?php
// Database connection
session_start();
require "includes/database_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = (int)$_SESSION['user_id'];
    // echo $user_id;
    // return;
    $pg_name = $_POST['pg_name'];
    $city_id = $_POST['city_id'];
    $city_name = $_POST['city_name'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $gender = $_POST['gender'];
    $rent = $_POST['rent'];
    $idid=0;
    // $rating_clean = $_POST['rating_clean'];
    // $rating_food = $_POST['rating_food'];
    // $rating_safety = $_POST['rating_safety'];
    
    // insert city id and name to cities table(id, name) if not exist
    $city_query = "SELECT id FROM cities WHERE name = ? AND id = ?";
    $city_stmt = $conn->prepare($city_query);
    $city_stmt->bind_param("si", $city_name, $city_id);
    $city_stmt->execute();
    $city_stmt->store_result();
    $city_stmt->bind_result($idid);
    $city_stmt->fetch();
    $city_stmt->close();
    if ($idid == 0) {
        $city_query = "INSERT INTO cities (id, name) VALUES (?, ?)";
        $city_stmt = $conn->prepare($city_query);
        $city_stmt->bind_param("is", $city_id, $city_name);
        $city_stmt->execute();
        $city_stmt->close();
    }

    // Insert PG details into the database
    $query = "INSERT INTO properties (name, city_id, address, description, gender, rent, user_id, approved) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sissssd", $pg_name, $city_id, $address, $description, $gender, $rent, $user_id);
    // $stmt->execute();
    if ($stmt->execute()) {

        $property_id = $stmt->insert_id;
        $amenities = isset($_POST['amenities']) ? $_POST['amenities'] : [];

        foreach ($amenities as $amenity_id) {
            $amenity_query = "INSERT INTO properties_amenities (property_id, amenity_id) VALUES (?, ?)";
            $amenity_stmt = $conn->prepare($amenity_query);
            $amenity_stmt->bind_param("ii", $property_id, $amenity_id);
            $amenity_stmt->execute();
            $amenity_stmt->close();
        }
        // $user_id = $_SESSION['user_id'];
        // echo $user_id;
        $upload_dir = "./uploads/$user_id/$property_id/";

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $images = isset($_FILES['pg_images']) ? $_FILES['pg_images'] : [];
        $image_paths = [];
        // echo $images;
        if (move_uploaded_file($_FILES["pg_images"]["tmp_name"], $upload_dir.basename($_FILES["pg_images"]["name"]))) {
            echo "The file ". htmlspecialchars( basename( $_FILES["pg_images"]["name"])). " has been uploaded.";
            } else {
            echo "Sorry, there was an error uploading your file.";
            }
            // foreach($_FILES["pg_images"]["tmp_name"] as $key=>$tmp_name) {
            //     $file_name=$_FILES["files"]["name"][$key];
            //     $file_tmp=$_FILES["files"]["tmp_name"][$key];
            //     $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            
            //     echo $file_name;
            // }

        // if (is_array($images['name'])) {
        //     for ($i = 0; $i < count($images['name']); $i++) {
        //         $image_name = basename($images['name'][$i]);
        //         $target_file = "{$upload_dir}{$image_name}";

        //         if (move_uploaded_file($images['tmp_name'][$i], $target_file)) {
        //             $image_paths[] = $target_file;
        //         }
        //     }
        // }

        // Update the property record with the image paths
        // $image_paths_str = implode(',', $image_paths);
        // $update_query = "UPDATE properties SET images = ? WHERE id = ?";
        // $update_stmt = $conn->prepare($update_query);
        // $update_stmt->bind_param("si", $image_paths_str, $property_id);
        // $update_stmt->execute();
        // $update_stmt->close(); 

        echo "New PG added successfully!";
    } else { 
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
