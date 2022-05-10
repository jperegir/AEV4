<?php
require_once('autoload.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    </script>
    <title>Listado Clientes</title>
</head>

<body>
    <?php 
        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;
        $classicM = new ClassicModel();
        $total_rows = $classicM->countEmployees();
        $total_pages = ceil($total_rows / $no_of_records_per_page);
    ?>
    <div class="container mt-5">
        <a href="new.php" class="btn btn-success col-md-12 text-center" role="button">Nuevo Empleado</a>
    </div>
    <div class="container my-5">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">jobTitle</th>
                    <th scope="col">Boss</th>
                    <th scope="col">Contact</th>
                    <th scope="col-2">Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cm = new ClassicModel();
                echo $cm->drawEmployeesList($offset, $no_of_records_per_page);
                ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                <li class="page-item <?php if ($pageno <= 1) {echo 'disabled';} ?>"><a class="page-link" href="<?php if ($pageno <= 1) {echo '#';} else {echo "?pageno=" . ($pageno - 1);} ?>">&#60;&#60;&#60;</a>
                </li>
                <li class="page-item <?php if ($pageno >= $total_pages) {echo 'disabled';} ?>"><a class="page-link" href="<?php if ($pageno >= $total_pages) {echo '#';} else {echo "?pageno=" . ($pageno + 1);} ?>">&#62;&#62;&#62;</a>
                </li>
                <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
            </ul>
        </nav>
    </div>
</body>

</html>