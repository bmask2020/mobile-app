<div class="deznav">
    <div class="deznav-scroll">
        <div class="main-profile">
            <img src="images/Untitled-1.jpg" alt="">
            <a href="javascript:void(0);"><i class="fa fa-cog" aria-hidden="true"></i></a>
            <h5 class="mb-0 fs-20 text-black "><span class="font-w400">Hello,</span> Marquez</h5>
            <p class="mb-0 fs-14 font-w400">marquezzzz@mail.com</p>
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
         
       
            <li><a href="widget-basic.html" class="ai-icon" aria-expanded="false">
                <i class="flaticon-381-settings-2"></i>
                <span class="nav-text">Logout</span>
            </a>
            </li>
          
        </ul>
        <div class="copyright">
            <p><strong>Zenix Crypto Admin Dashboard</strong> © 2021 All Rights Reserved</p>
            <p class="fs-12">Made with <span class="heart"></span> by DexignZone</p>
        </div>
    </div>
</div>