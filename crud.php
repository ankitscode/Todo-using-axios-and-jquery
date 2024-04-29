<?php
include ("connection.php");
$data = json_decode(file_get_contents("php://input"), true);
if(isset($data["showData"])){
$query = "SELECT * FROM `axioss`";
$query_run = mysqli_query($conn, $query);
$result_array = [];

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
        array_push($result_array, $row);
    }
    header('Content-type: application/json');
    echo json_encode(["status" => 1, "message" => "data found", "data" => $result_array]);
} else {
    echo $return = "there is some problem";
    echo json_encode(["status" => 0, "message" => "data not found", "data" => "No Record Found"]);

} 

}

if (isset($data['checking_add'])) {
    $tasK = $data['tasK'];
    $query = "INSERT INTO `axioss`(`task`) VALUES ('$tasK')";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        echo json_encode(["status" => 1, "message" => "data is stored", "data" =>"wrong"]);
        die();
    } else {
        echo json_encode(["status" => 0, "message" => "data not found", "data" => "Something Went Wrong.!"]);
    }
// echo "not responding";
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {    
    if (isset($data['checking_delete']) && isset($data['id'])) {
        $id = $data['id'];
        $query = "DELETE FROM `axioss` WHERE id='$id'";
        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            echo json_encode(["status" => 1, "message" => "Data deleted successfully"]);
        } else {
            echo json_encode(["status" => 0, "message" => "Failed to delete data"]);
        }
    
    } 
}
// if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if (isset($data["data"]['checking_update'])) {
        $id = $data["data"]['id'];
        $tasK = $data["data"]['tasK'];
         $query = "UPDATE axioss SET task= '$tasK'  WHERE id='$id' ";
        $query_run = mysqli_query($conn, $query);
        $getQuery = "SELECT * FROM `axioss`";
        $result = mysqli_query($conn, $getQuery);
         $allData = mysqli_fetch_all($result);
        if ($query_run) {
            echo json_encode(["status" => 1,
                "data"=> $allData,
            "message" => "Data updated  successfully"]);
        } else {
            echo json_encode(["status" => 1, "message" => "Data not updated successfully"]);
        }
    }
    
//    }
?>