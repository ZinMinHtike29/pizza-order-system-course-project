@extends('admin.layout.master')

@section('title', 'Pizza List')

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
                                <h2 class="title-1">Pizza List</h2>
                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('product#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add pizza
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class=" col-4">
                            <h3 class=" text-secondary d-flex">Search Key : <span class=" text-danger">
                                    {{ request('key') }}</span>
                            </h3>
                        </div>
                        <div class=" col-4 offset-4">
                            <form action="{{ route('product#list') }}" class=" d-flex" method="get">
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
                            <h3> <i class="fa-solid fa-database me-2"></i> {{ $pizzas->total() }} </h3>
                        </div>
                    </div>

                    @if (session('deleteSuccess'))
                        <div class=" d-flex justify-content-end mt-3">
                            <div class="alert alert-danger alert-dismissible fade show col-4" role="alert">
                                <strong><i class="fa-solid fa-check"></i> {{ session('deleteSuccess') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if ($pizzas->count() != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Pizza Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>View Count</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($pizzas as $pizza)
                                        <tr class="tr-shadow">
                                            <td class=" col-2"><img src="{{ asset('storage/' . $pizza->image) }}"
                                                    class=" img-thumbnail shadow-sm" alt=""></td>
                                            <td class=" col-3">{{ $pizza->name }}</td>
                                            <td class=" col-2">{{ $pizza->price }}</td>
                                            <td class=" col-2">{{ $pizza->category_name }}</td>
                                            <td class=" col-2"><i class="fa-solid fa-eye me-1"></i>{{ $pizza->view_count }}
                                            </td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="{{ route('product#edit', $pizza->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="View">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#updatePage', $pizza->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#delete', $pizza->id) }}">
                                                        <button class="item me-1" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $pizzas->links() }}
                            </div>
                        </div>
                    @else
                        <h3 class=" text-secondary text-center mt-3">There Is No Pizza Here!</h3>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
