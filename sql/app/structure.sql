CREATE TABLE account
(
    id       INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    username TEXT NOT NULL,
    mail     TEXT NOT NULL,
    password TEXT NOT NULL

);

CREATE TABLE vault
(
    id          INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    account_id  INT  NOT NULL,
    name        TEXT NOT NULL,
    username TEXT NOT NULL,
    password TEXT NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

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