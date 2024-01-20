@extends('admin.layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex flex-column">
            <h3>Products</h3>
            <button class="btn btn-primary align-self-end" data-toggle="modal" data-target="#addProductModal">
                New Product
            </button>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Categories</th>
                        <th>Qty</th>
                        <th>Price</th>
                        {{-- <th>Created at</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @foreach ($operation_data as $key => $item)
                        <tr data-operation="{{ $item }}" class="text-center">
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->value }}</td>
                            <td><img src="{{ $item->asset_url }}" width="100" height="100" alt=""></td>
                            <td>
                                @if ($item->status)
                                    Active
                                @else
                                    Nonactive
                                @endif
                            </td>
                            <td>
                                {{ $item->created_at->format('Y-m-d (H:i)') }}
                                <br />
                                <small>
                                    ({{ $item->users->name }})
                                </small>
                            </td>
                            <td>{{ $item->updated_at->format('Y-m-d (H:i)') }}
                                <br />
                                <small>
                                    ({{ $item->updatedBy->name }})
                                </small>
                            </td>
                            <td width="20%">
                                @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
                                    @if ($item->status)
                                        <button onclick="nonActiveData(this)" class="btn btn-secondary btn-sm"
                                            data-href="{{ route('admin.product.nonactive') }}"
                                            role="button">Non-active</button>
                                    @else
                                        <button onclick="activeData(this)" class="btn btn-secondary btn-sm"
                                            data-href="{{ route('admin.product.active') }}"
                                            role="button">Active</button>
                                        <button onclick="editData(this)" data-toggle="modal" data-target="#editModal"
                                            class="btn btn-sm btn-secondary me-2 w-auto">Edit</button>
                                        <button data-href="{{ route('admin.product.deleted', ['id' => $item->id]) }}"
                                            onclick="deleted(this)"
                                            class="btn btn-sm btn-danger me-2 w-auto">Delete</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if (count($operation_data) < 1)
                        <tr>
                            <td colspan="6" class="text-center font-weight-bold">Tidak Ada Data</td>
                        </tr>
                    @endif
                </tbody> --}}
            </table>
        </div>

        <div class="modal fade" id="addProductModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="addProductModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="addModal">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
                        <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.product.create') }}" method="post" class="p-3">
                        @csrf
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
        <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="modalEdit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Product</h5>
                        <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"></button>
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
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {

        });

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
