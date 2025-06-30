<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-graduation-cap"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Wisuda App</div>
  </a>

  <hr class="sidebar-divider my-0" />

  <!-- Nav Item - Dashboard -->

  @auth
    @if(auth()->user()->role === 'superadmin')
      <li class="nav-item @if(request()->is('superadmin/validasi')) active @endif">
        <a class="nav-link" href="{{ route('superadmin.validasi.index') }}">
          <i class="fas fa-graduation-cap"></i>
          <span>Siap Wisuda</span>
        </a>
      </li>
    @endif
    @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'bendahara')
      <li class="nav-item @if(request()->is('superadmin/users')) active @endif">
        <a class="nav-link" href="{{ route('users.index') }}">
          <i class="fas fa-users-cog"></i>
          <span>Manage Users</span>
        </a>
      </li>
    @endif


    @if(auth()->user()->role === 'mahasiswa')
      <li class="nav-item @if(request()->is('mahasiswa/wisuda')) active @endif">
        <a class="nav-link" href="{{ route('mahasiswa.wisuda.index') }}">
          <i class="fas fa-file-alt"></i>
          <span>Input Bukti Wisuda</span>
        </a>
      </li>
    @endif

    @if(auth()->user()->role === 'bendahara'||auth()->user()->role === 'superadmin')
      <li class="nav-item @if(request()->is('bendahara/wisuda')) active @endif">
        <a class="nav-link" href="{{ route('bendahara.wisuda.index') }}">
          <i class="fas fa-dollar-sign"></i>
          <span>Validasi Pembayaran</span>
        </a>
      </li>
    @endif

    @if(auth()->user()->role === 'admin_perpus'||auth()->user()->role === 'superadmin' )
      <li class="nav-item @if(request()->is('adminperpus/wisuda')) active @endif">
        <a class="nav-link" href="{{ route('adminperpus.wisuda.index') }}">
          <i class="fas fa-book"></i>
          <span>Validasi Perpustakaan</span>
        </a>
      </li>
    @endif
  @endauth

  <hr class="sidebar-divider d-none d-md-block" />

</ul>
