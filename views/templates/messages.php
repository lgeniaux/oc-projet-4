<section class="mx-auto grid min-h-[780px] max-w-screen-xl grid-cols-[310px_1fr] bg-stone-100 px-6 pb-10">
    <aside class="bg-white">
        <div class="px-8 py-16">
            <h1 class="text-3xl font-serif">Messagerie</h1>
        </div>

        <?php if (empty($conversations)): ?>
            <p class="px-8 text-sm text-stone-400">Aucune conversation pour le moment.</p>
        <?php else: ?>
            <div>
                <?php foreach ($conversations as $conversation): ?>
                    <?php
                    $otherUserId = (int) $conversation['other_user_id'];
                    $otherUsername = Utils::safe($conversation['other_username']);
                    $otherImage = trim((string) $conversation['other_profile_image']);
                    $lastContent = Utils::safe($conversation['content']);
                    $lastDate = new DateTime($conversation['created_at']);
                    $isActive = $selectedUser !== null && $selectedUser->getId() === $otherUserId;
                    $unreadCount = (int) $conversation['unread_count'];
                    $conversationClasses = $isActive ? 'bg-stone-100' : 'bg-white';
                    ?>

                    <a class="flex gap-3 px-8 py-5 <?= $conversationClasses ?>" href="index.php?action=messages&user=<?= $otherUserId ?>">
                        <?php if ($otherImage !== ''): ?>
                            <img class="h-12 w-12 rounded-full object-cover" src="<?= Utils::safe($otherImage) ?>" alt="Photo de <?= $otherUsername ?>">
                        <?php else: ?>
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-stone-200 font-bold text-stone-500">
                                <?= strtoupper(substr($otherUsername, 0, 1)) ?>
                            </span>
                        <?php endif; ?>

                        <span class="min-w-0 flex-1">
                            <span class="mb-1 flex items-center justify-between gap-3">
                                <span class="font-medium text-stone-700"><?= $otherUsername ?></span>
                                <span class="text-xs text-stone-600"><?= $lastDate->format('H:i') ?></span>
                            </span>
                            <span class="block truncate text-sm text-stone-400"><?= $lastContent ?></span>
                        </span>

                        <?php if ($unreadCount > 0): ?>
                            <span class="mt-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-stone-900 px-1 text-xs text-white">
                                <?= $unreadCount ?>
                            </span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </aside>

    <div class="flex min-h-[780px] flex-col px-11 py-9">
        <?php if ($selectedUser === null): ?>
            <div class="flex flex-1 items-center justify-center text-stone-400">
                Sélectionnez une conversation.
            </div>
        <?php else: ?>
            <?php $selectedUsername = Utils::safe($selectedUser->getUsername()); ?>

            <header class="flex items-center gap-4 font-bold text-stone-700">
                <?php if ($selectedUserImage !== ''): ?>
                    <img class="h-12 w-12 rounded-full object-cover" src="<?= Utils::safe($selectedUserImage) ?>" alt="Photo de <?= $selectedUsername ?>">
                <?php else: ?>
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-stone-200 font-bold text-stone-500">
                        <?= strtoupper(substr($selectedUsername, 0, 1)) ?>
                    </span>
                <?php endif; ?>
                <span><?= $selectedUsername ?></span>
            </header>

            <?php if ($error !== null): ?>
                <div class="mt-6 rounded border border-red-600 bg-red-50 p-4 text-red-800">
                    <?= Utils::safe($error) ?>
                </div>
            <?php endif; ?>

            <div class="flex flex-1 flex-col justify-end gap-8 py-12">
                <?php if (empty($messages)): ?>
                    <p class="mb-auto mt-20 text-center text-sm text-stone-400">
                        Aucun message avec <?= $selectedUsername ?> pour le moment.
                    </p>
                <?php else: ?>
                    <?php foreach ($messages as $message): ?>
                        <?php
                        $isSentByCurrentUser = $message->getSenderId() === $currentUserId;
                        $messageDate = new DateTime($message->getCreatedAt());
                        $messageContent = Utils::safe($message->getContent());
                        ?>

                        <?php if ($isSentByCurrentUser): ?>
                            <div class="ml-auto max-w-[70%] text-right">
                                <p class="mb-2 text-xs text-stone-400"><?= $messageDate->format('d.m H:i') ?></p>
                                <p class="rounded bg-blue-50 px-5 py-3 text-left text-sm text-stone-700">
                                    <?= $messageContent ?>
                                </p>
                            </div>
                        <?php else: ?>
                            <div class="mr-auto flex max-w-[70%] items-start gap-2">
                                <?php if ($selectedUserImage !== ''): ?>
                                    <img class="mt-6 h-6 w-6 rounded-full object-cover" src="<?= Utils::safe($selectedUserImage) ?>" alt="Photo de <?= $selectedUsername ?>">
                                <?php else: ?>
                                    <span class="mt-6 flex h-6 w-6 items-center justify-center rounded-full bg-stone-200 text-xs font-bold text-stone-500">
                                        <?= strtoupper(substr($selectedUsername, 0, 1)) ?>
                                    </span>
                                <?php endif; ?>
                                <div>
                                    <p class="mb-2 text-xs text-stone-400"><?= $messageDate->format('d.m H:i') ?></p>
                                    <p class="rounded bg-white px-5 py-3 text-sm text-stone-700">
                                        <?= $messageContent ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <form class="flex gap-5" method="post" action="index.php?action=messages&user=<?= $selectedUser->getId() ?>">
                <input
                    class="peer flex-1 rounded bg-white px-10 py-4 text-sm outline-none placeholder:text-stone-400"
                    type="text"
                    name="content"
                    placeholder="Tapez votre message ici"
                    required
                >
                <button
                    class="rounded bg-green-600 px-9 py-4 font-bold text-white peer-invalid:cursor-not-allowed peer-invalid:bg-stone-300"
                    type="submit"
                >
                    Envoyer
                </button>
            </form>
        <?php endif; ?>
    </div>
</section>
