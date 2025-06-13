  <div class="main-sidebar sidebar-style-2">
      <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
              <img src="{{ asset('storage/' . getPengaturan()->logo) }}" width="50px" alt="" class="rounded-circle">
              <a href="{{ route(activeGuard() . '.dashboard') }}">{{ getPengaturan()->nama_aplikasi }}</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
              <img src="{{ asset('storage/' . getPengaturan()->logo) }}" width="40px" alt="" class="rounded-circle">
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="{{ request()->is('admin') ? 'active' : '' }}">
                  <a href="{{ route(activeGuard() . '.dashboard') }}" class="nav-link"><i
                          class="fas fa-fire"></i><span>Dashboard</span></a>
              </li>
              @auth('admin')
                  <li class="menu-header">Data Master</li>
                  <li class="{{ request()->is('admin/ibu') || request()->is('admin/ibu/*') ? 'active' : '' }}">
                      <a href="{{ route('admin.ibu.index') }}" class="nav-link"><i class="fas fa-female"></i>
                          <span>Ibu</span></a>
                  </li>
              @endauth
              <li
                  class="{{ request()->is(activeGuard() . '/kehamilan') || request()->is('admin/kehamilan/*') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route(activeGuard() . '.kehamilan.index') }}"><i
                          class="fas fa-child"></i>
                      <span>Kehamilan</span></a>
              </li>
              @auth('admin')
                  <li class="{{ request()->is('admin/form') || request()->is('admin/form/*') ? 'active' : '' }}">
                      <a href="{{ route('admin.form.index') }}" class="nav-link"><i class="fas fa-align-justify"></i>
                          <span>Form Ibu</span></a>
                  </li>
                  <li class="menu-header">Data Transaksi</li>
                  <li class="{{ request()->is('admin/pelayanan') || request()->is('admin/pelayanan/*') ? 'active' : '' }}">
                      <a href="{{ route('admin.pelayanan.index') }}" class="nav-link "><i class="fas fa-hospital"></i>
                          <span>Pelayanan</span></a>
                  </li>
                  <li class="{{ request()->is('admin/nifas') || request()->is('admin/nifas/*') ? 'active' : '' }}">
                      <a href="{{ route('admin.nifas.index') }}" class="nav-link"><i class="far fa-user"></i>
                          <span>Nifas</span></a>
                  </li>
              @endauth
              @auth('ibu')
                  <li
                      class="{{ request()->is(activeGuard() . 'periksa') || request()->is(activeGuard() . 'periksa/*') ? 'active' : '' }}">
                      <a href="{{ route(activeGuard() . '.periksa.index') }}" class="nav-link"><i
                              class="fas fa-user-check"></i>
                          <span>Periksa Kehamilan (ibu)</span></a>
                  </li>
              @endauth
              <li
                  class="{{ request()->is(activeGuard() . 'rujukan') || request()->is(activeGuard() . 'rujukan/*') ? 'active' : '' }}">
                  <a class="nav-link" href="{{ route(activeGuard() . '.rujukan.index') }}"><i
                          class="fas fa-clipboard"></i>
                      <span>Rujukan</span></a>
              </li>
              <li class="menu-header">Lainnya</li>
              @auth('admin')
                  <li class="{{ request()->is('admin/user') || request()->is('admin/user/*') ? 'active' : '' }}">
                      <a href="{{ route('admin.user.index') }}" class="nav-link"><i class="far fa-user"></i>
                          <span>Pengguna</span></a>
                  </li>
                  <li class="{{ request()->is('admin/pengaturan') || request()->is('admin/pengaturan/*') ? 'active' : '' }}">
                      <a href="{{ route('admin.pengaturan') }}" class="nav-link"><i class="fas fa-cog"></i>
                          <span>Pengaturan</span></a>
                  </li>
              @endauth

              @auth
                  <li
                      class="{{ request()->is(activeGuard() . '/profile') || request()->is(activeGuard() . '/profile/*') ? 'active' : '' }}">
                      <a href="{{ route(activeGuard() . '.profile') }}" class="nav-link"><i class="far fa-user"></i>
                          <span>Profile</span></a>
                  </li>
              </ul>
              <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                  <button onclick="confirmLogout(); event.preventDefault();"
                      class="btn btn-primary btn-lg btn-block btn-icon-split">
                      <i class="fas fa-sign-out-alt"></i> Logout
                  </button>
              </div>
          @endauth
      </aside>
  </div>
