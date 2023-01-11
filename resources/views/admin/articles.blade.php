@extends('layouts.app')
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
@endpush
@section('content')
<div class="container">
    <div class="content-wrapper mt-3 border-white">
        <div class="row">
            <table id="article-table" class="hover stripe" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center"> Article # </th>
                        <th class="text-center"> Thumbnail</th>
                        <th class="text-center"> Title </th>
                        <th class="text-center"> Description </th>
                        <th class="text-center"> Views </th>
                        <th class="text-center"> Created By </th>
                        <th class="text-center"> Created At </th>
                        <th class="text-center"> Edit </th>
                        <th class="text-center"> Delete </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr data-article_id="{{ $article['id'] }}">
                            <td class="text-center"> {{ $article['id'] }} </td>
                            <td class="text-center"><img class="thumbnail" src="{{ asset('storage/articles/'.$article['thumbnail']) }}"></td>
                            <td class="text-center"> {{ $article['title'] }} </td>
                            <td> {{ character_limiter($article['description'], 200) }} </td>
                            <td class="text-center"> {{ $article['views'] }} </td>
                            <td class="text-center"> {{ $article['name'] }} </td>
                            <td class="text-center"> {{ $article['created_at'] }} </td>
                            <td class="text-center"> <a href="{{ route('admin/edit-article-view', $article['id']) }}" class="icon-action"><i class="ti-pencil-alt"></i></a> </td>
                            <td class="text-center">
                                <a href="#" class="delete-btn icon-action"><i class="ti-trash"></i></a>
                                <div class="dot-opacity-loader" style="display: none;">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

        var article_table = $("#article-table").DataTable({
            dom: 'rf<"create-btn create-article-btn">tip',
            pageLength: 10,
            sPaginationType: "numbers",
            columnDefs: [
                { "width": "200px", "targets": 1 },
                { "width": "600px", "targets": 3 },
                { orderable: false, targets: [1, 7, 8] }
            ],
            order: [[0, 'asc']],
            scrollX: true
        });

        $("div.create-article-btn").html(
			'<a href="{{ route('admin/create-article-view') }}" class="btn btn-gradient-primary btn-lg"> Create a new article</a>'
		);

        $(".delete-btn").click(function(e) {
            e.preventDefault();
            var delete_btn = $(this);
            $(delete_btn).hide();
            $(delete_btn).next().show();
            var article_id = $(this).parent().parent().data("article_id");

            $.ajax({
                type:'POST',
                url:"{{ route('admin/delete-article') }}",
                data:{
                    article_id: article_id
                },
                success:function(response){
                    $(delete_btn).show();
                    $(delete_btn).next().hide();

                    location.reload();
                }
            });
        });
    </script>
@endpush
