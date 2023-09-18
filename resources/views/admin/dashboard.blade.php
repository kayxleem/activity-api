@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activities</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Activities</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Activities</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Activity title
                        </th>
                        <th style="width: 10%">
                            Activity scope
                        </th>
                        <th>
                            Description
                        </th>
                        <th style="width: 10%">
                            Activity Image
                        </th>
                        {{-- <th style="width: 8%" class="text-center">
                            Status
                        </th> --}}
                        <th style="width: 20%">
                        </th>
                    </tr>
                </thead>
                <tbody>

                @if ($activities->count())
                    @foreach ($activities as $item)
                    <tr>
                        <td>
                            #
                        </td>
                        <td>
                            <a>
                                {{$item->title}}
                            </a>
                            <br/>
                            <small>
                                Created {{$item->activity_date}}
                            </small>
                        </td>
                        <td>

                            @if ($item->scope=='local' && $item->user_activity != null)
                            @foreach ($item->user_activity as $user_activity )
                            {{$user_activity->user->name}}

                            @endforeach

                            @else

                            {{$item->scope}}
                            @endif
                            {{-- <ul class="list-inline">
                                <li class="list-inline-item">
                                    <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar.png">
                                </li>
                                <li class="list-inline-item">
                                    <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar2.png">
                                </li>
                                <li class="list-inline-item">
                                    <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar3.png">
                                </li>
                                <li class="list-inline-item">
                                    <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar4.png">
                                </li>
                            </ul> --}}
                        </td>
                        <td class="project_progress">
                            {{-- <div class="progress progress-sm">
                                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                </div>
                            </div> --}}
                            <small>
                                {{$item->description}}
                            </small>
                        </td>
                        <td class="project_progress">



                                <img alt="image"  src="{{$item->image}}" width="100px">
                        </td>
                        {{-- <td class="project-state">
                            <span class="badge badge-success">Success</span>
                        </td> --}}
                        <td class="project-actions text-right">
                            <a class="btn btn-primary btn-sm" href="{{route('admin.dashboard')}}/{{$item->id}}">
                                <i class="fas fa-folder">
                                </i>
                                View
                            </a>
                            <a class="btn btn-info btn-sm" href="{{route('admin.edit.activity.view',  $item->id)}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Edit
                            </a>

                            <a class="btn btn-danger btn-sm" href="{{route('admin.activity.delete', $item->id)}}" onclick="return confirm('Are you sure you want to delete this Activity?');">
                                <i class="fas fa-trash">
                                </i>
                                Delete
                            </a>
                        </td>
                    </tr>

                    @endforeach
                                @else
                                    <td class="text-red-500">No expense yet.. Add by clicking the button below</td>
                                    @endif
                </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



@endsection
