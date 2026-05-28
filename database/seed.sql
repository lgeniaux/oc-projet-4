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

INSERT INTO books (user_id, title, author, description, status)
VALUES
    (
        1,
        'Le Petit Prince',
        'Antoine de Saint-Exupéry',
        'Un classique poétique et facile à relire.',
        'available'
    ),
    (
        2,
        'Vingt mille lieues sous les mers',
        'Jules Verne',
        'Un roman d’aventure autour du capitaine Nemo.',
        'available'
    );

INSERT INTO messages (sender_id, receiver_id, content)
VALUES
    (1, 2, 'Bonjour Bob, ton livre est-il toujours disponible ?'),
    (2, 1, 'Bonjour Alice, oui il est disponible.');
