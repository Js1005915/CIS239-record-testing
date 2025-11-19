<?php

use BcMath\Number;

#including the functions and db files

include __DIR__ . "/data/functions.php";

session_start();

#setting the view and action via INPUT_GET and INPUT_POST
$view   = filter_input(INPUT_GET, 'view') ?: 'list';
$action = filter_input(INPUT_POST, 'action');

#checks if the session is empty
function require_login(): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: ?view=login');
        exit;
    }
}

$public_views   = ['login', 'register'];
$public_actions = ['login', 'register'];

#checks if the action is true and if the action is in the array of public actions
if ($action && !in_array($action, $public_actions, true)) {
    require_login();
}
#checks if the action is true and if the view is in the array of public views
if (!$action && !in_array($view, $public_views, true)) {
    require_login();
}

switch ($action) {
    #when action is set to login, it gets the username and password from the post and then finds the user using the user_find_by_username function
    #if the login is correct, it logs in, else it shows error messages
    case 'login':
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($username && $password) {
        $user = user_find_by_username($username);
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $view = 'list';
        } else {
            $login_error = "Invalid username or password.";
            $view = 'login';
        }
    } else {
        $login_error = "Enter both fields.";
        $view = 'login';
    }
    break;

    case 'logout':
        $_SESSION = [];
        session_destroy();
        session_start();
        $view = 'login';
        break;
    
    #gets the username, fullname, password and confirmed password from the post, if they are all inputted and password is the same as the confirmed password
    #it creates a user using the user_create function and hashes the password, then it puts the user info in the navbar
    case 'register':
        $username  = trim((string)($_POST['username'] ?? ''));
        $full_name = trim((string)($_POST['full_name'] ?? ''));
        $password  = (string)($_POST['password'] ?? '');
        $confirm   = (string)($_POST['confirm_password'] ?? '');

        if ($username && $full_name && $password && $password === $confirm) {
            $existing = user_find_by_username($username);
            if ($existing) {
                $register_error = "That username already exists.";
                $view = 'register';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                user_create($username, $full_name, $hash);

                $user = user_find_by_username($username);
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $view = 'list';
            }
        } else {
            $register_error = "Complete all fields and match passwords.";
            $view = 'register';
        }
        break;


    #requires a login, then if a record is inputted, it puts the record by its record_id into the cart session
    #also checks if the cart session was started at all
    case 'add_to_cart':
        require_login();
        $record_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($record_id) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $_SESSION['cart'][] = $record_id;
        }
        $view = 'list';
        break;

    #requires a login, gets the cart ids from the cart session and creates a purchase for each card id
    #if it works, it switches the view to checkout_success 
    case 'checkout':
        require_login();
        $cart_ids = $_SESSION['cart'] ?? [];

        if ($cart_ids) {
            foreach ($cart_ids as $rid) {
                purchase_create((int)$_SESSION['user_id'], (int)$rid);
            }
            $_SESSION['cart'] = [];
        }
        $view = 'checkout_success';
        break;

    case 'create':
        $title = trim((string)(filter_input(INPUT_POST, 'title') ?? ''));
        $artist = trim((string)(filter_input(INPUT_POST, 'artist') ?? ''));
        $price = trim((float)(filter_input(INPUT_POST, 'price') ?? 0));
        $format_id = trim((int)(filter_input(INPUT_POST, 'format_id') ?? 0));

        if ($title && $artist && $format_id) {
            record_insert($title, $artist, $price, $format_id);
            $view = 'created';
        } else {
            $view = 'create'; // missing fields
        }
        break;
    case 'edit':
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $record = record_get($id);
            
        }

        $view = 'create';
        break;
    case 'update':
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $title = (string)filter_input(INPUT_POST, 'title', FILTER_UNSAFE_RAW);
        $artist = (string)filter_input(INPUT_POST, 'artist', FILTER_UNSAFE_RAW);
        $price_in = filter_input(INPUT_POST, 'price', FILTER_UNSAFE_RAW);
        $format_id = filter_input(INPUT_POST, 'format_id', FILTER_VALIDATE_INT);

        $price = is_numeric($price_in) ? (float)$price_in : null;

        if ($id && $title !== '' && $artist !== '' && $price !== null && $format_id) {
            record_update($id, $title, $artist, $price, $format_id);
        }
        $view = 'updated';
        break;
    case 'delete':
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            $deleted = record_delete($id);
        }
        $view = 'deleted';
        break;
}
if ($view === 'cart') {
    $cart_ids = $_SESSION['cart'] ?? [];
    $records_in_cart = records_by_ids($cart_ids);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <title>List Page</title>
    
</head>
<body>
    <?php include __DIR__ . '/components/nav.php';?>


    <?php 
    #the below code checks the view variable and if it is set to a keyword, changes the page to include the partial responding to that keyword
    if ($view === 'login') {
        include __DIR__ . '/partials/login_form.php';
    }
    elseif ($view === 'register') {
        include __DIR__ . '/partials/register_form.php';
    }
    elseif ($view === 'cart') {
        include __DIR__ . '/partials/cart.php';
    }
    elseif ($view === 'checkout_success') {
        include __DIR__ . '/partials/checkout_success.php';
    }
    elseif ($view === 'list')
        include __DIR__ . '/partials/records-list.php';
    elseif ($view === 'create')
        include __DIR__ . '/partials/record-form.php';
    elseif ($view === 'created')
        include __DIR__ . '/partials/record-created.php';
    elseif ($view === 'updated')
        include __DIR__ . '/partials/record-updated.php';
    elseif ($view === 'deleted')
        include __DIR__ . '/partials/record-deleted.php';
    ?>





    <!-- <h2>Unit Test 1 — Formats</h2>
    <table>
        <td>Formats:</td>
<?php
    $rows = formats_all();
    foreach ($rows as $r):
?>
        
    <td><?= $r['name'] ?></td>

<?php 
endforeach;
?>
</table>



<hr&gt>


<hr> -->
</body>
</html>