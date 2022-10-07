<aside class="hidden w-4/12 -mx-8 lg:block">
    <h2 class="sr-only">Posts filters</h2>
    <section class="px-8">
        <h3 class="mb-4 text-xl font-bold text-gray-700">Authors</h3>
        <div class="flex flex-col max-w-sm px-6 py-4 mx-auto bg-white rounded-lg shadow-md">
            <ul class="-mx-4">
                <?php foreach ($data['authors'] as $author): ?>
                    <li class="flex items-center mb-3"><img
                                src="<?= $author->avatar ?>"
                                alt="avatar"
                                class="object-cover w-10 h-10 mx-4 rounded-full">
                        <p><a href="index.php?action=index&resource=post&author=<?= $author->slug ?>"
                              class="mx-1 font-bold text-gray-700 hover:underline"><?= ucwords($author->name) ?></a>
                            <span class="text-sm font-light text-gray-700">Created <?= $author->posts_count ?> Posts</span>
                        </p>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </section>
    <section class="px-8 mt-10">
        <h3 class="mb-4 text-xl font-bold text-gray-700">Categories</h3>
        <div class="flex flex-col max-w-sm px-4 py-6 mx-auto bg-white rounded-lg shadow-md">
            <ul>

                <?php foreach ($data['categories'] as $category): ?>
                    <li class="mb-3"><a href="index.php?action=index&resource=post&category=<?= $category->slug ?>"
                                        class="mx-1 font-bold text-gray-700 hover:text-gray-600 hover:underline">
                            <?= ucwords($category->name) ?></a> contains <?= $category->posts_count ?> posts
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </section>
    <section class="px-8 mt-10">
        <h3 class="mb-4 text-xl font-bold text-gray-700">Recent Post</h3>
        <div class="flex flex-col max-w-sm px-8 py-6 mx-auto bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-center">
                <?php foreach($data['most_recent_post']->post_categories as $category): ?>
                    <a href="?action=index&resource=post&category=<?= $category->category_slug ?>"
                       class="px-2 py-1 text-sm text-green-100 bg-gray-600 rounded hover:bg-gray-500">
                        <?= ucwords($category->category_name) ?>
                    </a>
                <?php endforeach ?>
            </div>
            <div class="mt-4">
                <a href="index.php?action=show&resource=post&slug=<?= $data['most_recent_post']->post_slug ?>"
                   class="font-bold text-lg font-medium text-gray-700 hover:underline"><?= $data['most_recent_post']->post_title ?></a>
            </div>
            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center"><img
                            src="<?= $data['most_recent_post']->post_author_avatar ?>"
                            alt="avatar"
                            class="object-cover w-8 h-8 rounded-full">
                    <a href="?action=index&resource=post&author=<?= $data['most_recent_post']->post_author_slug ?>"
                       class="font-bold mx-3 text-sm text-gray-700 hover:underline"><?= ucwords($data['most_recent_post']->post_author_name) ?></a>
                </div>
                <span
                        class="text-sm font-light text-gray-600"><?= (new DateTime($data['most_recent_post']->post_published_at))->format('M j, Y') ?></span>
            </div>
        </div>
    </section>
</aside>