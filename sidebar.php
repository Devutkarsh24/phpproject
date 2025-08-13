<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            min-width: 220px;
            max-width: 220px;
            background-color: #343a40;
            color: white;
            height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-center">My Project</h4>
        <a href="payment.php">💳 Razorpay</a>
        <a href="index.php">🖼 Image Upload</a>
        <a href="dynamic_rows.php">🧮 Dynamic Rows</a>
        <a href="summernote.php">📝 Summernote</a>
        <a href="items.php">🗂 Items</a>
        <a href="filters.php">🔎 PHP AJAX Filters</a>
    </div>

    <div class="content">
        <!-- Page content will go here -->
