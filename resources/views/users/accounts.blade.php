@extends("common.master")

@section("title")
    User Account
@endsection

@section("body")
    <div class="container-fluid">
        <div class="page_title py-2">
            <p>Account Details</p>
        </div>

        <div class="my-3">
            
        </div>
    </div>
    @include('common.spinner')
    @include('common.alert')
@endsection

@push('scripts')
    <script src="{{ asset("assets/js/jquery.min.js") }}"></script>
    <script src="{{ asset("assets/js/bootstrap.bundle.js") }}"></script>
    <script src="{{ asset("assets/js/aos.js") }}"></script>
    <script src="{{ asset("assets/js/datatable.min.js") }}"></script>
    <script>
        $(document).ready(function(){
            
        });
    </script>
@endpush