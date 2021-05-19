<?php 

    if (!$_SESSION['session']) {
        header('location:index.php?page=login');
        exit;
    } else {
        $user = $_SESSION['user_name'];
    }

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('location:index.php?page=categories');
        exit;
    }

    $query = $db->prepare('SELECT * FROM category WHERE id = ?');
    $query->execute([
        $_GET['id']
    ]);
    
    $rows = $query->fetch(PDO::FETCH_ASSOC);

    if (!$rows) {
        header('location:index.php?page=categories');
        exit;
    }

    $query2 = $db->prepare('SELECT * FROM topic WHERE category_id = ? ORDER BY id DESC');
    $query2->execute([
        $rows['id']
    ]);

    $rows2 = $query2->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Crud PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-md navbar-light bg-light border-bottom p-3">
        <div class="container">
            <a href="/" class="navbar-brand">Simple Crud</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navRes">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navRes">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a href="index.php?page=topic" class="nav-link"> Create New Post</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=categories" class="nav-link">Categories</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="#navDrop" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-user-circle"></i> <?= $user ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navDrop">
                            <li><a href="index.php?page=logout" class="dropdown-item"><i class="fa fa-sign-out-alt"></i> Log Out </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Category: <?php echo $rows['category_name'] ?></h2>
        <hr>
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-12">
                <table class="table table-bordered">
                    <?php if ($rows2): ?>
                    <thead>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                    <?php foreach ($rows2 as $row): ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['title'] ?></td>
                            <td><?php echo $row['content'] ?></td>
                            <td>
                                <a href="index.php?page=read&id=<?php echo $row['id'] ?>" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                <a href="index.php?page=update&id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="index.php?page=delete&id=<?php echo $row['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                    </tbody>
                    <?php else: ?>
                        <p>Nothing found in this category!</p>
                    <?php endif; ?>
                  </table>
            </div>
        </div>
    </div>


</body>
</html>