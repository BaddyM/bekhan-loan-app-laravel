@extends('common.master')

@section('title')
    Home
@endsection

@section('body')
    <div class="container-fluid">
        <div class="row w-100 justify-content-between align-items-center">
            <div class="col-md-6">
                <div class="summary_container">
                    <div class="mb-0 summary_title">Active Accounts</div>
                    <div class="mb-0 summary_item">20</div>
                </div>
        
                <div class="summary_container">
                    <div class="mb-0 summary_title">Active Admins</div>
                    <div class="mb-0 summary_item">20</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="summary_container">
                    <div class="mb-0 summary_title">Pending Loans</div>
                    <div class="mb-0 summary_item">20</div>
                </div>
        
                <div class="summary_container">
                    <div class="mb-0 summary_title">Pending Confirmation</div>
                    <div class="mb-0 summary_item">20</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset("assets/js/jquery.min.js") }}"></script>
    <script src="{{ asset("assets/js/bootstrap.bundle.js") }}"></script>
    <script src="{{ asset("assets/js/aos.js") }}"></script>
    <script src="{{ asset("assets/js/datatable.min.js") }}"></script>
    <script>
        
    </script>
@endpush