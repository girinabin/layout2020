@extends('admin.layouts.dashboard')

@section('content')

<h1>Create New  User</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    
    <div class="form-group">
        <label for="name">User name</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Name..." value="{{ old('name') }}" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Email..." value="{{ old('email') }}">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password..." required minlength="8">
    </div>
    <div class="form-group">
        <label for="password_confirmation">Password Confirm</label>
        <input type="password" name="password_confirmation" class="form-control" placeholder="Password..." id="password_confirmation">
    </div>
    <div class="form-group">
        <label for="role">Select Role</label>

        <select class="role form-control" name="role" id="role">
            <option value="">Select Role...</option>
            @foreach($roles as $role)
            <option data-role-id="{{ $role->id }}" data-role-slug="{{ $role->slug }}" value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
            
        </select>
    </div>
    
    <div id="permissions_box" >
        <label for="roles">Select Permissions</label>
        <div id="permissions_ckeckbox_list">
        </div>
    </div> 
    
   

    <div class="form-group pt-2">
        <input class="btn btn-primary" type="submit" value="Submit">
    </div>
</form>    

@section('js_user_page')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script>
        
        $(document).ready(function(){
            var permissions_box = $('#permissions_box');
            var permissions_ckeckbox_list = $('#permissions_ckeckbox_list');
            permissions_box.hide(); // hide all boxes

            $('#role').on('change',function(){
                var role = $(this).find(':selected');
                var role_id = role.data('role-id');
                var role_slug = role.data('role-slug');
                permissions_ckeckbox_list.empty()
                axios.post('http://role2020.test/user/permission',{roleid:role_id,roleslug:role_slug})
                .then(res=>{
                    permissions_box.show();
                    
                    res.data.forEach(permission =>{
                        $('#permissions_ckeckbox_list').append(       
                            `<div class="custom-control custom-checkbox">
                                <input type="checkbox" name="permissions[]" id="${permission.slug}" value="${permission.id}" >
                                <label for="${permission.slug}" >${permission.name}</label>
                                </div>`
                        );

                    });
                })
                .catch(err=>console.error(err))
            });
            



           
        });

    </script>

@endsection


@endsection