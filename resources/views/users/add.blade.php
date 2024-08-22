@extends("common.master")

@section("title")
    Create Account
@endsection

@section("body")
    <div class="container-fluid">
        <div class="page_title py-2">
            <p>Add User Account</p>
        </div>

        <div class="my-3">
            <form id="add_account_form" method="post">
                @csrf
                <div class="row justify-content-between">
                    <div class="col-md-5 mb-2">
                        <label class="form-label"><i class="fa fa-user"></i> Last Name</label>
                        <input type="text" class="form-control rounded-0" name="lname" placeholder="Enter Last Name" required>
                    </div>
                    <div class="col-md-5 mb-2">
                        <label class="form-label"><i class="fa fa-user"></i> First Name</label>
                        <input type="text" class="form-control rounded-0" name="fname" placeholder="Enter First Name" required>
                    </div>
                </div>

                <div class="row justify-content-between">
                    <div class="col-md-5 mb-2">
                        <label class="form-label"><i class="bi bi-envelope-open-fill"></i> Email</label>
                        <input type="email" class="form-control rounded-0" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class="col-md-5 mb-2">
                        <label class="form-label"><i class="fa fa-users"></i> Gender</label>
                        <select class="form-select rounded-0" name="gender" placeholder="Enter First Name" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>

                <div class="row justify-content-between">
                    <div class="col-md-5 mb-2">
                        <label class="form-label"><i class="fa fa-lock"></i> Password</label>
                        <input type="password" class="form-control rounded-0" name="password" id="password" placeholder="Enter Password" required>
                    </div>
                    <div class="col-md-5 mb-2">
                        <label class="form-label"><i class="fa fa-lock"></i>  Confirm Password</label>
                        <input type="password" class="form-control rounded-0" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password" required>
                    </div>
                </div>

                <button class="submit-btn" type="submit">Submit</button>
            </form>          
            @include('common.spinner')
        </div>
    </div>
    @include('common.alert')
@endsection

@push('scripts')
    <script src="{{ asset("assets/js/jquery.min.js") }}"></script>
    <script src="{{ asset("assets/js/bootstrap.bundle.js") }}"></script>
    <script src="{{ asset("assets/js/aos.js") }}"></script>
    <script src="{{ asset("assets/js/datatable.min.js") }}"></script>
    <script>
        $(document).ready(function(){
            $("#add_account_form").on("submit",function(e){
                e.preventDefault();
                const password = $("#password").val();
                const confirm_password = $("#confirm_password").val();

                if(password == confirm_password && password.length > 6){
                    $("#spinner").removeClass("d-none");
                    $("#add_account_form").addClass("d-none");

                    $.ajax({
                        type:"POST",
                        url:"{{ route('user.add.account') }}",
                        data: new FormData(this),
                        processData:false,
                        cache:false,
                        contentType:false,
                        success:function(response){
                            $("#alert_body").text(response);
                            $("#alertId").modal('show');
                            $("#add_account_form")[0].reset();
                            setTimeout(() => {
                                $("#alertId").modal('hide');
                            }, 2000);

                            $("#spinner").addClass("d-none");
                            $("#add_account_form").removeClass("d-none");
                        },
                        error:function(){
                            $("#alert_body").text("Failed to Add User!");
                            $("#alertId").modal('show');
                            $("#spinner").addClass("d-none");
                            $("#add_account_form").removeClass("d-none");
                        }
                    })
                }else if(!(password == confirm_password)){
                    $("#alertId").modal('show');
                    $("#alert_body").text("Password Mismatch!");
                    setTimeout(() => {
                        $("#alertId").modal('hide');
                    }, 2000);
                }else if(password.length < 6){
                    $("#alertId").modal('show');
                    $("#alert_body").text("Password Should be greater than 6 Characters!");
                    setTimeout(() => {
                        $("#alertId").modal('hide');
                    }, 2000);
                }else{
                    $("#alertId").modal('show');
                    $("#alert_body").text("Failed, Try Again!");
                    setTimeout(() => {
                        $("#alertId").modal('hide');
                    }, 2000);
                }
            });

            $("#alertId").on("hidden.bs.modal",function(){
                $("#alert_body").text(null);
            });
        })
    </script>
@endpush