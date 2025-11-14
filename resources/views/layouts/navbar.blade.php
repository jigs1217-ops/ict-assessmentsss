<nav class="navbar navbar-dark bg-dark shadow-sm sticky-top py-1">
  <div class="container-fluid d-flex justify-content-between align-items-center px-3">

    <!-- Brand / Home (STATIC, WHITE) -->
    <div class="navbar-brand text-white d-flex align-items-center">
      <i class="bi bi-pc-display me-2"></i> ICT Assessment
    </div>

    <!-- Desktop Buttons (Compact, Aligned) -->
    <div class="d-none d-lg-flex align-items-center gap-1">
      <a href="{{ url('/dashboard') }}"
         class="btn btn-outline-light btn-sm {{ request()->is('dashboard') ? 'active-btn' : '' }}">
        <i class="bi bi-bar-chart-line me-1"></i> Dashboard
      </a>

      <a href="{{ route('assessment.index') }}"
         class="btn btn-outline-light btn-sm {{ request()->routeIs('assessment.index') ? 'active-btn' : '' }}">
        <i class="bi bi-clipboard2-data me-1"></i> Assessments
      </a>

      <!-- New button now like the other navbar buttons -->
      <a href="{{ route('assessment.create') }}"
         class="btn btn-outline-light btn-sm {{ request()->routeIs('assessment.create') ? 'active-btn' : '' }}">
        <i class="bi bi-plus-circle me-1"></i> New
      </a>

      @auth
        <div class="dropdown d-flex align-items-center">
          <button class="btn btn-outline-light btn-sm dropdown-toggle d-flex align-items-center"
                  type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
            <li>
              <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="bi bi-gear me-2"></i> Profile
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item text-danger" type="submit">
                  <i class="bi bi-box-arrow-right me-2"></i> Log Out
                </button>
              </form>
            </li>
          </ul>
        </div>
      @endauth
    </div>

    <!-- Mobile Dropdown (Hamburger, aligned and styled like desktop buttons) -->
<div class="dropdown d-lg-none d-flex align-items-center">
    <button class="btn btn-outline-light btn-sm d-flex flex-column justify-content-center align-items-center hamburger-btn"
            type="button" id="mobileMenuDropdown"
            data-bs-toggle="dropdown" aria-expanded="false">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
        <li>
          <a class="dropdown-item {{ request()->is('dashboard') ? 'active-btn' : '' }}"
             href="{{ url('/dashboard') }}">
            <i class="bi bi-bar-chart-line me-2"></i> Dashboard
          </a>
        </li>
        <li>
          <a class="dropdown-item {{ request()->routeIs('assessment.index') ? 'active-btn' : '' }}"
             href="{{ route('assessment.index') }}">
            <i class="bi bi-clipboard2-data me-2"></i> Assessments
          </a>
        </li>
        <li>
          <a class="dropdown-item {{ request()->routeIs('assessment.create') ? 'active-btn' : '' }}"
             href="{{ route('assessment.create') }}">
            <i class="bi bi-plus-circle me-2"></i> New
          </a>
        </li>
        @auth
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
              <i class="bi bi-gear me-2"></i> Profile
            </a>
          </li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="dropdown-item text-danger" type="submit">
                <i class="bi bi-box-arrow-right me-2"></i> Log Out
              </button>
            </form>
          </li>
        @endauth
    </ul>
</div>


  </div>
</nav>
