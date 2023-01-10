@extends('layouts.app')
@section('content')
<div class="container">
    <div class="content-wrapper mt-3 border-white">
        <form method="POST" action="{{ route('admin/create-article') }}" enctype="multipart/form-data" id="article-form">
            @csrf
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{Session::get('success')}}
                </div>
            @elseif(Session::has('error'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{Session::get('error')}}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <h3 class="text-center"> Preview Article </h3>
                    <img id="article-thumbnail-preview">
                    <h2 id="article-title-preview" class="text-center"> {{ old('article-title') }} </h2>
                    <div id="article-content-preview"> {{ old('article') }} </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="upload-article-thumbnail-btn" class="btn btn-gradient-primary btn-lg"> Choose Thumbnail </label>
                        <input type="file" id="upload-article-thumbnail-btn" class="@error('article-thumbnail') is-invalid @enderror" name="article-thumbnail" accept="image/*" hidden/>
                        @error('article-thumbnail')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input id="article-title" type="text" class="form-control form-control-lg @error('article-title') is-invalid @enderror" name="article-title" value="{{ old('article-title') }}" placeholder="Article Title">
                        @error('article-title')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <textarea id="article-editor" name="article" class="@error('article') is-invalid @enderror"> {{ old('article') }} </textarea>
                        @error('article')
                            <span class="invalid-feedback" role="alert">
                                <strong> {{ $message }} </strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" id="article-submit" class="btn btn-block btn-gradient-primary btn-lg"> Create Article </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script type="text/javascript">
        var articleEditor;
        ClassicEditor
            .create(document.querySelector("#article-editor"), {
                fontSize: {
                    options: [
                        9, 11, 13, 14, 15, 16, 'default', 17, 18, 19, 21
                    ],
                    supportAllValues: true
                },
                toolbar: {
                    items: [
                        'heading', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'highlight', '|',
                        'alignment', 'outdent', 'indent', '|',
                        'todoList', 'numberedList', 'bulletedList', '|',
                        'horizontalLine', 'link', 'imageUpload', 'mediaEmbed', 'blockQuote', 'insertTable', '|',
                        'code', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'subscript', 'superscript', '|',
                        'removeFormat', '|',
                        'undo', 'redo'
                    ],
                    shouldNotGroupWhenFull: true
                },
                language: 'en',
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableCellProperties',
                        'tableProperties'
                    ]
                },
                indentBlock: {
                    offset: 1,
                    unit: 'em'
                },
                licenseKey: ''
            }).then(newEditor => {
                //do something with the editor
                articleEditor = newEditor;
                articleEditor.model.document.on('change:data', () => {
                    setTimeout(function() {
                        $("#article-content-preview").html(articleEditor.getData());
                    }, 10);
                });
            })
            .catch(error => {
                console.error(error);
            });

        $(document).ready(() => {
            $("#upload-article-thumbnail-btn").change(function() {
                $("#upload-article-thumbnail-btn").removeClass("is-invalid");
                $("#upload-article-thumbnail-btn").next().remove("span");
                const file = this.files[0];
                if (file) {
                    const fileType = file["type"];
                    const validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/webp', 'image/bmp'];
                    if (validImageTypes.includes(fileType)) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("#article-thumbnail-preview").attr("src", e.target.result);
                            $("#article-thumbnail-preview").css("margin-top", "1.5rem");
                        }
                        reader.readAsDataURL(file);
                    } else {
                        $("#article-thumbnail-preview").attr("src", "");
                        $("#article-thumbnail-preview").css("margin-top", "0");
                        $("#upload-article-thumbnail-btn").addClass("is-invalid");
                        $("#upload-article-thumbnail-btn").after('<span class="invalid-feedback" role="alert"><strong> Accepted thumbnail formats include gif, jpg, jpeg, webp, bmp and png. </strong></span>');
                    }
                } else {
                    $("#article-thumbnail-preview").attr("src", "");
                    $("#article-thumbnail-preview").css("margin-top", "0");
                    $("#upload-article-thumbnail-btn").addClass("is-invalid");
                    $("#upload-article-thumbnail-btn").after('<span class="invalid-feedback" role="alert"><strong> Please choose a thumbnail. </strong></span>');
                }
            });

            $("#article-title").bind("keyup", function() {
                $("#article-title").removeClass("is-invalid");
                $("#article-title").next().remove("span");
                $("#article-title-preview").html($(this).val());
            });

            $("#article-editor").change(function() {
                $("#article-editor").removeClass("is-invalid");
                $(".ck.ck-reset.ck-editor.ck-rounded-corners").next().remove("span");
            });

            $("#article-submit").bind("click", function(e) {
                e.preventDefault();
                var has_error = false;
                //form validation
                $(".invalid-feedback").remove();
                try {
                    const file = $("#upload-article-thumbnail-btn")[0].files[0];
                    if (file) {
                        const fileType = file["type"];
                        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/webp', 'image/bmp'];
                        if (!validImageTypes.includes(fileType)) {
                            $("#upload-article-thumbnail-btn").addClass("is-invalid");
                            $("#upload-article-thumbnail-btn").after('<span class="invalid-feedback" role="alert"><strong> Accepted thumbnail formats include gif, jpg, jpeg, webp, bmp and png. </strong></span>');
                            has_error = true;
                        }
                    } else {
                        $("#upload-article-thumbnail-btn").addClass("is-invalid");
                        $("#upload-article-thumbnail-btn").after('<span class="invalid-feedback" role="alert"><strong> Please choose a thumbnail. </strong></span>');
                        has_error = true;
                    }
                } catch(err) {
                    $("#upload-article-thumbnail-btn").addClass("is-invalid");
                    $("#upload-article-thumbnail-btn").after('<span class="invalid-feedback" role="alert"><strong> Please choose a thumbnail. </strong></span>');
                    has_error = true;
                }

                if($("#article-title").val() == "") {
                    $("#article-title").addClass("is-invalid");
                    $("#article-title").after('<span class="invalid-feedback" role="alert"><strong> The article-title field is required. </strong></span>');
                    has_error = true;
                }
                if(articleEditor.getData() == "") {
                    $("#article-editor").addClass("is-invalid");
                    $(".ck.ck-reset.ck-editor.ck-rounded-corners").after('<span class="invalid-feedback" role="alert"><strong> The article field is required. </strong></span>');
                    has_error = true;
                }
                if(!has_error) {
                    $("#article-form").submit();
                }
            });
        });
    </script>
@endpush
