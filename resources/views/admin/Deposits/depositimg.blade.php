<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel ">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-5">
                    <h1 class="title1 d-inline text-{{ $text }}">View Deposit Screenshot</h1>
                    <div class="d-inline">
                        <div class="float-right btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ route('mdeposits') }}"> <i class="fa fa-arrow-left"></i>
                                back</a>
                        </div>
                    </div>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="mb-5 row">
                    <div class="col-lg-8 offset-lg-2 card p-4  shadow">
                        <!-- Deposit Details Edit Section -->
                        <div class="mb-4 p-3 border rounded" style="background-color: #f8f9fa; border-color: #dee2e6;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="fa fa-edit text-primary"></i> Edit Deposit Details
                                </h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="toggleEditForm">
                                    <i class="fa fa-eye"></i> Toggle Edit Form
                                </button>
                            </div>

                            <div id="editFormContainer" style="display: none;">
                                <form action="{{ route('edit.deposit') }}" method="POST" id="editDepositForm">
                                    @csrf
                                    <input type="hidden" name="deposit_id" value="{{ $deposit->id }}">

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="edit_amount"><strong>Amount</strong></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number" step="0.01" class="form-control" name="amount" id="edit_amount"
                                                       value="{{ $deposit->amount }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="edit_status"><strong>Status</strong></label>
                                            <select name="status" id="edit_status" class="form-control" required>
                                                <option value="Pending" {{ $deposit->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Processed" {{ $deposit->status == 'Processed' ? 'selected' : '' }}>Processed</option>
                                                <option value="Rejected" {{ $deposit->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="edit_payment_mode"><strong>Payment Mode</strong></label>
                                            <input type="text" class="form-control" name="payment_mode" id="edit_payment_mode"
                                                   value="{{ $deposit->payment_mode }}" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="edit_created_at"><strong>Created Date</strong></label>
                                            <input type="datetime-local" class="form-control" name="created_at" id="edit_created_at"
                                                   value="{{ \Carbon\Carbon::parse($deposit->created_at)->format('Y-m-d\TH:i') }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-secondary mr-2" id="cancelEdit">
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update Deposit Details
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Current Values Display -->
                            <div id="currentValues">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Current Amount:</strong> ${{ number_format($deposit->amount, 2) }}</p>
                                        <p><strong>Current Status:</strong>
                                            <span class="badge badge-{{ $deposit->status == 'Processed' ? 'success' : ($deposit->status == 'Pending' ? 'warning' : 'danger') }}">
                                                {{ $deposit->status }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Current Payment Mode:</strong> {{ $deposit->payment_mode }}</p>
                                        <p><strong>Created Date:</strong> {{ \Carbon\Carbon::parse($deposit->created_at)->format('M d, Y H:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr class="my-4">

                        <div class="mb-3">
                            <h4 class="text-{{ $text }}">Deposit Proof Screenshot</h4>
                        </div>

                        <img src="{{ asset('storage/app/public/' . $deposit->proof) }}" alt="Proof of Payment"
                            class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle edit form visibility
                document.getElementById('toggleEditForm').addEventListener('click', function() {
                    const editContainer = document.getElementById('editFormContainer');
                    const currentValues = document.getElementById('currentValues');
                    const button = this;

                    if (editContainer.style.display === 'none') {
                        editContainer.style.display = 'block';
                        currentValues.style.display = 'none';
                        button.innerHTML = '<i class="fa fa-eye-slash"></i> Hide Edit Form';
                    } else {
                        editContainer.style.display = 'none';
                        currentValues.style.display = 'block';
                        button.innerHTML = '<i class="fa fa-eye"></i> Toggle Edit Form';
                    }
                });

                // Cancel edit functionality
                document.getElementById('cancelEdit').addEventListener('click', function() {
                    document.getElementById('editFormContainer').style.display = 'none';
                    document.getElementById('currentValues').style.display = 'block';
                    document.getElementById('toggleEditForm').innerHTML = '<i class="fa fa-eye"></i> Toggle Edit Form';
                });

                // Form validation
                document.getElementById('editDepositForm').addEventListener('submit', function(e) {
                    const amount = parseFloat(document.getElementById('edit_amount').value);
                    if (amount < 0) {
                        e.preventDefault();
                        alert('Amount cannot be negative');
                        return false;
                    }

                    if (confirm('Are you sure you want to update this deposit request?')) {
                        return true;
                    } else {
                        e.preventDefault();
                        return false;
                    }
                });
            });
        </script>
    @endsection
