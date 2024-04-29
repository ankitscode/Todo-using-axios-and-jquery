<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container mt-3">
        <h3> Todo in axios</h13>
            <div class="mt-4 p-5 bg-success text-white rounded">
                <h2>Making Todo in axios using jquery events and php crud operations</h2>
            </div>
    </div>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-6">
                <table class="table table-dark table-hover my-2">
                    <thead>
                        <tr>
                            <th scope="col" width="10%" style="color: crimson;">Id</th>
                            <th scope="col" style="color: crimson;">Task</th>
                            <th scope="col" width="30%" style="color: crimson;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="taskAdding">


                    </tbody>
                </table>

            </div>
            <div class="col-lg-6 col-md-6 col-6">
                <div class="formgroup">
                    <form action="#" method="POST" class="form" style>
                        <div>
                            <label for="tasK"><strong>TASK</strong></label>
                            <input type="text" name="tasK" id="taskvalue" class="form-control" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success" id="submit">ADD TASK</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="js/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#submit").on("click", function (e) {
                e.preventDefault();
                const functionToRun = $(this).html();
                if (functionToRun == "ADD TASK") {
                    adddata();
                }
            });
        });

        function getdata() {
            axios.post('crud.php', {
                'showData': true,
            })
                .then(function (response) {
                    // console.log(response);
                    var rowId = 1;
                    if (response) {
                        $.each(response.data.data, function (key, todo) {
                            var row = `<tr>
                            <td id="id-${todo.id}">${rowId++}</td>
                            <td id="tasK-${todo.id}">${todo.Task}</td>
                            <td>
                            <button class="btn btn-primary" id="editbutton"  onclick="editdata(${todo.id})">Edit</button>
                            <button class="btn btn-danger"id="deleteButton" onclick="deletedata(${todo.id})">Delete</button>
                            </td>
                        </tr>`;
                            $("#taskAdding").append(row);
                        });
                    }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        }
        getdata();

        function adddata() {
            var tasK = $('#taskvalue').val();
            if (tasK != '') {
                axios.post('crud.php', {
                    'checking_add': true,
                    'tasK': tasK,
                })
                    .then(function (response) {
                        if (response.status) {
                            location.reload(true);
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }//function adddata is closing here

        function deletedata(id) {
            axios.delete('crud.php', {
                data: {
                    checking_delete: true,
                    id: id,
                }
            })
                .then(function (response) {
                    location.reload(true);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }//function deletedata is closing here
        function editdata(id) {
            const tasK = $("#tasK-" + id).html();
            $("#taskvalue").val(tasK);
            $("#submit").html("edit");
            $("#submit").attr("data-id", id);
            $("#submit").attr("class", "data-submit btn btn-success");
        }//function editdata is closing here ok 

        $(document).on("click", ".data-submit", function (e) {
            e.preventDefault();
            var taskvalue = $("#taskvalue").val();
            var buttonHTML = $(this).prop('outerHTML'); // Retrieve from the clicked button
            var dataId = $(buttonHTML).data('id');
            var id = dataId;
            var tasK = taskvalue;
            axios.post('crud.php', {
                data: {
                    checking_update: true,
                    id: id,
                    tasK: tasK,
                }
            })
                .then(function (response) {
                    $("#taskAdding").html(" ");
                    var rowId = 1;
                    $.each(response.data.data, function (key, todo) {
                        var row = `<tr>
                            <td id="id-${todo[0]}">${rowId++}</td>
                            <td id="tasK-${todo[0]}">${todo[1]}</td>
                            <td>
                            <button class="btn btn-primary" id="editbutton"  onclick="editdata(${todo[0]})">Edit</button>
                            <button class="btn btn-danger"id="deleteButton" onclick="deletedata(${todo[0]})">Delete</button>
                            </td>
                        </tr>`;
                        $("#taskAdding").append(row);
                    });
                    $("#taskvalue").val("");
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    </script>
</body>

</html>