 <aside style="z-index: 100"
     class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
     id="sidenav-main">
     <div class="sidenav-header">
         <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
             aria-hidden="true" id="iconSidenav"></i>
         <a class="navbar-brand m-0" href="{{ route('dashboard-smart-pica') }}" target="_blank">
             <img src="{{ asset('img/logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
             <span class="ms-1 font-weight-bold text-white">Bina Sarana Sukses</span>
         </a>
     </div>
     <hr class="horizontal light mt-0 mb-2">
     <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
         <div class="navbar-search mb-3 " style="background-color: white; margin:10px; border-radius: 20px">
             <input type="text" id="navbarSearch" class="form-control" placeholder="Search menu..."
                 style="margin:10px">
         </div>
         <ul class="navbar-nav">
             @foreach ($menu as $nav)
                 <li class="nav-item">
                     <a class="nav-link text-white active bg-gradient-primary nav-menu-utama" href="#">
                         <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                             <i class="fa fa-sitemap"></i>
                         </div>
                         <span class="nav-link-text ms-1">{{ $nav['nama'] }}</span>
                     </a>

                     <ul class="submenu navbar-nav">
                         @for ($i = 0; $i < count($nav['child']); $i++)
                             <li class="nav-item">
                                 <a class="nav-link text-white " id="{{ $nav['child'][$i]['id'] }}"
                                     href="{{ $nav['child'][$i]['type'] == 'redirect' ? env('EXT_APP_URL') . $nav['child'][$i]['link'] . '?id=' . $userIdToken : $nav['child'][$i]['link'] }}">
                                     <div
                                         class="text-white text-center d-flex align-items-center justify-content-center">
                                     </div>
                                     <span class="nav-link-text">{{ $nav['child'][$i]['nama'] }}</span>
                                 </a>
                             </li>
                         @endfor
                     </ul>
                 </li>
             @endforeach
         </ul>

     </div>
     <div class="sidenav-footer position-absolute w-100 bottom-0 ">
     </div>
 </aside>
