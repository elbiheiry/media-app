@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="page-content">
            <form action="{{ route('album.store') }}" enctype="multipart/form-data" method="post" class="ajax-form">
                @method('post')
                @csrf
                <div class="widget">
                    <div class="widget-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="custom-btn green-bc">Store</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="widget">
                <div class="widget-content">
                    <div class="row">
                        <div class="col-6">
                            <div class="col">
                                <div class="table-responsive-lg">
                                    <table id="datatable" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Created at</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="panel panel-default">
                                <div class="panel-heading"><b>Chart</b></div>
                                <div class="panel-body">
                                    <canvas id="canvas" height="280" width="600"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        //add delete url to form
        $(document).on('click', '.delete-btn', function() {
            var url = $(this).data('url');

            $('#delete-form').attr('action', url);
            $('#delete').modal('show');
        });
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('album.index') }}",
                dom: 'Bfrtip',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });

        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
    <script>
        var url = "{{ route('album.chart') }}";
        var Albums = new Array();
        var Labels = new Array();
        var count = new Array();
        $(document).ready(function() {
            $.get(url, function(response) {
                response.forEach(function(data) {
                    Albums.push(data.name);
                    Labels.push(data.media_count);
                });
                var ctx = document.getElementById("canvas").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Albums,
                        datasets: [{
                            label: 'Album data',
                            data: Labels,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            });
        });
    </script>
@endpush
