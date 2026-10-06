@extends('app')

@section('title', 'Product')

@section('content')
<div class="container mt-5">
    <h3 class="text-start mb-4">Add Product</h3>
    <!-- Product Form -->
    <form class="form-horizontal mb-5" enctype="multipart/form-data" id="productForm">
        @csrf
        <div class="form-group row mb-3">
            <label for="name" class="col-sm-2 col-form-label">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="price" class="col-sm-2 col-form-label">Price:</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price" placeholder="Enter product price" required>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="category" class="col-sm-2 col-form-label">Category:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="category" name="category" placeholder="Enter product category" required>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="description" class="col-sm-2 col-form-label">Description:</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="description" name="description" placeholder="Enter product description" rows="3" required></textarea>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="image" class="col-sm-2 col-form-label">Image:</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </div>
    </form>

    <!-- Products Table -->
    <table class="table table-bordered table-striped" id="productTable">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_product_id" name="id" value="">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_price">Price</label>
                            <input type="number" class="form-control" id="edit_price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_category">Category</label>
                            <input type="text" class="form-control" id="edit_category" name="category" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <img id="edit_image_preview" src="" alt="Product Image" style="width: 50px; height: 50px; margin-top: 5px;">
                        </div>
                        <div class="form-group">
                            <label for="edit_image">Upload New Image</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        </div>

                        <!-- Flex container to align buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            <button type="button" class="btn btn-secondary cancelButton">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                <button type="button" class="close cancelButton" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancelButton" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>


</div>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/admin/product.js') }}"></script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/product.css') }}">
@endsection

