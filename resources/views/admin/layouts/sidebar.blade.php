<div class="sidebar-logo">
    <img src="images/logo.jpg" width="200px" height="80px" alt="">

  </div>

  <ul class="sidebar-nav">
    <li class="sidebar-item">
      <a href="/home" class="sidebar-link">
        <i class="fas fa-home"></i>
        <span>Home</span>
      </a>
    </li>
    <li class="sidebar-item">
        <a href="/product" class="sidebar-link">
            <i class="fas fa-tags"></i>

          <span>Product</span>
        </a>
      </li>

    <li class="sidebar-item">
      <a href="orders-view" class="sidebar-link">
        <i class="fas fa-box"></i>
        <span>Orders</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="/chats" class="sidebar-link">
        <i class="fas fa-message"></i>
        <span>Chats</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="/setting" class="sidebar-link">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
    </li>
  </ul>

  <div class="sidebar-footer">
    <form id="logout-form" action="{{ url('auth/admin/logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#" class="sidebar-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-right-from-bracket"></i>
        <span>Logout</span>
    </a>
</div>
