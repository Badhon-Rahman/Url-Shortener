@include('layouts.admin.admin')
<link rel="stylesheet" href="{{ asset('css/urls.css') }}">
<main style="text-align: center;">
        <!-- Page Heading -->
    <header class="bg-white shadow" style="text-align:center;">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> 
            <strong>Url Dashboard</strong>
        </div>
    </header>
    <div class="card" style="width: auto">
        <div class="card-body flex">
            <table class="urls">
                <tr>
                    <th>User Id</th>
                    <th>User Name </th>
                    <th>Email</th>
                    <th>User type</th>
                    <th>Action(Update/Delete User)</th>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    @if($user->is_admin == 1)
                    <td>Admin</td>
                    @else
                    <td>Public User</td>
                    @endif
                    <td><a class="btn btn-info" onclick="updateUser({{$user}})" type="button" data-bs-toggle="modal" href="#UpdateUserModal">update</a> <button class="btn btn-danger" type="button" onclick="deleteUser('{{$user->id}}')" data-bs-toggle="modal" href="#deleteUserModal">delete</button></td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
 
    <div class="modal fade" id="UpdateUserModal" aria-hidden="true" aria-labelledby="UpdateUserModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UpdateUserModalLabel">Update User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="userData" style=""></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="updateInfo" onclick="updateinfo();">Update Info</button>
                </div>
           </div>
        </div>
    </div>

    <div class="modal fade" id="deleteUserModal" aria-hidden="true" aria-labelledby="deleteUserModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Update User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <h4>Are you sure deleting this user information?</h4>
                </div>
                <div class="modal-footer">
                    <div class="deleteBtn"></div>
                </div>
           </div>
        </div>
    </div>

</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    //

    $(document).ready(function() {
        const basePath = window.location.origin;

    });

    function updateUser(user){
        $(".userInfo").remove();
        let userInfo = $(".userData");
        userInfo.append(`
            <div class="userInfo">
                <div class="">
                    <input type="hidden" class="form-control" id="getUserId" value="${user.id}">
                    <label for="updateUserName" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="updateUserName" value="${user.name}">
                </div>
                <div class="">
                    <label for="updateEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="updateEmail" aria-describedby="email" value="${user.email}">
                </div>
            </div>     
        `);
    }
    function updateinfo(){
        let userId = $("#getUserId").val();
        let userName = $("#updateUserName").val();
        let email = $("#updateEmail").val();

        $.ajax({
            url :  basePath + '/user/' + userId,
            type : 'PUT',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            data : {
                'userId' : userId,
                'userName' : userName,
                'email' : email
            },
            dataType:'json',
            success : function(data) { 
                if(data == true){
                    window.location.reload();
                }
                else{
                    alert('Can not update the user information.');
                }
            },
            error : function(request,error)
            {
                alert('Url access request can not proceed');
            }
        });
    }

    function deleteUser(userId){
        $("#deleteInfo").remove();
        let deleteBtn = $(".deleteBtn");
        deleteBtn.append(`
            <button class="btn btn-success" id="deleteInfo" onclick="deleteInfo(${userId});">Delete Info</button>
        `);
    }

    function deleteInfo(userId){
        $.ajax({
            url :  basePath + '/user/delete/' + userId,
            type : 'DELETE',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            data : {
                'userId' : userId
            },
            dataType:'json',
            success : function(data) { 
                if(data == true){
                   window.location.reload();
                }
                else{
                    alert('Can not update the user information.');
                }
            },
            error : function(request,error)
            {
                alert('Url access request can not proceed');
            }
        });
    }
</script>