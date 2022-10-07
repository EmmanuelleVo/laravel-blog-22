<header class="px-6 py-4 bg-white shadow">
    <div class="container flex flex-col mx-auto md:flex-row md:items-center md:justify-between">
        <h1 class="flex items-center justify-between">
            <a href="/"
               class="text-xl font-bold text-gray-800 md:text-2xl">My Awesome Blog</a>
        </h1>
        <nav class="flex-col hidden md:flex md:flex-row md:-mx-4">
            <h2 class="sr-only">Main Navigation</h2>
            <a href="/"
               class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Home</a>
            <?php if (!isset($_SESSION['connected_author'])): ?>
                <a href="/?action=login&resource=auth"
                   class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0">Login</a>
            <?php else: ?>
                <a href="/"
                   class="my-1 text-gray-800 hover:text-blue-500 md:mx-4 md:my-0"><?= $_SESSION['connected_author']->name ?></a>
                <form action="/"
                      method="post">
                    <input type="hidden" name="action" value="logout">
                    <input type="hidden" name="resource" value="auth">
                    <button type="submit">Logout</button>
                </form>
            <?php endif; ?>
        </nav>
    </div>
</header>