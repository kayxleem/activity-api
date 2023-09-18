@extends('admin.layout.layout')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Activity</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Activity</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Activity</h3>
              </div>
              <!-- /.card-header -->
              @if ($errors->any())

                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>

                        @endforeach
                    </div>
                @endif

                @if ($status)

                    <div class="alert alert-success">

                            {{ $status }}
                    </div>
                @endif

                @if(Session::has('error'))

                <div class="col-md-12">
                    <div class="card bg-danger">
                      {{-- <div class="card-header">
                        <h3 class="card-title">Error</h3>
                      </div> --}}
                      <div class="card-body">
                        {{Session::get('error')}}

                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                @endif

                @if(Session::has('status'))

                <div class="col-md-12">
                    <div class="card bg-success">
                      {{-- <div class="card-header">
                        <h3 class="card-title">Error</h3>
                      </div> --}}
                      <div class="card-body">
                        {{Session::get('status')}}

                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                @endif
              <!-- form start -->
              <form method="post" action="{{ route('admin.activity.edit',$activity->id ) }}" enctype="multipart/form-data">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title" value="{{$activity->title}}" required>
                  </div>
                  <!-- textarea -->
                  <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" placeholder="{{$activity->description}}" name="description"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Date: {{$activity->activity_date}}</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="activity_date" value="{{$activity->activity_date}}"/>
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker" aria-placeholder="{{$activity->activity_date}}">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">image</label>

                    <div class="input-group">
                        <img alt="image"  src="{{$activity->image}}" width="100px">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                        <label class="custom-file-label" for="exampleInputimage" >Change</label>
                      </div>
                      {{-- <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div> --}}
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->



            <!-- /.card -->
            <!-- Horizontal Form -->

          </div>

          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>



@endsection
