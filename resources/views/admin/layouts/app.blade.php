<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html>

<head>
    @include('admin.layouts._header')
</head>
@section('custom-css')
    <style>
        .active {
            background-color: #93cfac !important;
            color: #93cfac !important;
        }
    </style>
@endsection

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div id="sidebar-wrapper">
            <div class="border-bottom sidebar-heading">
                <strong class="text-white">
                    Inventory Information
                </strong>
            </div>
            <div class="list-group list-group-flush">
                {{-- @php
                        $isActive = isset($menuItem['route']) && str_contains(request()->url(), $menuItem['url']);
                        $class = 'list-group-item p-3 ' . ($isActive ? 'bg-white text-dark' : 'text-white');
                    @endphp --}}
                {{-- @if (isset($menuItem['route'])) href="{{ route($menuItem['route']) }}" @endif
                    @if (isset($menuItem['onclick'])) onclick="{{ $menuItem['onclick'] }}" @endif> --}}
                {{-- {{ $menuItem['text'] }} --}}
                <a class="list-group-item p-3" href="{{ route('admin.user.view') }}">
                    User
                </a>
                <a class="list-group-item p-3" href="{{ route('admin.product.view') }}">
                    Products
                </a>
                <a class="list-group-item p-3 cursor-pointer" onclick="doLogout()">Logout</a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <div class="d-flex justify-content-between align-items-center border-start  pb-3 pt-4">
                <div class="col-md-2 col-xs-3">
                    <button class="btn btn-dark  ms-3  mt-3" id="sidebarToggle">
                        {{-- <i class="fas fa-bars"></i> --}}
                        Close
                    </button>
                </div>
                <div class="col-md-2 col-xs-3">
                    <div class="d-flex align-items-center">
                        <img src="https://www.singa.id/assets/images/leona-3d/leona-ojk.png" class="me-3"
                            style="border: 1px;border-radius:50%;width:50px" alt="">
                        <strong class="text-dark">{{ Auth::user()->name }}</strong>
                    </div>
                </div>
            </div>
            <div class="container-fluid p-3 mt-3">
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

    <div class="modal">
        <!-- Place at bottom of page -->
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
