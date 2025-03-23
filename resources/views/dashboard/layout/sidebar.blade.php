@php($user = DB::table('users')->where('id', '=', Auth::user()->id)->first())

<div class="deznav">
    <div class="deznav-scroll">
        <div class="main-profile">
            @if($user->img != '')
            <img src="{{ $user->img }}" alt="" draggable="false">
            @else
            <img src="images/Untitled-1.jpg" alt="">
            @endif
            <h5 class="mb-0 fs-20 text-black "><span class="font-w400">Hello,</span> {{ $user->name }}</h5>
            <p class="mb-0 fs-14 font-w400">{{ $user->email }}</p>
        </div>
        <ul class="metismenu" id="menu">
            <li><a class="ai-icon" href="{{ route('dashboard') }}" aria-expanded="false">
                    <i class="flaticon-144-layout"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
              

            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-077-menu-1"></i>
                    <span class="nav-text">Brands</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('view.brand') }}">View</a></li>
                    <li><a href="{{ route('add.brand') }}">Add Brand</a></li>
                
                </ul>
            </li>


            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-061-puzzle"></i>
                    <span class="nav-text">Products</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('view.products') }}">View</a></li>
                    <li><a href="{{ route('add.product') }}">Add Product</a></li>
                   
                </ul>
            </li>
            <li><a class="ai-icon" href="{{ route('users.view') }}" aria-expanded="false">
                <i class="flaticon-144-layout"></i>
                <span class="nav-text">Users</span>
            </a>
          

            </li>
         
       
            <li><a href="{{ route('admin.logout') }}" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-settings-2"></i>
                <span class="nav-text">Logout</span>
            </a>
            </li>
          
        </ul>
     
    </div>
</div>