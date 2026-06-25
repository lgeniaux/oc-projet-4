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
    ),
    (
        1,
        'Le Petit Prince',
        'Antoine de Saint-Exupéry',
        'https://images.unsplash.com/photo-1519682337058-a94d519337bc?auto=format&fit=crop&w=600&q=80',
        'Un classique tendre et poétique.',
        'available',
        '2026-05-28 12:00:00'
    ),
    (
        2,
        '1984',
        'George Orwell',
        'https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=600&q=80',
        'Un roman d’anticipation incontournable.',
        'available',
        '2026-05-28 11:59:00'
    ),
    (
        1,
        'L’Étranger',
        'Albert Camus',
        'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=600&q=80',
        'Un court roman à redécouvrir.',
        'available',
        '2026-05-28 11:58:00'
    ),
    (
        2,
        'Dune',
        'Frank Herbert',
        'https://images.unsplash.com/photo-1511108690759-009324a90311?auto=format&fit=crop&w=600&q=80',
        'Un grand classique de science-fiction.',
        'available',
        '2026-05-28 11:57:00'
    ),
    (
        1,
        'Orgueil et Préjugés',
        'Jane Austen',
        'https://images.unsplash.com/photo-1513001900722-370f803f498d?auto=format&fit=crop&w=600&q=80',
        'Un roman anglais plein d’esprit.',
        'available',
        '2026-05-28 11:56:00'
    ),
    (
        2,
        'Fahrenheit 451',
        'Ray Bradbury',
        'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80',
        'Un récit marquant autour des livres.',
        'available',
        '2026-05-28 11:55:00'
    ),
    (
        1,
        'La Nuit des temps',
        'René Barjavel',
        'https://images.unsplash.com/photo-1524578271613-d550eacf6090?auto=format&fit=crop&w=600&q=80',
        'Une histoire entre science-fiction et romance.',
        'available',
        '2026-05-28 11:54:00'
    ),
    (
        2,
        'Bel-Ami',
        'Guy de Maupassant',
        'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=600&q=80',
        'Un classique réaliste français.',
        'available',
        '2026-05-28 11:53:00'
    ),
    (
        1,
        'Fondation',
        'Isaac Asimov',
        'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=600&q=80',
        'Un cycle majeur de science-fiction.',
        'available',
        '2026-05-28 11:52:00'
    ),
    (
        2,
        'Les Misérables',
        'Victor Hugo',
        'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80',
        'Un grand roman populaire.',
        'available',
        '2026-05-28 11:51:00'
    ),
    (
        1,
        'Germinal',
        'Émile Zola',
        'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=600&q=80',
        'Un roman social puissant.',
        'available',
        '2026-05-28 11:50:00'
    ),
    (
        2,
        'Le Hobbit',
        'J. R. R. Tolkien',
        'https://images.unsplash.com/photo-1528207776546-365bb710ee93?auto=format&fit=crop&w=600&q=80',
        'Une aventure fantastique accessible.',
        'available',
        '2026-05-28 11:49:00'
    );

INSERT INTO messages (sender_id, receiver_id, content)
VALUES
    (1, 2, 'Bonjour Bob, ton livre est-il toujours disponible ?'),
    (2, 1, 'Bonjour Alice, oui il est disponible mais je le vends 400 balles'),
    (1, 2, 'Merci pour ta réponse, je vais regarder les autres livres aussi.'),
    (2, 1, 'Pas de souci, dis-moi si un autre titre t’intéresse.'),
    (1, 2, 'Est-ce que tu es disponible cette semaine pour un échange ?'),
    (2, 1, 'Oui, plutôt jeudi en fin de journée.');
