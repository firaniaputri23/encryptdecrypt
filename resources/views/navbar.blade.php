<nav class="navbar navbar-expand-lg navbar-dark bg-gradient fixed-top" style="background: linear-gradient(135deg, #0d0d0d, #1a1a1a);">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto fw-semibold">
                @guest
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>
                @endguest
                
                @auth
                @if(!is_null($aess) && count($aess) < 1)
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('home/create') ? 'active' : '' }}" aria-current="page" href="/home/create">Upload</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('home/edit') ? 'active' : '' }}" aria-current="page" href="/home/edit">Update</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="/home">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Log Out</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .nav-link {
        transition: color 0.3s ease, background-color 0.3s ease;
    }
    .nav-link:hover {
        color: #ffc107; /* Change link color on hover */
    }
    .active {
        border-bottom: 2px solid #ffc107; /* Underline active link */
        color: #ffc107; /* Active link color */
    }
</style>
