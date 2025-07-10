<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FEI TOOLS') }}</title>

    <!-- Styles -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>

    <script>
        window.Laravel = @json([
            'csrfToken' => csrf_token(),
        ]);
    </script>
    @yield('head')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'FEI TOOLS') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (Auth::guest())
                        &nbsp;
			@else
				<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Order Processing <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/orders') }}">
                                            Orders Without PO
                                        </a>
                                        <a href="{{ url('/find/orders') }}">
                                            Find by Order #
                                        </a>
                                        <a href="{{ url('/orders/issues') }}">
                                            Orders with issues
                                        </a>
				</li>
				</ul>
				</li>
                                <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    PO Invoices<span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/po/partialinv') }}">
                                            Open POs
                                        </a>
                                        <a href="{{ url('/po/find') }}">
                                           Find by PO # 
                                        </a>
                                        <a href="{{ url('/po/cusfind') }}">
                                           Find by Customer Invoice # 
                                        </a>
                                        <a href="{{ url('/po/salesfind') }}">
                                           Find Sales Order # 
                                        </a>
                                        <a href="{{ url('/po/find/vendor') }}">
                                           Find by Vendor 
                                        </a>
				</li>
				</ul>

				</li>

                                <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Vendors <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>

                                        <a href="{{ url('/vendor/createvendor') }}">
                                            Create Vendor
                                        </a>
                                        
                                        <a href="{{ url('/vendor/editvendor') }}">
                                            Edit Vendor
                                        </a>
                                        
                                        <a href="{{ url('/vendor/findvendor') }}">
                                            Create New Vendor Rule
                                        </a>

                                        <a href="{{ url('/vendor/search') }}">
                                            Edit Vendor Rule
                                        </a>
				</li>
				</ul>

				</li>

                                <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Inventory <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/stock/find/vendor') }}">
					    New Stock PO
                                        </a>
                                        <a href="{{ url('/stock/find/po') }}">
					    Find by PO #
                                        </a>
                                        <a href="{{ url('/stock/openpos') }}">
					    Open Stock POs
                                        </a>
                                        <a href="{{ url('/stock/update') }}">
					    Update Stock Count
                                        </a>
				</li>
				</ul>

				</li>

                                <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Inquiries <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/inquiry/find/item') }}">
					    Item Lookup
                                        </a>
                                        <a href="{{ url('/inquiry/find/vendor') }}">
					    Vendor Lookup
                                        </a>
                                        <a href="{{ url('/inquiry/find/povendor') }}">
					    Vendor PO History
                                        </a>
                                        <a href="{{ url('/inquiry/find/itemsales') }}">
					    Sales History Lookup
                                        </a>
				</li>
				</ul>

				</li>
				

				</li>
				
								
								                                <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Product Updates <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/product/findvendor') }}">
					    Price Update by Vendor
                                        </a>
                                  <!--      <a href="{{ url('/product/bulkdiscontinue') }}">
					    Bulk Discontinue
                                        </a> -->

				</li>
				</ul>

				</li>
				
								                                <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Reports <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/reports/tax/date') }}">
					    Sales Tax Report
                                        </a>
                                        <a href="{{ url('/reports/open') }}">
					    Missing Orders Report
                                        </a>
				</li>
				</ul>

				</li>


        @if(Auth::user()->is_admin)
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    Admin <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{ route('admin.users.index') }}">User Management</a>
                    </li>
                    <!-- You can add more admin links here as needed -->
                </ul>
            </li>
        @endif


			@endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
	@yield('footer')

    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
@yield('scripts')
</body>
</html>
