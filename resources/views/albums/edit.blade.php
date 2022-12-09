@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="page-content">
            <form action="{{ route('album.update', ['album' => $album->id]) }}" enctype="multipart/form-data" method="put"
                class="ajax-form">
                @method('put')
                @csrf
                <div class="widget">
                    <div class="widget-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $album->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="custom-btn green-bc" type="submit">
                                Store
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="{{ route('media.store', ['id' => $album->id]) }}" enctype="multipart/form-data" method="post"
                class="ajax-form">
                @method('post')
                @csrf
                <div class="widget">
                    <div class="widget-title">Add new media</div>
                    <div class="widget-content">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Image </label>
                                    <input type="file" class="jfilestyle" name="image" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button class="custom-btn green-bc" type="submit">
                                Store
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="widget">
                <div class="widget-title">Album images</div>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="col">
                                <div class="table-responsive-lg">
                                    <table id="datatable" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Created at</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                    </table>
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('album.edit', ['album' => $album->id]) }}",
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
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            return "<img src=\"" + data + "\" width=\"50\"/>";
                        }
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
@endpush
