CREATE TABLE account
(
    id       INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    username TEXT NOT NULL,
    mail     TEXT NOT NULL,
    salt     TEXT NOT NULL,
    password TEXT NOT NULL,
    avatar   TEXT NOT NULL DEFAULT 'placeholder.jpg',

    CONSTRAINT unique_mail UNIQUE (mail),
    CONSTRAINT unique_username UNIQUE (username)
);

CREATE TABLE vault
(
    id         INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    account_id INT  NOT NULL,
    name       TEXT NOT NULL,
    username   TEXT NOT NULL,
    password   TEXT NOT NULL,
    date       TIMESTAMP DEFAULT CURRENT_DATE,

    FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE
);

CREATE TABLE mfa
(
    account_id INT  NOT NULL PRIMARY KEY,
    enabled    BOOL NOT NULL DEFAULT FALSE,

    FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE
);