<?php $hasSelectedConversation = $selectedUser !== null; ?>

<section class="messages-page <?= $hasSelectedConversation ? 'messages-page--thread-open' : '' ?>">
    <aside class="messages-sidebar">
        <h1 class="messages-title">Messagerie</h1>

        <?php if (empty($conversations)): ?>
            <p class="messages-empty">Aucune conversation pour le moment.</p>
        <?php else: ?>
            <div class="messages-conversation-list">
                <?php foreach ($conversations as $conversation): ?>
                    <?php
                    $otherUserId = (int) $conversation['other_user_id'];
                    $otherUsername = Utils::safe($conversation['other_username']);
                    $otherImage = trim((string) $conversation['other_profile_image']);
                    $lastContent = Utils::safe($conversation['content']);
                    $lastDate = new DateTime($conversation['created_at']);
                    $isActive = $selectedUser !== null && $selectedUser->getId() === $otherUserId;
                    $unreadCount = (int) $conversation['unread_count'];
                    ?>

                    <a class="messages-conversation <?= $isActive ? 'messages-conversation--active' : '' ?>" href="index.php?action=messages&user=<?= $otherUserId ?>">
                        <span class="messages-avatar messages-avatar--large">
                            <?php if ($otherImage !== ''): ?>
                                <img src="<?= Utils::safe($otherImage) ?>" alt="Photo de <?= $otherUsername ?>">
                            <?php else: ?>
                                <?= strtoupper(substr($otherUsername, 0, 1)) ?>
                            <?php endif; ?>
                        </span>

                        <span class="messages-conversation__content">
                            <span class="messages-conversation__top">
                                <span class="messages-conversation__name"><?= $otherUsername ?></span>
                                <span class="messages-conversation__time"><?= $lastDate->format('H:i') ?></span>
                            </span>
                            <span class="messages-conversation__preview"><?= $lastContent ?></span>
                        </span>

                        <?php if ($unreadCount > 0): ?>
                            <span class="messages-unread"><?= $unreadCount ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </aside>

    <div class="messages-thread">
        <?php if ($selectedUser === null): ?>
            <div class="messages-thread-empty">Sélectionnez une conversation.</div>
        <?php else: ?>
            <?php $selectedUsername = Utils::safe($selectedUser->getUsername()); ?>

            <a class="messages-back" href="index.php?action=messages"><span aria-hidden="true">&larr;</span> retour</a>

            <header class="messages-thread-header">
                <span class="messages-avatar messages-avatar--large">
                    <?php if ($selectedUserImage !== ''): ?>
                        <img src="<?= Utils::safe($selectedUserImage) ?>" alt="Photo de <?= $selectedUsername ?>">
                    <?php else: ?>
                        <?= strtoupper(substr($selectedUsername, 0, 1)) ?>
                    <?php endif; ?>
                </span>
                <span><?= $selectedUsername ?></span>
            </header>

            <?php if ($error !== null): ?>
                <div class="messages-alert">
                    <?= Utils::safe($error) ?>
                </div>
            <?php endif; ?>

            <div class="messages-list">
                <?php if (empty($messages)): ?>
                    <p class="messages-empty messages-empty--thread">
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
                            <article class="messages-bubble-row messages-bubble-row--sent">
                                <p class="messages-bubble-date">
                                    <span><?= $messageDate->format('d.m') ?></span>
                                    <span><?= $messageDate->format('H:i') ?></span>
                                </p>
                                <p class="messages-bubble messages-bubble--sent"><?= $messageContent ?></p>
                            </article>
                        <?php else: ?>
                            <article class="messages-bubble-row messages-bubble-row--received">
                                <div class="messages-received-meta">
                                    <span class="messages-avatar messages-avatar--small">
                                        <?php if ($selectedUserImage !== ''): ?>
                                            <img src="<?= Utils::safe($selectedUserImage) ?>" alt="Photo de <?= $selectedUsername ?>">
                                        <?php else: ?>
                                            <?= strtoupper(substr($selectedUsername, 0, 1)) ?>
                                        <?php endif; ?>
                                    </span>

                                    <p class="messages-bubble-date">
                                        <span><?= $messageDate->format('d.m') ?></span>
                                        <span><?= $messageDate->format('H:i') ?></span>
                                    </p>
                                </div>

                                <p class="messages-bubble messages-bubble--received"><?= $messageContent ?></p>
                            </article>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <form class="messages-compose" method="post" action="index.php?action=messages&user=<?= $selectedUser->getId() ?>">
                <input
                    type="text"
                    name="content"
                    aria-label="Message"
                    placeholder="Tapez votre message ici"
                    required
                >
                <button class="btn btn-primary messages-send" type="submit">Envoyer</button>
            </form>
        <?php endif; ?>
    </div>
</section>
