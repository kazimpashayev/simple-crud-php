<?php 

    if ($_SESSION['session']) {
        $user = $_SESSION['user_name'];
    } else {
        header('location:index.php?page=login');
        exit;
    }

    $where = [];

    $sql = 'SELECT topic.id, topic.title, topic.content, category.category_name  FROM topic INNER JOIN category ON category.id = topic.category_id ';

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $where[] .= '(topic.title LIKE "%' . $_GET['search'] . '%" || topic.content LIKE "%' . $_GET['search'] . '%")';
    }

    if (isset($_GET['starter']) && !empty($_GET['starter']) && isset($_GET['finish']) && !empty($_GET['finish'])) {
        $where[] .= 'topic.date BETWEEN "' . $_GET['starter'] . ' 00:00:00" AND "' . $_GET['finish'] . ' 23:59:59"';
    }

    if (count($where) > 0) {
        $sql .= ' WHERE ' . implode(' && ', $where);
    }

    $sql .= ' ORDER BY topic.id DESC';
    $query = $db->prepare($sql);
    $query->execute();
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    $limit = 10;
    $start = isset($_GET['start']) ? $_GET['start'] : 0;
    $query2 = $db->prepare('SELECT * FROM topic ORDER BY id DESC LIMIT ' . $start . ',' . $limit);
    $query2->execute();
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
        <h2>Topics</h2>
        <hr>
        <form method="GET" class="d-flex">
            <input class="form-control" name="search" type="text" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" placeholder="Enter..">
            <button class="btn btn-outline-success ms-2" type="submit">Search</button>
        </form>
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-12">
                <table class="table table-bordered">
                    <?php if ($rows): ?>
                    <thead>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['title'] ?></td>
                            <td><?php echo $row['category_name'] ?></td>
                            <td><?php echo $row['content'] ?></td>
                            <td>
                                <a href="index.php?page=read&id=<?php echo $row['id'] ?>" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                <a href="index.php?page=update&id=<?php echo $row['id'] ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                <a href="index.php?page=delete&id=<?php echo $row['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                    </tbody>
                    <?php else:?>
                       <div>
                            <?php if (isset($_GET['search'])): ?>
                                <div class="alert alert-warning">
                                    Nothing matching your criteria found!
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    No topics have been added yet
                                </div>
                            <?php endif; ?>
                       </div>
                    <?php endif; ?>
                  </table>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>