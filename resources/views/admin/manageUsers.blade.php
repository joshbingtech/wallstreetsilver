@extends('layouts.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
@endpush
@section('content')
<div class="container">
    <div class="content-wrapper mt-3 border-white">
        <div class="row">
            <table id="user-table" class="hover stripe nowrap" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center"> # </th>
                        <th class="text-center"> Name</th>
                        <th class="text-center"> Email </th>
                        <th class="text-center"> Status </th>
                        <th class="text-center"> Member Since </th>
                        <th class="text-center"> Lock/Unlock </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr data-user_id="{{ $user['id'] }}">
                            <td class="text-center"> {{ $user['id'] }} </td>
                            <td class="text-center"> {{ $user['name'] }} </td>
                            <td class="text-center"> {{ $user['email'] }} </td>
                            @if($user['deleted_at'])
                                <td class="text-center">
                                    <label class="badge badge-outline-danger"> Locked at {{ $user['deleted_at'] }} </label>
                                </td>
                                <td class="text-center"> {{ $user['created_at'] }} </td>
                                <td class="text-center">
                                    <a href="#" class="unlock-btn icon-action"><i class="ti-unlock"></i></a>
                                    <div class="dot-opacity-loader" style="display: none;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </td>
                            @else
                                @if ($user['status'] == 1)
                                    <td class="text-center">
                                        <label class="badge badge-outline-success"> Active </label>
                                    </td>
                                @else
                                    <td class="text-center">
                                        <label class="badge badge-outline-warning"> Inviated at {{ $user['invited_at'] }} </label>
                                    </td>
                                @endif
                                <td class="text-center"> {{ $user['created_at'] }} </td>
                                <td class="text-center">
                                    <a href="#" class="lock-btn icon-action"><i class="ti-lock"></i></a>
                                    <div class="dot-opacity-loader" style="display: none;">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="createUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="text-center">Create a new user</h4>
                    <form class="pt-3">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email" class="form-control form-control-lg " name="email" value="" placeholder="Email Address" required="" autocomplete="email" autofocus="">
                        </div>
                        <div class="modal-button-group">
                            <button id="create-user-btn" type="button" class="btn btn-gradient-success"> Create </button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal"> Close </button>
                            <div class="dot-opacity-loader" style="display: none;">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var user_table = $("#user-table").DataTable({
            dom: 'rf<"create-btn create-user-btn">tip',
            pageLength: 10,
            sPaginationType: "numbers",
            columnDefs: [
                { orderable: false, targets: [1] }
            ],
            order: [[0, 'asc']],
            scrollX: true
        });

        $("div.create-user-btn").html(
			'<button class="btn btn-gradient-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createUserModal"> Create a new user </button>'
		);

        $("#create-user-btn").click(function(e) {
            e.preventDefault();

            $(".modal-button-group button").hide();
            $(".modal-button-group .dot-opacity-loader").show();

            $.ajax({
                type:'POST',
                url:"{{ route('admin/create-user') }}",
                data:{
                    email: $("#email").val()
                },
                success:function(response){
                    $(".modal-button-group button").show();
                    $(".modal-button-group .dot-opacity-loader").hide();
                    $(".invalid-feedback").remove();

                    if($.isEmptyObject(response.error)) {
                        location.reload();
                    } else {
                        $("#email").addClass("is-invalid");
                        var errors = response.error;
                        $.each(errors, function(key, error) {
                            $("#email").after('<span class="invalid-feedback" role="alert"><strong>' + error + '</strong></span>');
                        });
                    }
                }
            });
        });

        $("#email").bind("keyup", function() {
            $("#email").removeClass("is-invalid");
            $("#email").next().remove("span");
        });

        $(".lock-btn").click(function(e) {
            e.preventDefault();
            var lock_btn = $(this);
            $(lock_btn).hide();
            $(lock_btn).next().show();
            var user_id = $(this).parent().parent().data("user_id");

            $.ajax({
                type:'POST',
                url:"{{ route('admin/lock-user') }}",
                data:{
                    user_id: user_id
                },
                success:function(response){
                    $(lock_btn).show();
                    $(lock_btn).next().hide();

                    location.reload();
                }
            });
        });

        $(".unlock-btn").click(function(e) {
            e.preventDefault();
            var unlock_btn = $(this);
            $(unlock_btn).hide();
            $(unlock_btn).next().show();
            var user_id = $(this).parent().parent().data("user_id");

            $.ajax({
                type:'POST',
                url:"{{ route('admin/unlock-user') }}",
                data:{
                    user_id: user_id
                },
                success:function(response){
                    $(unlock_btn).show();
                    $(unlock_btn).next().hide();

                    location.reload();
                }
            });
        });
    </script>
@endpush
