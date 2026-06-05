INSERT INTO users (username, email, password_hash, biography)
VALUES
    (
        'alice',
        'alice@example.com',
        '$2y$10$svfu24ztaLc2fO7p3O.mO.M8y28qVk/oOa73LQ6C4/WhHfk8ir766',
        'Lectrice passionnée de romans.'
    ),
    (
        'bob',
        'bob@example.com',
        '$2y$10$svfu24ztaLc2fO7p3O.mO.M8y28qVk/oOa73LQ6C4/WhHfk8ir766',
        'J’aime partager mes livres préférés.'
    );

INSERT INTO books (user_id, title, author, image, description, status, created_at)
VALUES
    (
        1,
        'Esther',
        'Alabaster',
        'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=600&q=80',
        'Un roman doux à partager.',
        'available',
        '2026-05-28 12:04:00'
    ),
    (
        2,
        'The Kinfolk Table',
        'Nathan Williams',
        'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80',
        'Un beau livre autour de la cuisine et du partage.',
        'available',
        '2026-05-28 12:03:00'
    ),
    (
        1,
        'Wabi Sabi',
        'Beth Kempton',
        'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=600&q=80',
        'Une réflexion simple sur la beauté du quotidien.',
        'available',
        '2026-05-28 12:02:00'
    ),
    (
        2,
        'Milk & Honey',
        'Rupi Kaur',
        'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?auto=format&fit=crop&w=600&q=80',
        'Un recueil de poésie contemporaine.',
        'available',
        '2026-05-28 12:01:00'
    );

INSERT INTO messages (sender_id, receiver_id, content)
VALUES
    (1, 2, 'Bonjour Bob, ton livre est-il toujours disponible ?'),
    (2, 1, 'Bonjour Alice, oui il est disponible mais je le vends 400 balles');
