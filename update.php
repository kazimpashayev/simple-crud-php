<?php 
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('location:index.php');
        exit;
    } else {
        $user = $_SESSION['user_name'];
    }

    $query = $db->prepare('SELECT * FROM topic WHERE id = ?');
    $query->execute([
        $_GET['id']
    ]);
    
    $rows = $query->fetch(PDO::FETCH_ASSOC);

    if (!$rows) {
        header('location:index.php');
        exit;
    }

    $query2 = $db->prepare('SELECT * FROM category ORDER BY category_name ASC');
    $query2->execute();
    $rows2 = $query2->fetchAll(PDO::FETCH_ASSOC);


   if (isset($_POST['submit'])) {
    
    $title = trim(strip_tags($_POST['title'])) ? trim(strip_tags($_POST['title'])) : $rows['title'];
    $content = trim(strip_tags($_POST['content'])) ? trim(strip_tags($_POST['content'])) : $rows['content'];
    $category_id = trim(strip_tags($_POST['category_id'])) ? trim(strip_tags($_POST['category_id'])) : null;

        if (!$title) {
            $error = 'Basliqi Daxil Edin!';
        }else if (!$content) {
            $error = 'Mezmunu Daxil Edin!';
        } else if (!$category_id) {
            $error = 'Kateqoriyani Daxil Edin!';
        } else {

            $query2 = $db->prepare('UPDATE topic SET
                title = ?,
                content = ?,
                category_id = ?
                WHERE id = ?');
            
            $result = $query2->execute([
                $title , $content , $category_id , $_GET['id']
            ]);

            if ($result) {
                header('location:index.php');
                exit;
            }
        }
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Crud PHP - Dashboard</title>
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
                    <li class="nav-item">
                        <a href="index.php?page=categories" class="nav-link">Users</a>
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
        <h2>Update Topic</h2>
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-12">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger mb-4">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group mb-2">
                                <label for="">Title</label>
                                <input name="title" class="form-control" type="text" value="<?php echo isset($_POST['title']) ? $_POST['title'] : $rows['title'] ?>">
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Content</label>
                                <textarea name="content" cols="30" rows="10" placeholder="Mezmun" class="form-control"><?php echo isset($_POST['content']) ? $_POST['content'] : $rows['content'] ?></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <label for="">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select category</option>
                                    <?php foreach ($rows2 as $row): ?>
                                        <option <?php echo $row['id'] == $rows['category_id'] ? ' selected' : null; ?> value="<?php echo $row['id'] ?>"><?php echo $row['category_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button name="submit" type="submit" class="btn btn-primary mt-2">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>


</body>
</html>