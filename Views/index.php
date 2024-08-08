<?php
session_start();

require_once '../config/Database.php';
require_once '../Controllers/UserController.php';
require_once '../Controllers/AuctionController.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

$userController = new UserController();
$auctionController = new AuctionController();

switch ($action) {
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if ($userController->register($username, $password)) {
                echo "Registration successful!";
            } else {
                echo "Registration failed.";
            }
        }
        require_once '../Views/register.php';
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if ($userController->login($username, $password)) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $userController->user->id;
                echo "Login successful!";
            } else {
                echo "Login failed.";
            }
        }
        require_once '../Views/login.php';
        break;

    case 'create_auction':
        if (!isset($_SESSION['username'])) {
            header("Location: ?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_name = $_POST['product_name'];
            $image = $_FILES['image']['name'];
            $starting_price = $_POST['starting_price'];
            $expiry_date = $_POST['expiry_date'];

            // Handle file upload
            $target_dir = "../public/uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            if ($auctionController->createAuction($product_name, $image, $starting_price, $expiry_date)) {
                echo "Auction created successfully!";
            } else {
                echo "Auction creation failed.";
            }
        }
        require_once '../Views/auction.php';
        break;

    case 'place_bid':
        if (!isset($_SESSION['username'])) {
            header("Location: ?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auction_id = $_POST['auction_id'];
            $user_id = $_SESSION['user_id'];
            $bid_amount = $_POST['bid_amount'];
            if ($auctionController->placeBid($auction_id, $user_id, $bid_amount)) {
                echo "Bid placed successfully!";
            } else {
                echo "Bid failed.";
            }
        }
        // Redirect or load auction view
        break;

    default:
        echo "Welcome to the Auction House!";
        break;
}
?>
