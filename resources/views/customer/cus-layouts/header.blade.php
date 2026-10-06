<header class="top-header">
    <div class="logo">MyShop</div>
    <div class="search-wrapper">
        <input type="text" class="search-input" placeholder="Search Here...">
    </div>
    <ul class="nav-links">
        <li><a href="/cus-home">Home</a></li>
        <li>
            <a href="/cus-cart" class="cart-icon-container">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count" id="cart-count">0</span>
            </a>
        </li>
        @if(Auth::check())
        <li>
            <form id="logout-form" action="{{ url('auth/customer/logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; font: inherit;margin-right:10px;">
                    Logout
                </button>
            </form>
        </li>
        @else
            <li><a href="{{ url('auth/login') }}">Login</a></li>
        @endif
    </ul>
</header>

<script>
    function toggleModal() {
        const modal = document.getElementById('logoutModal');
        modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
    }

    function closeModal() {
        document.getElementById('logoutModal').style.display = 'none';
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('logoutModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
