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
    <link rel="stylesheet" href="./css/bootstrap.min.css"></script>
    <title>Listado Clientes</title>
</head>
<body>
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
                    $empleado = new ClassicModel();
                    echo $empleado->drawEmployeesList();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>