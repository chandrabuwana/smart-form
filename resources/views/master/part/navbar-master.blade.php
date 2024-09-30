<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" id="element-page-position" aria-current="page">
                    Dashboard</li>
            </ol>
            <h6 class="font-weight-bolder mb-0" id="data-page-menu">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline">
                    <label class="form-label">Type here...</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="#" class="nav-link text-body p-0 reset-bg">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item pe-3 d-flex align-items-center">
                    <a href="#" class="nav-link text-body p-0 reset-bg notification-container" id="notification-icon">
                        <i class="fa-solid fa-bell fixed-plugin-button-nav cursor-pointer"></i>
                        <div class="notification {{ count($pica_notification) > 0 ? "notification-exists" : "" }}"></div>
                        <div class="notification-items-container custom-scrollbar" id="notification-item">
                            @if(count($pica_notification) > 0)
                                @foreach($pica_notification as $notif)
                                    <div class="item-notif">
                                        @if($notif->category == "warning")
                                           <i class="fa-solid fa-circle-exclamation" style="color: #facea8; font-size: 18px;padding: 5px 0;"></i>
                                        @elseif($notif->category == "error")
                                            <i class="fa-solid fa-circle-xmark" style="color: #f27474; font-size: 18px;padding: 5px 0;"></i>
                                        @elseif($notif->category == "success")
                                            <i class="fa-solid fa-circle-check" style="color: #a5dc86; font-size: 18px;padding: 5px 0;"></i>
                                        @elseif($notif->category == "question")
                                            <i class="fa-solid fa-circle-question" style="color: #87adbd; font-size: 18px;padding: 5px 0;"></i>
                                        @else
                                            <i class="fa-solid fa-circle-info" style="color: #3fc3ee; font-size: 18px;padding: 5px 0;"></i>
                                        @endif
                                        <div>
                                            <h6 style="margin: 0;">{{ $notif->message }}</h6>
                                            <span style="font-size: smaller;">{{ $notif->created_at }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="m-3">
                                    Belum ada pemberitahuan
                                </div>
                            @endif
                        </div>
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center reset-bg">
                    <a href="#" class="nav-link text-body font-weight-bold px-0 reset-bg">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{ session('username') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
