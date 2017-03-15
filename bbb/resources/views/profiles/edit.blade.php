@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            	@if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                  </div>
               @endif

               @if(Session::has('success'))
                  <div class="aler alert-success">
                  	{{ Session::get('success') }}
                  </div>
               @endif
            <div class="panel panel-success">
                <div class="panel-heading ">Update Info</div>

                <div class="panel-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    	{{ csrf_field() }}
                    	<div class="form-group">
                    		<label for="location">Avatar</label>
                    		<input type="file" name="avatar" class="form-control" accept="image/*">
                    	</div>
                    	<div class="form-group">
                    		<label for="location">Location</label>
                    		<input type="text" name="location" class="form-control" value="{{ $info->location }}">
                    	</div>
                    	<div class="form-group">
                    		<label for="about">About</label>
                    		<textarea name="about" id="about" cols="77" rows="20">{{ $info->about }}</textarea>
                    	</div>
                    	<div class="form-group">
                    		<button class="btn btn-primary" type="submit">Update</button>
                    		<button class="btn btn-default" type="reset">Reset</button>
                    	</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
