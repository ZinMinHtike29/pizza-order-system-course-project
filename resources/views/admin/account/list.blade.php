@extends('admin.layout.master')

@section('title', 'admin List')

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
                                <h2 class="title-1">Admin List</h2>
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
                            <form action="{{ route('admin#list') }}" class=" d-flex" method="get">
                                <input type="text" class=" form-control" name="key" id=""
                                    placeholder="Search Category." value="{{ request('key') }}">
                                <button type="submit" class=" btn btn-dark">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @if (session('deleteSuccess'))
                        <div class=" d-flex justify-content-end">
                            <div class="alert alert-danger alert-dismissible fade show col-4" role="alert">
                                <strong><i class="fa-solid fa-xmark"></i> {{ session('deleteSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <div class="row mt-3 ">
                        <div class="col-1 offset-10 bg-white shadow-sm p-2 text-center">
                            <h3> <i class="fa-solid fa-database me-2"></i> {{ $admin->total() }} </h3>
                        </div>
                    </div>

                    {{-- @if ($admin->count() != 0) --}}
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $a)
                                    <tr class="tr-shadow">
                                        <input type="hidden" name="" value="{{ $a->id }}" class=" userId">
                                        <td class=" col-2">
                                            <div class="image">
                                                @if ($a->image == null)
                                                    @if ($a->gender != 'female')
                                                        <img class=" img-thumbnail shadow-sm"
                                                            src="{{ asset('image/Default-welcomer.png') }}"
                                                            alt="John Doe" />
                                                    @else
                                                        <img class=" img-thumbnail shadow-sm"
                                                            src="{{ asset('image/Profile-Female-PNG-Image.png') }}"
                                                            alt="John Doe" />
                                                    @endif
                                                @else
                                                    <img src="{{ asset('storage/' . $a->image) }}"
                                                        class=" img-thumbnail shadow-sm" alt="John Doe" />
                                                @endif
                                            </div>
                                        </td>
                                        <td class="">
                                            <span class="block-email">{{ $a->name }}</span>
                                        </td>
                                        <td class="">
                                            <span class="block-email">{{ $a->email }}</span>
                                        </td>
                                        <td class="">
                                            <span class="block-email">{{ $a->gender }}</span>
                                        </td>
                                        <td class="">
                                            <span class="block-email">{{ $a->phone }}</span>
                                        </td>
                                        <td class="">
                                            <span class="block-email">{{ $a->address }}</span>
                                        </td>
                                        <td>
                                            <div class="table-data-feature align-items-center">
                                                @if (Auth::user()->id != $a->id)
                                                    {{-- <a href="{{ route('admin#changeRole', $a->id) }}" class=" me-1">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Change Admin Role">
                                                            <i class="fa-solid fa-person-circle-minus"></i>
                                                        </button>
                                                    </a> --}}
                                                    <select name="" id=""
                                                        class=" ajaxChangeRole form-select me-2">
                                                        <option value="admin">
                                                            Admin</option>
                                                        <option value="user">User</option>
                                                    </select>
                                                    <a href="{{ route('admin#delete', $a->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class=" mt-3">
                            {{ $admin->links() }}
                        </div>
                    </div>
                    {{-- @else
                        <h2 class=" text-secondary text-center mt-5">There is no Admin Here!</h2>
                    @endif --}}
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function() {
            $(".ajaxChangeRole").change(function() {
                $parentNode = $(this).parents("tr");
                $role = $(this).val();
                $userId = $parentNode.find(".userId").val();
                $.ajax({
                    type: "get",
                    url: "http://127.0.0.1:8000/admin/ajax/change/role",
                    data: {
                        role: $role,
                        userId: $userId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == "success") {
                            location.reload();
                        }
                    }
                });
            })
        });
    </script>
@endsection
