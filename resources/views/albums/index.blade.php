<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add new album</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="{{ asset('all.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="widget">
            <div class="widget-content">
                <div class="row">
                    <div class="col-12">

                        <form action="{{ route('album.store') }}" enctype="multipart/form-data" method="post"
                            class="ajax-form">
                            @csrf
                            <div class="mb-3 col-6">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            {{-- <div class="d-grid"> --}}
                            <button class="btn btn-primary">Store</button>
                            {{-- </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="widget">
            <div class="widget-content">
                <div class="row">
                    <div class="col-12">
                        <div class="col">
                            <div class="table-responsive-lg">
                                <table class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($albums['data'] as $key => $album)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $album['name'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript Bundle with Popper -->
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <script src="{{ asset('popper/popper.min.js') }}">
        {{-- integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"> --}}
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="{{ asset('bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('all.js') }}"></script>
</body>

</html>
