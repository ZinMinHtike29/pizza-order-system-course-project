@extends('admin.layout.master')

@section('title', 'User List')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">User List</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class=" col-4">
                            <h3 class=" text-secondary d-flex">Search Key : <span class=" text-danger">
                                    {{ request('key') }}</span>
                            </h3>
                        </div>
                        <div class=" col-4 offset-4">
                            <form action="{{ route('admin#userList') }}" class=" d-flex" method="get">
                                <input type="text" class=" form-control" name="key" id=""
                                    placeholder="Search Category." value="{{ request('key') }}">
                                <button type="submit" class=" btn btn-dark">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-3 ">
                        <div class="col-1 offset-10 bg-white shadow-sm p-2 text-center">
                            <h3> <i class="fa-solid fa-database me-2"></i>{{ $users->total() }} </h3>
                        </div>
                    </div>


                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class=" tr-shadow">
                                        <input type="hidden" class="userId" value="{{ $user->id }}">
                                        <td class=" col-2">
                                            @if ($user->image == null)
                                                @if ($user->gender != 'female')
                                                    <img class=" img-thumbnail "
                                                        src="{{ asset('image/Default-welcomer.png') }}" alt="John Doe" />
                                                @else
                                                    <img class=" img-thumbnail "
                                                        src="{{ asset('image/Profile-Female-PNG-Image.png') }}"
                                                        alt="John Doe" />
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $user->image) }}" class=" img-thumbnail "
                                                    alt="John Doe" />
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            <select name="" id="" class="statusChange form-select">
                                                <option value="user" @if ($user->role == 'user') selected @endif>
                                                    User</option>
                                                <option value="admin" @if ($user->role == 'admin') selected @endif>
                                                    Admin</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class=" btn btn-danger btn-sm deleteUser">Delete
                                                User</button>
                                        </td>
                                    </tr>
                                    <tr class="spacer"> </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class=" mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('.deleteUser').click(function() {
                $parentNode = $(this).parents("tr");
                $userId = $parentNode.find(".userId").val();
                $.ajax({
                    type: "get",
                    url: "http://127.0.0.1:8000/user/ajax/delete/user",
                    data: {
                        "userId": $userId,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                            location.reload();
                        }
                    }
                });
            })
            $(".statusChange").change(function() {
                $role = $(this).val();
                $parentNode = $(this).parents("tr");
                $userId = $parentNode.find(".userId").val();

                $.ajax({
                    type: "get",
                    url: "http://127.0.0.1:8000/user/ajax/change/role",
                    data: {
                        role: $role,
                        userId: $userId
                    },
                    dataType: "json",
                });
                location.reload();
            })
        });
    </script>
@endsection
