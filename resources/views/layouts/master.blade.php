<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add new album</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('file/file.css') }}">
    <link href="{{ asset('all.css') }}" rel="stylesheet">
</head>

<body>
    <div class="modal fade " id="delete">
        <div class="modal-dialog">
            <form class="modal-content" id="delete-form" method="post">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure ?</h4>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" class="btn btn-danger ">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </div>
            </form><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @yield('content')
    <!-- JavaScript Bundle with Popper -->
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <script src="{{ asset('popper/popper.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script src="{{ asset('file/file.js') }}"></script>
    <script src="{{ asset('bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('all.js') }}"></script>
    @stack('js')
</body>

</html>
