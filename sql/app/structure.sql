CREATE TABLE account
(
    id       INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    username TEXT NOT NULL,
    mail     TEXT NOT NULL,
    salt     TEXT NOT NULL,
    password TEXT NOT NULL,
    avatar  TEXT NOT NULL DEFAULT 'placeholder.jpg'
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

CREATE TYPE mfa_type AS ENUM ('phone', 'mail');
CREATE TABLE mfa
(
    id         INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    account_id INT      NOT NULL,
    type       mfa_type NOT NULL,
    value      TEXT     NOT NULL,

    FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE
);