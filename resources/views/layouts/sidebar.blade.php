<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-graduation-cap"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Wisuda App</div>
  </a>

  <hr class="sidebar-divider my-0" />

  @auth

    {{-- ========================================================= --}}
    {{-- SUPERADMIN --}}
    {{-- ========================================================= --}}

    @if(auth()->user()->role === 'superadmin')

      {{-- YUDISIUM --}}
      <li class="nav-item
        @if(request()->is('superadmin/yudisium/*')) active @endif">

        <a class="nav-link collapsed"
           href="#"
           data-toggle="collapse"
           data-target="#collapseYudisium"
           aria-expanded="false"
           aria-controls="collapseYudisium">

          <i class="fas fa-file-alt"></i>
          <span>Yudisium</span>
        </a>

        <div id="collapseYudisium"
             class="collapse
             @if(request()->is('superadmin/yudisium/*')) show @endif"
             aria-labelledby="headingYudisium"
             data-parent="#accordionSidebar">

          <div class="bg-white py-2 collapse-inner rounded">

            <h6 class="collapse-header">
              Validasi Yudisium:
            </h6>

            {{-- Validasi Keuangan --}}
            <a class="collapse-item
              @if(request()->is('superadmin/yudisium/keuangan')) active @endif"
              href="{{ route('superadmin.yudisium.keuangan') }}">

              <i class="fas fa-money-bill-wave mr-2"></i>
              Validasi Keuangan
            </a>

            {{-- Validasi Perpus --}}
          <a class="collapse-item 
            @if(request()->is('superadmin/yudisium/perpustakaan')) active @endif"
            href="{{ route('superadmin.yudisium.perpustakaan') }}">

            <i class="fas fa-book mr-2"></i> 
            Validasi Perpus

          </a>

           {{-- Siap Yudisium --}}
          <a class="collapse-item
            @if(request()->is('superadmin/yudisium/siap')) active @endif"
            href="{{ route('superadmin.yudisium.siap') }}">

            <i class="fas fa-graduation-cap mr-2"></i>
            Siap Yudisium

          </a>

          </div>

        </div>

      </li>


{{-- ========================================================= --}}
{{-- WISUDA --}}
{{-- ========================================================= --}}

<li class="nav-item
  @if(request()->is('superadmin/wisuda/*')) active @endif">

  <a class="nav-link collapsed"
     href="#"
     data-toggle="collapse"
     data-target="#collapseWisuda"
     aria-expanded="false"
     aria-controls="collapseWisuda">

    <i class="fas fa-graduation-cap"></i>
    <span>Wisuda</span>

  </a>

  <div id="collapseWisuda"
       class="collapse
       @if(request()->is('superadmin/wisuda/*')) show @endif"
       aria-labelledby="headingWisuda"
       data-parent="#accordionSidebar">

    <div class="bg-white py-2 collapse-inner rounded">

      <h6 class="collapse-header">
        Validasi Wisuda:
      </h6>

      {{-- Validasi Keuangan --}}
      <a class="collapse-item
        @if(request()->is('superadmin/wisuda/keuangan')) active @endif"
        href="{{ route('superadmin.wisuda.keuangan') }}">

        <i class="fas fa-money-bill-wave mr-2"></i>
        Validasi Keuangan

      </a>

      {{-- Validasi Perpustakaan --}}
      <a class="collapse-item
        @if(request()->is('superadmin/wisuda/perpustakaan')) active @endif"
        href="{{ route('superadmin.wisuda.perpustakaan') }}">

        <i class="fas fa-book mr-2"></i>
        Validasi Perpus

      </a>

      {{-- Siap Wisuda --}}
      <a class="collapse-item 
        @if(request()->is('superadmin/wisuda/siap')) active @endif"
        href="{{ route('superadmin.wisuda.siap') }}">

        <i class="fas fa-check-circle mr-2"></i>
        Siap Wisuda

      </a>  

    </div>

  </div>

</li>




      {{-- MANAGE USERS --}}
      <li class="nav-item
        @if(request()->is('superadmin/users*')) active @endif">

        <a class="nav-link"
           href="{{ route('users.index') }}">

          <i class="fas fa-users-cog"></i>
          <span>Manage Users</span>

        </a>

      </li>

      {{-- IJAZAH --}}
      <li class="nav-item
        @if(request()->is('superadmin/ijazah')) active @endif">

        <a class="nav-link"
          href="{{ route('superadmin.ijazah.index') }}">

          <i class="fas fa-id-card"></i>
          <span>Ijazah</span>

        </a>

      </li>

      {{-- SKPI --}}
      <li class="nav-item
        @if(request()->is('superadmin/skpi')) active @endif">

        <a class="nav-link"
          href="{{ route('superadmin.skpi.index') }}">

          <i class="fas fa-file-alt"></i>
          <span>SKPI</span>

        </a>

</li>

    @endif


    {{-- ========================================================= --}}
    {{-- MAHASISWA --}}
    {{-- ========================================================= --}}

    @if(auth()->user()->role === 'mahasiswa')

      {{-- Yudisium --}}
      <li class="nav-item
        @if(request()->is('mahasiswa/yudisium')) active @endif">

        <a class="nav-link"
           href="{{ route('mahasiswa.yudisium.index') }}">

          <i class="fas fa-file-alt"></i>
          <span>Yudisium</span>

        </a>

      </li>


      {{-- Wisuda --}}
      <li class="nav-item
        @if(request()->is('mahasiswa/wisuda')) active @endif">

        <a class="nav-link"
           href="{{ route('mahasiswa.wisuda.index') }}">

          <i class="fas fa-graduation-cap"></i>
          <span>Wisuda</span>

        </a>

      </li>


      {{-- SKPI --}}
      <li class="nav-item
        @if(request()->is('mahasiswa/dokumen')) active @endif">

        <a class="nav-link"
          href="{{ route('mahasiswa.dokumen.index') }}">

          <i class="fas fa-file-alt"></i>
          <span>SKPI</span>

        </a>

      </li>

      {{-- Ijazah --}}
      <li class="nav-item
        @if(request()->is('mahasiswa/ijazah')) active @endif">

        <a class="nav-link"
          href="{{ route('mahasiswa.ijazah.index') }}">

          <i class="fas fa-id-card"></i>
          <span>Ijazah</span>

        </a>

      </li>

    @endif

  @endauth

  <hr class="sidebar-divider d-none d-md-block" />

</ul>
