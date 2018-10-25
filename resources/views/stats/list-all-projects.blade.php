<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 24.10.18
 * Time: 16:23
 */
?>
@extends('layout.main')

@section('content')
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Hover Data Table</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="project-stats" class="table table-bordered table-hover">
            <thead>
            <tr>
              <th>Id</th>
              <th>Project Key</th>
              <th>Project Name</th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>

              @if (count($projects) > 1)
                @foreach ($projects as $project)
                    <tr>
                      <td>{{ $project->id }}</td>
                      <td>{{ $project->projectId }}</td>
                      <td>{{ $project->name }}</td>
                      <td>
                        <a href="{{ action('StatsController@showProjectStats', ['projectId' => $project->id]) }}">Show stats</a>
                      </td>
                    </tr>
                @endforeach
              @else
                  <tr>
                      <td><h3>No projects available yet!</h3></td>
                  </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@push('scripts')
    <script>
      $(function () {
        $('#project-stats').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          "pageLength"  : 50,
          'columnDefs'  : [
            {"orderable": false, "targets": [ 3 ]}
          ]
        })
      });
    </script>
@endpush
@stop


