<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html>

<head>
    @include('admin.layouts._header')
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div id="sidebar-wrapper" style="position: fixed;">
            <div class="border-bottom sidebar-heading">
                <strong class="text-white">
                    Inventory Information
                </strong>
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item bg-color-3652AD p-3 text-white" href="{{ route('admin.user.view') }}">
                    User
                </a>
                <a class="list-group-item p-3 bg-color-3652AD p-3 text-white" href="{{ route('admin.product.view') }}">
                    Products
                </a>
                <a class="list-group-item p-3 cursor-pointer bg-color-3652AD p-3 text-white"
                    onclick="doLogout()">Logout</a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper" style="margin-left: 16%">
            <div class="d-flex justify-content-end align-items-center border-start pt-3">
                <div class="col-md-2 col-xs-3">
                    <div class="d-flex align-items-center">
                        <img src="https://img.freepik.com/premium-photo/man-wearing-glasses-smiling_81048-29604.jpg?w=740"
                            class="me-3" style="border: 1px;border-radius:50%;width:50px" alt="">
                        <strong class="text-dark">{{ Auth::user()->name }}</strong>
                    </div>
                </div>
            </div>
            <div class="container mt-3">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    @include('admin.layouts._footer')

    <script>
        $(document).ready(function() {

        });

        function doLogout() {
            $("#logout-form").submit();
        }
    </script>
</body>

</html>
