<?php
// process.php - ALL website logic in 1 file
include "config.php";

$action = $_GET["action"];

if ($action == "register") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username already used'); window.location='register.php';</script>";
    } else {
        mysqli_query($conn, "INSERT INTO users (name,phone,address,username,password,role) VALUES ('$name','$phone','$address','$username','$password','customer')");
        echo "<script>alert('Register success, please login'); window.location='login.php';</script>";
    }
}

else if ($action == "login") {
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];

    $q = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($q);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["name"] = $user["name"];
        if ($user["role"] == "admin") {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: user/dashboard.php");
        }
    } else {
        echo "<script>alert('Wrong username or password'); window.location='login.php';</script>";
    }
}

else if ($action == "logout") {
    session_destroy();
    header("Location: index.php");
}

else if ($action == "add_order") {
    if (!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }
    $user_id = $_SESSION["user_id"];
    $service_id = $_POST["service_id"];
    $weight = $_POST["weight"];
    $service_type = $_POST["service_type"];
    $pickup_date = mysqli_real_escape_string($conn, $_POST["pickup_date"]);
    $pickup_address = mysqli_real_escape_string($conn, $_POST["pickup_address"]);
    $notes = mysqli_real_escape_string($conn, $_POST["notes"]);

    $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM services WHERE id='$service_id'"));
    $total = $weight * $s["price_per_kg"];

    mysqli_query($conn, "INSERT INTO orders (user_id,service_id,weight,total_price,service_type,pickup_date,pickup_address,notes,status) VALUES ('$user_id','$service_id','$weight','$total','$service_type','$pickup_date','$pickup_address','$notes','Waiting')");
    echo "<script>alert('Order created!'); window.location='user/my_orders.php';</script>";
}

else if ($action == "update_status") {
    if ($_SESSION["role"] != "admin") { header("Location: login.php"); exit; }
    $order_id = $_POST["order_id"];
    $status = $_POST["status"];
    $weight = $_POST["weight"];
    // recalculate price if admin updates weight
    $o = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM orders WHERE id='$order_id'"));
    $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM services WHERE id='" . $o["service_id"] . "'"));
    $total = $weight * $s["price_per_kg"];
    mysqli_query($conn, "UPDATE orders SET status='$status', weight='$weight', total_price='$total' WHERE id='$order_id'");
    header("Location: admin/orders.php");
}

else if ($action == "add_service") {
    if ($_SESSION["role"] != "admin") { exit; }
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $price = $_POST["price_per_kg"];
    $desc = mysqli_real_escape_string($conn, $_POST["description"]);
    mysqli_query($conn, "INSERT INTO services (name,price_per_kg,description) VALUES ('$name','$price','$desc')");
    header("Location: admin/services.php");
}

else if ($action == "edit_service") {
    if ($_SESSION["role"] != "admin") { exit; }
    $id = $_POST["id"];
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $price = $_POST["price_per_kg"];
    $desc = mysqli_real_escape_string($conn, $_POST["description"]);
    mysqli_query($conn, "UPDATE services SET name='$name', price_per_kg='$price', description='$desc' WHERE id='$id'");
    header("Location: admin/services.php");
}

else if ($action == "delete_service") {
    if ($_SESSION["role"] != "admin") { exit; }
    $id = $_GET["id"];
    mysqli_query($conn, "DELETE FROM services WHERE id='$id'");
    header("Location: admin/services.php");
}

else if ($action == "send_message") {
    if (!isset($_SESSION["user_id"])) {
        if (isset($_POST["ajax"]) || isset($_GET["ajax"])) {
            header("Content-Type: application/json");
            echo json_encode(["ok" => 0, "error" => "not logged in"]);
            exit;
        }
        header("Location: login.php"); exit;
    }
    $order_id = $_POST["order_id"];
    $message = mysqli_real_escape_string($conn, $_POST["message"]);
    $sender = $_SESSION["role"];
    mysqli_query($conn, "INSERT INTO messages (order_id,sender,message) VALUES ('$order_id','$sender','$message')");
    $is_ajax = isset($_POST["ajax"]) || isset($_GET["ajax"]);
    if ($is_ajax) {
        header("Content-Type: application/json");
        echo json_encode(["ok" => 1, "sender" => $sender, "message" => $_POST["message"]]);
        exit;
    }
    if ($sender == "admin") {
        header("Location: admin/order_detail.php?id=$order_id");
        exit;
    } else {
        header("Location: user/order_detail.php?id=$order_id");
        exit;
    }
}

else if ($action == "delete_message") {
    // only admin can delete messages
    if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
        echo "<script>alert('Only admin can delete messages'); window.location='user/my_orders.php';</script>";
        exit;
    }
    $msg_id = $_GET["id"];
    $order_id = $_GET["order_id"];
    mysqli_query($conn, "DELETE FROM messages WHERE id='$msg_id'");
    header("Location: admin/order_detail.php?id=$order_id");
}

else if ($action == "update_profile") {
    $id = $_SESSION["user_id"];
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);
    mysqli_query($conn, "UPDATE users SET name='$name', phone='$phone', address='$address' WHERE id='$id'");
    $_SESSION["name"] = $name;
    echo "<script>alert('Profile updated'); window.location='user/profile.php';</script>";
}
?>
