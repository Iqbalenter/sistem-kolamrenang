<!-- Navigation -->
<nav class="bg-blue-500 shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route('user.dashboard') }}" class="text-white text-xl font-bold">
                    Kolam Renang Kuala Mega
                </a>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-white hidden sm:block">Halo, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        
       
    </div>
</nav>

<!-- Mobile menu toggle button -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create mobile menu toggle button
    const nav = document.querySelector('nav .max-w-7xl .flex.justify-between');
    const mobileMenuButton = document.createElement('button');
    mobileMenuButton.className = 'md:hidden text-white p-2';
    mobileMenuButton.innerHTML = '☰';
    mobileMenuButton.onclick = function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    };
    
    // Insert the button before logout section
    const rightSection = nav.querySelector('.flex.items-center.space-x-4');
    nav.insertBefore(mobileMenuButton, rightSection);
    
    // Hide mobile menu by default
    document.getElementById('mobile-menu').classList.add('hidden');
});
</script> 