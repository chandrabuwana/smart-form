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
                                <a class="nav-link text-white " href="{{ $nav['child'][$i]['link']  }}" id="{{ $nav['child'][$i]['id']}}">
                                    <div class="text-white text-center d-flex align-items-center justify-content-center">
                                    </div>
                                    <span class="nav-link-text">{{ $nav['child'][$i]['nama'] }}</span>
                                </a>
                            </li>
                        @endfor
                    </ul>
                </li>
            @endforeach
            <!--
             <li class="nav-item">
                 <a class="nav-link text-white active bg-gradient-primary" href="#" id="menuSmartPica">
                     <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                         <i class="fa fa-sitemap"></i>
                     </div>
                     <span class="nav-link-text ms-1">Smart Pica</span>
                 </a>
                 <ul class="submenu navbar-nav">
                     <li class="nav-item">
                         <a class="nav-link text-white " href="{{ route('dashboard-smart-pica') }}" id="dahsboardPica">
                             <div class="text-white text-center d-flex align-items-center justify-content-center">
                             </div>
                             <span class="nav-link-text">Dashboard</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link text-white " href="{{ route('add-smart-pica') }}" id="dahsboardPica">
                             <div class="text-white text-center d-flex align-items-center justify-content-center">
                             </div>
                             <span class="nav-link-text">Add Pica</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link text-white " href="{{ route('dashboard-update-progress-smartpica') }}"
                             id="progressPica">
                             <div class="text-white text-center d-flex align-items-center justify-content-center">
                             </div>
                             <span class="nav-link-text">Update Progress</span>
                         </a>
                     </li>
                 </ul>
             </li>
             <li class="nav-item">
                 <a class="nav-link text-white active bg-gradient-primary" href="#" id="menuSHE">
                     <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                         <i class="fa fa-sitemap"></i>
                     </div>
                     <span class="nav-link-text ms-1">SHE</span>
                 </a>
                 <ul class="submenu navbar-nav">
                     <li class="nav-item">
                         <a class="nav-link text-white " href="{{ route('bss-form-she-019B') }}" id="dahsboardPica">
                             <div class="text-white text-center d-flex align-items-center justify-content-center">
                             </div>
                             <span class="nav-link-text">Fatigue Check</span>
                         </a>
                     </li>

                 </ul>
             </li>
             <li class="nav-item">
                 <a class="nav-link text-white active bg-gradient-primary" href="#" id="menuIC">
                     <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                         <i class="fa fa-sitemap"></i>
                     </div>
                     <span class="nav-link-text ms-1">Intellectual Capital</span>
                 </a>
                 <ul class="submenu navbar-nav">
                     <li class="nav-item">
                         <a class="nav-link text-white " href="{{ route('bss-dahboard-ic-induksi-karyawan') }}"
                             id="dashboardICInduksiKaryawan">
                             <div class="text-white text-center d-flex align-items-center justify-content-center">
                             </div>
                             <span class="nav-link-text">Dashboard Induksi Karyawan</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link text-white " href="{{ route('bss-form-ic-induksi-karyawan') }}"
                             id="dashboardICInduksiKaryawan">
                             <div class="text-white text-center d-flex align-items-center justify-content-center">
                             </div>
                             <span class="nav-link-text">Add Induksi Karyawan</span>
                         </a>
                     </li>
                 </ul>
             </li>

             <li class="nav-item">
                 <a class="nav-link text-white active bg-gradient-primary" href="#" id="menuSM">
                     <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                         <i class="fa fa-sitemap"></i>
                     </div>
                     <span class="nav-link-text ms-1">SM</span>
                 </a>
                 <ul class="submenu navbar-nav">
                     <li class="nav-item">
                         <a class="nav-link text-white " href="{{ route('dashboard-form-sm') }}" id="form-asset-request-nav">
                             <div class="text-white text-center d-flex align-items-center justify-content-center">
                             </div>
                             <span class="nav-link-text">Dashboard</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link text-white " href="{{ route('form-asset-request') }}" id="form-asset-request-nav">
                             <div class="text-white text-center d-flex align-items-center justify-content-center">
                             </div>
                             <span class="nav-link-text">Form Asset Request</span>
                         </a>
                     </li>
                 </ul>
             </li>

             <li class="nav-item">
                 <a class="nav-link text-white active bg-gradient-primary" href="#" id="menuPLANT">
                     <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                         <i class="fa fa-sitemap"></i>
                     </div>
                     <span class="nav-link-text ms-1">PLANT</span>
                 </a>
                 <ul class="submenu navbar-nav">
                     <li class="nav-item">
                         <a class="nav-link text-white " href="{{ route('bss-form-plant-transmission') }}" id="form-asset-request-nav">
                            <span class="nav-link-text">Form Transmission Test</span>
                         </a>
                     </li>
                 </ul>
             </li>

             <li class="nav-item">
                <a class="nav-link text-white active bg-gradient-primary" href="#" id="menuProduksi">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-sitemap"></i>
                    </div>
                    <span class="nav-link-text ms-1">Produksi</span>
                </a>
                <ul class="submenu navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white " href="{{ route('bss-form-prod-timesheet') }}" id="dashboard-timesheet-produksi">
                            <div class="text-white text-center d-flex align-items-center justify-content-center">
                            </div>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white " href="{{ route('form-timesheet-produksi') }}" id="form-timesheet-produksi">
                            <div class="text-white text-center d-flex align-items-center justify-content-center">
                            </div>
                            <span class="nav-link-text">Timesheet Produksi</span>
                        </a>
                    </li>
                </ul>
            </li>
        -->
         </ul>

     </div>
     <div class="sidenav-footer position-absolute w-100 bottom-0 ">
     </div>
 </aside>
