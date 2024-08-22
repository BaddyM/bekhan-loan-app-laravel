@php
    $brand_name = "bekhan extra cash";
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons/bootstrap-icons.css') }}">
</head>

<body>
    <div class="brand-container">
        <p class="mb-0 text-center">{{ $brand_name }}</p>
    </div>
    <div class="dashboard_container">
        <div class="links_container">
            <div class="nav-item-container">
                <button class="btn border-0 nav-btn" data-nav-item="accounts"><i class="bi bi-people-fill"></i>
                    User Accounts</button>
                <ul id="accounts-nav-item" class="nav-items">
                    <a href="{{ route('user.index') }}">
                        <li><i class="bi bi-person-plus-fill h5"></i> Create Account</li>
                    </a>
                    <a href="{{ route('user.accounts.index') }}">
                        <li><i class="bi bi-arrow-repeat h5"></i> Account Details</li>
                    </a>
                </ul>
            </div>

            <div class="nav-item-container">
                <button class="btn border-0 nav-btn" data-nav-item="loan_user_accounts"><i class="fa fa-users"></i>
                    Loan User Accounts</button>
                <ul id="loan_user_accounts-nav-item" class="nav-items">
                    <a href="">
                        <li><i class="bi bi-arrow-repeat h5"></i> Account Details</li>
                    </a>
                </ul>
            </div>

            <div class="nav-item-container">
                <button class="btn border-0 nav-btn" data-nav-item="loans"><i class="bi bi-bank2"></i>
                    Loans</button>
                <ul id="loans-nav-item" class="nav-items">
                    <a href="">
                        <li><i class="bi bi-coin h5"></i> Loan Packages</li>
                    </a>
                    <a href="">
                        <li><i class="bi bi-arrow-repeat h5"></i> Loan Status</li>
                    </a>
                    <a href="">
                        <li><i class="bi bi-hourglass-bottom"></i> Pending Loans</li>
                    </a>
                    <a href="">
                        <li><i class="bi bi-hourglass"></i> Pending Confirmation</li>
                    </a>
                </ul>
            </div>

            <div class="nav-item-container">
                <button class="btn border-0 nav-btn" data-nav-item="user_data"><i
                        class="bi bi-person-fill-gear"></i>
                    User Data</button>
                <ul id="user_data-nav-item" class="nav-items">
                    <a href="">
                        <li><i class="bi bi-person-down h5"></i> View Data </li>
                    </a>
                    <a href="">
                        <li><i class="bi bi-person-fill-add h5"></i> Data Status</li>
                    </a>
                </ul>
            </div>

            <div class="nav-item-container">
                <button class="btn border-0 nav-btn" data-nav-item="sms"><i
                        class="bi bi-chat-fill"></i>
                    SMS</button>
                <ul id="sms-nav-item" class="nav-items">
                    <a href="">
                        <li><i class="bi bi-chat-dots h5"></i> Send SMS</li>
                    </a>
                </ul>
            </div>

            <div class="nav-item-container">
                <button class="btn border-0 nav-btn" data-nav-item="balancesheet"><i
                        class="bi bi-file-earmark-spreadsheet-fill"></i>
                    Balance Sheet</button>
                <ul id="balancesheet-nav-item" class="nav-items">
                    <a href="">
                        <li><i class="bi bi-currency-exchange h5"></i> Profit or Loss</li>
                    </a>
                    <a href="">
                        <li><i class="bi bi-card-list h5"></i> Summary</li>
                    </a>
                </ul>
            </div>
        </div>

        <div class="menu_btn">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>

        <div class="dashboard_body">
            @yield('body')
        </div>
    </div>
    @stack('scripts')
    <script class="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(window).on('load', function() {
                $(".nav-items").hide();
            });

            $(".menu_btn").on("click",function(){
                $(".links_container").toggleClass("link_active")
            })

            $(".nav-btn").on('click', function(e) {
                e.preventDefault();
                var nav_val = $(this).data('nav-item');
                $("#" + nav_val + "-nav-item").slideToggle();
            });
        });
    </script>
</body>

</html>
