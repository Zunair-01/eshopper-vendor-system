@extends('app')

@section('title')
Setting
@endsection

@section('content')
<div class="container">
    <button type="button" class="btn btn-primary add" style="float: right; margin-bottom: 15px;">
        Add
    </button>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Tax</th>
                <th>Discount</th>
                <th>Delivery Charges</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="chargesTableBody">
            <!-- Charges will be dynamically added here -->
        </tbody>
    </table>
</div>

<!-- Add Modal Structure -->
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Enter Charges</h5>
            </div>
            <div class="modal-body">
                <form id="chargesForm">
                    <div class="form-group">
                        <label for="tax">Tax</label>
                        <input type="number" class="form-control" id="tax" placeholder="Enter tax amount" required>
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount</label>
                        <input type="number" class="form-control" id="discount" placeholder="Enter discount amount" required>
                    </div>
                    <div class="form-group">
                        <label for="deliveryCharges">Delivery Charges</label>
                        <input type="number" class="form-control" id="deliveryCharges" placeholder="Enter delivery charges" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary">Close</button>
                <button type="button" class="btn btn-primary" id="saveChargesBtn">Save changes</button>

            </div>
        </div>
    </div>
</div>

<!-- Edit Modal Structure -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Charges</h5>
            </div>
            <div class="modal-body">
                <form id="editChargesForm">
                    <input type="hidden" id="edit_product_id" name="product_id">
                    <div class="form-group">
                        <label for="editTax">Tax</label>
                        <input type="number" class="form-control" id="editTax" placeholder="Enter tax amount" required>
                    </div>
                    <div class="form-group">
                        <label for="editDiscount">Discount</label>
                        <input type="number" class="form-control" id="editDiscount" placeholder="Enter discount amount" required>
                    </div>
                    <div class="form-group">
                        <label for="editDeliveryCharges">Delivery Charges</label>
                        <input type="number" class="form-control" id="editDeliveryCharges" placeholder="Enter delivery charges" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary closeedit">Close</button>
                <button type="submit" class="btn btn-primary" id="updateChargesBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('js/admin/charges.js') }}"></script>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/setting.css') }}">
@endsection

