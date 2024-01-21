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
                                <tr data-product="{{ $item }}" class="text-center">
                                    <td>{{ $item->product_name }}</td>
                                    <td><img src="{{ asset($item->image) }}" width="150" alt=""></td>
                                    <td>{{ $item->qty }}</td>
                                    <td>Rp{{ number_format($item->buy_price) }}</td>
                                    <td>Rp{{ number_format($item->sell_price) }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="editProduct(this)">Edit</button>
                                        <button class="btn btn-danger btn-sm" data-href={{ route('admin.product.delete') }}
                                            onclick="deleted(this)">Delete</button>
                                    </td>
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
                            <form action="{{ route('admin.product.create') }}" method="post" class="p-3"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Product Name:</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name"
                                        value="{{ old('product_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="value">Buy Price:</label>
                                    <input type="number" class="form-control" id="buy_price" name="buy_price"
                                        value="{{ old('buy_price') }}">
                                </div>
                                <div class="form-group">
                                    <label for="value">Sell Price:</label>
                                    <input type="number" class="form-control" id="sell_price" name="sell_price"
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
                                <button type="button" class="close btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.product.update') }}" method="post" class="p-3"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" id="product_id">
                                <div class="form-group">
                                    <label for="name">Product Name:</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name"
                                        value="{{ old('product_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="value">Buy Price:</label>
                                    <input type="number" class="form-control" id="buy_price" name="buy_price"
                                        value="{{ old('buy_price') }}" step="1">
                                </div>
                                <div class="form-group">
                                    <label for="value">Sell Price:</label>
                                    <input type="number" class="form-control" id="sell_price" name="sell_price"
                                        value="{{ old('sell_price') }}" step="1">
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
                                    <div id="imageUrl"></div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

    <script>
        const storageUrl = "{{ url('/') }}/";
        $(document).ready(function() {
            $('#buy_price').on('input', function() {
                // Allow only numeric input
                $(this).val(function(index, value) {
                    return value.replace(/[^0-9]/g, '');
                });
            });
            $('#sell_price').on('input', function() {
                // Allow only numeric input
                $(this).val(function(index, value) {
                    return value.replace(/[^0-9]/g, '');
                });
            });
            $('#editModal #buy_price').on('input', function() {
                // Allow only numeric input
                $(this).val(function(index, value) {
                    return value.replace(/[^0-9]/g, '');
                });
            });
            $('#editModal #sell_price').on('input', function() {
                // Allow only numeric input
                $(this).val(function(index, value) {
                    return value.replace(/[^0-9]/g, '');
                });
            });
        });

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

        function editProduct(el) {
            let product = $(el).closest('tr').data("product");
            let imageUrl = "";
            if (product.image.includes('https')) {
                imageUrl = product.image;
            } else {
                imageUrl = storageUrl + product.image;
            }
            console.log(imageUrl);
            $("#modalEdit #product_id").val(product.id);
            $("#modalEdit #product_name").val(product.product_name);
            $("#modalEdit #buy_price").val(product.buy_price);
            $("#modalEdit #sell_price").val(product.sell_price);
            $("#modalEdit #qty").val(product.qty);
            // $("#modalEdit #image").val(product.image);
            $("#modalEdit #imageUrl").empty();
            $("#modalEdit #imageUrl").append(
                `<img src="${imageUrl}" width="100px" class="mt-3 rounded" alt="" />`);

            $('#editModal').modal('show');
        }

        function deleted(el) {
            let product = $(el).closest('tr').data("product");
            let action = $(el).data('href');
            let confirmation = confirm("Are you sure delete " + product.product_name + "?");

            if (confirmation) {
                $("#submit-form div").empty();
                $("#submit-form").attr("action", action);
                $("#submit-form").attr("method", "POST");
                $("#submit-form div").append('<input type="hidden" name="id" value="' + product.id + '" />');
                $("#submit-form").submit();
            }
        }
    </script>
@endsection
