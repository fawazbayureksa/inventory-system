@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex flex-column">
                    <h3>Products</h3>
                    <button type="button" class="btn btn-primary align-self-end" data-bs-toggle="modal"
                        data-bs-target="#addProductModal">
                        New Product
                    </button>
                    <form method="GET" action="{{ url()->current() }}">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                {{-- <label for="">Search</label> --}}
                                <input type="text" name="filter[name]" placeholder="search .." class="form-control"
                                    value="{{ request('filter')['name'] ?? '' }}">
                            </div>
                            <div class="col-md-3 ms-3">
                                <button type="submit" class="btn btn-secondary btn-md">Search</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Qty</th>
                                <th>Buy Price</th>
                                <th>Sell Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $item)
                                <tr data-operation="{{ $item }}" class="text-center">
                                    <td>{{ $item->product_name }}</td>
                                    <td><img src="{{ $item->image }}" width="150" alt=""></td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp{{ $item->buy_price }}</td>
                                    <td>Rp{{ $item->sell_price }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            @if (count($products) < 1)
                                <tr>
                                    <td colspan="6" class="text-center font-weight-bold">Tidak Ada Data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $products->onEachSide(5)->links() }}
                </div>
                <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" id="addModal">
                                <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
                                <button type="button" class="close btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.product.create') }}" method="post" class="p-3">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Product Name:</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name"
                                        value="{{ old('product_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="value">Buy Price:</label>
                                    <input type="number" class="form-control" id="price" name="buy_price"
                                        value="{{ old('buy_price') }}">
                                </div>
                                <div class="form-group">
                                    <label for="value">Sell Price:</label>
                                    <input type="number" class="form-control" id="price" name="sell_price"
                                        value="{{ old('sell_price') }}">
                                </div>
                                <div class="form-group">
                                    <label for="value">Qty:</label>
                                    <input type="number" class="form-control" id="qty" name="qty"
                                        value="{{ old('qty') }}">
                                </div>
                                <div class="form-group">
                                    <label for="image">Image:</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        value="{{ old('image') }}">
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn bg-color-3652AD ms-2 w-25 text-white">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" id="modalEdit">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Product</h5>
                                <button type="button" class="close btn-close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.product.update') }}" method="post" class="p-3">
                                @csrf
                                <input type="hidden" name="id" id="product_id">
                                <div class="form-group">
                                    <label for="name">Product Name:</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name"
                                        value="{{ old('product_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="value">Price:</label>
                                    <input type="number" class="form-control" id="price" name="price"
                                        value="{{ old('price') }}">
                                </div>
                                <div class="form-group">
                                    <label for="value">Qty:</label>
                                    <input type="number" class="form-control" id="qty" name="qty"
                                        value="{{ old('qty') }}">
                                </div>
                                <div class="form-group">
                                    <label for="image">Image:</label>
                                    <input type="text" class="form-control" id="image" name="image"
                                        value="{{ old('image') }}">
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-success ms-2 w-25">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <form action="" method="post" id="submit-form">
                    @csrf
                    <div></div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script>
        // $("#ButtonProductModal").on('click', function() {
        //     // console.log("Add Product Modal");
        //     $("#addProductModal").show();
        // });

        function nonActiveData(el) {
            let operation = $(el).closest('tr').data("operation");
            let action = $(el).data('href');
            let confirmation = confirm("Lanjutkan untuk mengnonaktifkan data dengan nama " + operation.name + "?");

            if (confirmation) {
                $("#submit-form div").empty();
                $("#submit-form").attr("action", action);
                $("#submit-form").attr("method", "POST");
                $("#submit-form div").append('<input type="hidden" name="id" value="' + operation.id + '" />');
                $("#submit-form").submit();
            }
        }

        function editData(el) {
            let operation = $(el).closest('tr').data("operation");
            $("#modalEdit #id_data").val(operation.id);
            $("#modalEdit #name").val(operation.name);
            $("#modalEdit #value").val(operation.value);
            $("#modalEdit #second_name").val(operation.second_name);
            $("#modalEdit #second_value").val(operation.second_value);
            $("#modalEdit #asset_url").val(operation.asset_url);
        }

        function deleted(el) {
            let operation = $(el).closest('tr').data('operation');
            let action = $(el).data('href');
            let confirmation = confirm("Lanjutkan untuk menghapus data dengan nama " + operation.name + "?");

            if (confirmation) {
                $("#submit-form div").empty();
                $("#submit-form").attr("action", action);
                $("#submit-form").attr("method", "POST");
                $("#submit-form div").append('<input type="hidden" name="id" value="' + operation.id + '" />');
                $("#submit-form").submit();
            }
        }
    </script>
@endsection
