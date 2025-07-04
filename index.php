<?php
//Connecting database
include "config.php";

$insert = false;
$update = false;
$delete = false;

// delete php start
if (isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
    $result = mysqli_query($conn,$sql);
}

//Form php start
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['snoEdit'])) {
        //update the record
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];
        $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
//             echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
//   <strong>Success!</strong> Your note has been updated successfuly.
//   <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
// </div>";

$update = true;
        } else {
            echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
  <strong>Error!</strong> Your note has not been updated!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
        }

    } else {
        //insert record
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // echo "The record has been inserted successfully!";
            $insert = true;
        } else {
            echo "The record has not been inserted successfully!";
        }
    }
}
// Form php end
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNotes</title>
    <!-- bs css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.0/css/dataTables.dataTables.min.css">
</head>

<body>
    <!--Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit This Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <!-- modal form start -->
                    <form action="/PHP/PHP_Tutorial_Youtube/iNotes/index.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" placeholder="Enter Note Title" id="titleEdit"
                                name="titleEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="desc">Note Description</label>
                            <textarea class="form-control" placeholder="Enter Note Description" name="descriptionEdit"
                                id="descriptionEdit" rows="3"></textarea>
                        </div>
                </div>
                <div class="modal-footer d-block mr-auto">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                    </form>
                    <!-- modal form end -->
            </div>
        </div>
    </div>

    <!-- navbar start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">iNotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- navbar end -->
    <!-- record insert alert start -->
    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> You note has been inserted successfuly.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    ?>
    <!-- record insert alert end -->
    <!-- record update alert start -->
    <?php
    if ($update) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> You note has been updated successfuly.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    ?>
    <!-- record update alert end -->
    <!-- record delete alert start -->
    <?php
    if ($delete) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> You note has been deleted successfuly.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    ?>
    <!-- record delete alert end -->
    <!-- form start -->
    <div class="container my-4">
        <h2>Add a Note</h2>
        <form action="/PHP/PHP_Tutorial_Youtube/iNotes/index.php?update=true" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" placeholder="Enter Note Title" id="title" name="title"
                    aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="desc">Note Description</label>
                <textarea class="form-control" placeholder="Enter Note Description" name="description" id="description"
                    rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>
    <!-- form end -->
    <div class="container my-4">
        <!-- table start -->
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- php start -->
                <?php
                $sql = "Select * from `notes`";
                $result = mysqli_query($conn, $sql);

                $sno = 0;

                if (!$result) {
                    die("Query Failed" . mysqli_error($conn));
                }
                while ($row = mysqli_fetch_assoc($result)) {
                    $sno = $sno + 1;
                    echo "
                     <tr>
                    <th scope='row'>" . $sno . "</th>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>
                <button class='edit btn btn-sm btn-success' id=" . $row['sno'] . ">Edit</button>
                <button class='delete btn btn-sm btn-danger' id=d" . $row['sno'] . ">Delete</button>
                </td>
                </tr>
                    ";
                }

                ?>
                <!-- php end -->
            </tbody>
        </table>
        <!-- table end -->
    </div>

    <!-- Bs Js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/2.3.0/js/dataTables.min.js"></script>
    <script>
        //for table
        let table = new DataTable('#myTable');

        //for edit button
        edits = document.getElementsByClassName("edit")
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $('#editModal').modal('toggle');
            })
        });

        
        //for delete button
        deletes = document.getElementsByClassName("delete")
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                sno = e.target.id.substr(1,)
                if (confirm("Are you sure you want to delete this note?")) {
                    console.log("yes");
                    window.location = `/PHP/PHP_Tutorial_Youtube/iNotes/index.php?delete=${sno}`;
                    //user post request to submit a form
                }
                else{
                    console.log("no");
                }
            })
        });
    </script>
</body>

</html>