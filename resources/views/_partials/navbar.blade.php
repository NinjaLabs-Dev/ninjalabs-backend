<div class="navbar flex items-center justify-content-between bg-white dark:bg-gray-800">
    <div class="branding mx-4 text-uppercase dark:text-white font-medium">
        <h3>NinjaLabs Development</h3>
    </div>
    <div class="items flex justify-content-end align-items-center mx-4">
        <navbar-options :isadmin="{{ json_encode(Auth::user()->hasRole('admin')) }}" :user="{{ Auth::user() }}"></navbar-options>
    </div>
</div>
