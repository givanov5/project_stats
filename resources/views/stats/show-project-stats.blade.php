@extends('layout.main')
<!-- /.box-body -->
@section('content')
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-responsive">
                    <div class="chart">
                        <canvas id="projectChart" style="height:250px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle text-red"></i>Tasks To Do</li>
                    <li><i class="fa fa-circle text-green"></i>Tasks Done</li>
                </ul>
            </div>
            <!-- /.col -->
        </div>

    </div>
    @push('scripts')
        <script>
        $(document).ready(function(){

            // Get context with jQuery - using jQuery's .get() method.
            var projectChartCanvas = $('#projectChart').get(0).getContext('2d');
            // This will get the first returned node in the jQuery collection.
            var projectChart = new Chart(projectChartCanvas);

            var projectChartData = {
              labels  : {!! json_encode($dates) !!},
              datasets: [
                {
                  label               : 'Tasks To Do',
                  fillColor           : '#f56954',
                  strokeColor         : '#f56954',
                  pointColor          : '#f56954',
                  pointStrokeColor    : '#f56954',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: 'rgba(220,220,220,1)',
                  data                : {{json_encode($tasksToDo)}}
                },
                {
                  label               : 'Tasks Done',
                  fillColor           : '#00a65a',
                  strokeColor         : '#00a65a',
                  pointColor          : '#00a65a',
                  pointStrokeColor    : '#00a65a',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: 'rgba(60,141,188,1)',
                  data                : {{json_encode($tasksDone)}}
                }
              ]
            }

            var projectChartOptions = {
              //Boolean - If we should show the scale at all
              showScale               : true,
              //Boolean - Whether grid lines are shown across the chart
              scaleShowGridLines      : false,
              //String - Colour of the grid lines
              scaleGridLineColor      : 'rgba(0,0,0,.05)',
              //Number - Width of the grid lines
              scaleGridLineWidth      : 1,
              //Boolean - Whether to show horizontal lines (except X axis)
              scaleShowHorizontalLines: true,
              //Boolean - Whether to show vertical lines (except Y axis)
              scaleShowVerticalLines  : true,
              //Boolean - Whether the line is curved between points
              bezierCurve             : true,
              //Number - Tension of the bezier curve between points
              bezierCurveTension      : 0.3,
              //Boolean - Whether to show a dot for each point
              pointDot                : false,
              //Number - Radius of each point dot in pixels
              pointDotRadius          : 4,
              //Number - Pixel width of point dot stroke
              pointDotStrokeWidth     : 1,
              //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
              pointHitDetectionRadius : 20,
              //Boolean - Whether to show a stroke for datasets
              datasetStroke           : true,
              //Number - Pixel width of dataset stroke
              datasetStrokeWidth      : 2,
              //Boolean - Whether to fill the dataset with a color
              datasetFill             : true,
              legend : {
                display: true,
                position: 'bottom',
                labels: {
                  fontColor: 'rgb(255, 99, 132)'
                }
              },
              //String - A legend template
              legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
              //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
              maintainAspectRatio     : true,
              //Boolean - whether to make the chart responsive to window resizing
              responsive              : true
            }

            //Create the line chart
            projectChart.Line(projectChartData, projectChartOptions)

            //--------------
            //- LINE CHART -
            //--------------
            var lineChart                = new Chart(projectChartCanvas)
            var lineChartOptions         = projectChartOptions
            lineChartOptions.datasetFill = false
            lineChart.Line(projectChartData, lineChartOptions)
        })

        </script>
    @endpush
@stop
