<?php
$insert = false;
$update = false;
$delete = false;
// connected to DB START
$servername= "localhost";
$username= "root";
$password= "";
$database= "cwh_crud";

// create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if(!$conn){
  die("Sorry we failed to connect: ". mysqli_connect_error());
}
// else{
//   echo "Connection was successful <br>";
// }
// connected to DB END


// CREATE OPERATION
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset( $_POST['snoEdit'])){
    // Update the record
    $sno = $_POST["snoEdit"];
    $title = $_POST["title_edit"];
    $description = $_POST["description_edit"];
    // Sql query to Update data in DB
    $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`S.No.` = $sno";
    $result = mysqli_query($conn, $sql);
    if($result){
      // echo "saved";
      $update = true;
     }else{
       echo "not saved";
     }
  }
  else{
    // Insert the record
  $title = $_POST["title"];
  $description = $_POST["description"];
  // Sql query to Insert data in DB
  $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
  
  $result = mysqli_query($conn, $sql);
  if($result){
   $insert = true;
  }else{
    echo "There is error";
    mysqli_error($conn);
  }
}
}
// Sql query to Insert data in DB END

// Delete Query
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  // echo $sno;
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `S.No.` = $sno";
  $result = mysqli_query($conn, $sql);
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHP CRUD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- date table -->
     <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
</head>

<body>
 
  <!-- Edit Modal -->
 <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button> -->

<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Record</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="index.php" method="post">
        <input type="hidden" name="snoEdit" id="snoEdit">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title_edit" name="title_edit" placeholder="Enter anything">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description_edit" name="description_edit" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Update Note</button>

    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

  <!-- Edit Modal END -->
   <?php
   if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Succcess</strong> Record Saved.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
   }
   ?>
      <?php
   if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Succcess</strong> Record updated Succesfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
   }
   ?>
      <?php
   if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Delete</strong> Record Deleted Sucessfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
   }
   ?>
  <div class="container my-4">
    <h2>CRUD OPERATION</h2>
    <form action="index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter anything">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>

    </form>
  </div>

  <div class="container my-4">
  <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sql);
        $sno = 0;
        while($row = mysqli_fetch_assoc($result)){
          // echo var_dump($row);
          $sno = $sno + 1;
          echo " <tr>
      <th scope='row'>". $sno ."</th>
      <td>". $row['title'] . "</td>
      <td>". $row['description'] . "</td>
      <td><button class='edit btn btn-sm btn-primary' id=". $row['S.No.'] .">Edit</button> <button class='delete btn btn-sm btn-danger' id=d".$row['S.No.'] .">Delete</button> </td>
    </tr>";
          // echo $row['S.No.'] . ". Title ". $row['title']. "Description is ". $row['description'];
        }
         ?>
      </tbody> 
    </table>
 
  </div>
  <hr>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
           <!-- jquery -->
           <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
  
  <script>
  let table = new DataTable('#myTable');
  </script>
  <!-- Edit Modal JS Functionality -->
       <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          // console.log("edit");
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          // console.log(title, description)
          title_edit.value = title;
          description_edit.value =description;
          snoEdit.value = e.target.id;
          console.log(e.target.id);
          $('#editModal').modal('toggle');
        })
      })

      // Delete Handling
      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener("click", (e)=>{
          console.log("delete");
          sno = e.target.id.substr(1,);

          if(confirm("Are you sure you want to delete")){
            // console.log("yes");
            window.location = `index.php?delete=${sno}`;
          }else{
            // console.log("no");
          }
        })
      })
     </script>
</body>

</html>