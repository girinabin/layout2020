@extends('admin.layouts.dashboard')

@section('content')

<h1>Update the Post</h1>

{{-- @canany(['isAdmin', 'isContentEditor']) --}}
<div class="publish-checkbox" style="float:right">
    <label for="publish-post">Publish Post</label>
    <input type="checkbox" data-status="{{ $post['id'] }}"
     id="publish-post" {{$post->published ? 'checked=checked' : '' }}>
</div>
{{-- @endcanany --}}
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li> 
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('posts.update',$post['id']) }}" enctype="multipart/form-data">
    @method('PATCH')
    @csrf()
    
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" placeholder="Title..." value="{{ $post->title }}">
    </div>
    <label for="image">Select Image</label>
    <input type="file" name="image" class="form-control-file" id="profile-img" value="{{$post->image}}">
    <div class="row">
        <img src="{{ asset('uploads/posts/'.$post->image_url) }}" id="profile-img-tag" class="img-thumbnail mx-auto" alt="{{$post->image_url}}" width="250" >
    </div>
    <div class="form-group">
        <label for="content">Insert Content</label>
        <textarea name="post_content" id="content">{{ $post->content }}</textarea>
    </div>

    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
</form>

@section('js_post_page')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>


    <script>
        
        CKEDITOR.replace( 'post_content' );

        $(function() {

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('#profile-img-tag').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            
            $("#profile-img").change(function(){
                readURL(this);
            });

        });

        $(document).ready(function(){    
            $('#publish-post').on('click', function(event) {
                var status = $("#publish-post").attr("data-status");

                if ($("#publish-post").is(":checked")){
                    var checked = 1;
                }else{
                    var checked = 0;
                }
                axios.post('http://role2020.test/posts/status',{postid:status,checked:checked})
                
               
            });
            
        });


    </script>
    
@endsection

@endsection