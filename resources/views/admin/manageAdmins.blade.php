@extends('layouts.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
@endpush
@section('content')
<div class="container">
    <div class="content-wrapper mt-3 border-white">
        <div class="row">
            <table id="admin-table" class="hover stripe nowrap" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center"> # </th>
                        <th class="text-center"> Name</th>
                        <th class="text-center"> Email </th>
                        <th class="text-center"> Status </th>
                        <th class="text-center"> Member Since </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td class="text-center"> {{ $admin['id'] }} </td>
                            <td class="text-center"> {{ $admin['name'] }} </td>
                            <td class="text-center"> {{ $admin['email'] }} </td>
                            <td class="text-center">
                                @if ($admin['status'] == 1)
                                    <label class="badge badge-outline-success"> Active </label>
                                @elseif ($admin['status'] == 2)
                                    <label class="badge badge-outline-warning"> Inviated at {{ $admin['invited_at'] }} </label>
                                @endif
                            </td>
                            <td class="text-center"> {{ $admin['created_at'] }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="createAdminModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="text-center">Create a new administrator</h4>
                    <form class="pt-3">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email" class="form-control form-control-lg " name="email" value="" placeholder="Email Address" required="" autocomplete="email" autofocus="">
                        </div>
                        <div class="modal-button-group">
                            <button id="create-admin-btn" type="button" class="btn btn-gradient-success"> Create </button>
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

        var admin_table = $("#admin-table").DataTable({
            dom: 'rf<"create-btn create-admin-btn">tip',
            pageLength: 10,
            sPaginationType: "numbers",
            columnDefs: [
                { orderable: false, targets: [1] }
            ],
            order: [[0, 'asc']],
            scrollX: true
        });

        $("div.create-admin-btn").html(
			'<button class="btn btn-gradient-primary btn-lg" data-bs-toggle="modal" data-bs-target="#createAdminModal"> Create a new admin </button>'
		);

        $("#create-admin-btn").click(function(e) {

            e.preventDefault();
            $(".modal-button-group button").hide();
            $(".dot-opacity-loader").show();

            $.ajax({
                type:'POST',
                url:"{{ route('admin/create-admin') }}",
                data:{
                    email: $("#email").val()
                },
                success:function(response){
                    $(".modal-button-group button").show();
                    $(".dot-opacity-loader").hide();
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
    </script>
@endpush
