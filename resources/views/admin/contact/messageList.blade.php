@extends('admin.layout.master')

@section('title', 'Customer Message')

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
                                <h5 class="title-1">Customer Message List</h5>
                            </div>
                        </div>
                    </div>
                    @if (session('replySuccess'))
                        <div class="row">
                            <div id="success">
                                <div class="alert alert-success alert-dismissible fade show col-4 offset-8" role="alert">
                                    <strong><i class="fa-solid fa-face-smile-beam"></i></strong>
                                    {{ session('replySuccess') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class=" row my-3">
                        <form action="{{ route('admin#filterMessage') }}" method="get" class=" d-flex col-8">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <h3 class=" input-group-text bg-white text-dark">
                                        <i class="fa-solid fa-database me-2"></i> {{ $messages->total() }}
                                    </h3>
                                </div>
                                <select name="replyStatus" class=" custom-select form-select col-5 me-1"
                                    id="inputGroupSelect02">
                                    <option value="">All</option>
                                    <option value="0" @if (request('replyStatus') == '0') selected @endif>Unreply Message
                                    </option>
                                </select>
                                <div class="input-group-append">
                                    <button type="submit" class=" btn bg-dark text-white input-group-text">
                                        <i class="fa-solid fa-magnifying-glass me-2"></i>
                                        Search
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    @if ($messages->count() != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="dataList">
                                    @foreach ($messages as $m)
                                        <tr class=" tr-shadow">
                                            <td class=" align-middle col-2">{{ $m->user_name }}</td>
                                            <td>{{ $m->user_email }}</td>
                                            <td>{{ $m->subject }}</td>
                                            <td>{{ Str::words($m->message, 7, '....') }}</td>
                                            <td class=" col-3">
                                                <a href="{{ route('admin#messageDetails', $m->id) }}" class=" mt-1 me-1">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="View Message">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </a>
                                                @if ($m->reply_status == 1)
                                                    <small class="text-bold text-primary">Already Reply Message!</small>
                                                @else
                                                    <a href="{{ route('admin#replyMessagePage', $m->id) }}"
                                                        class=" btn btn-sm btn-outline-success">Reply
                                                        Message</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">

                                {{ $messages->links() }}

                            </div>
                        </div>
                    @else
                        <h3 class=" text-secondary text-center mt-3">There Is No Message Here!</h3>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
