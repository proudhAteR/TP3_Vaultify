CREATE TABLE person
(
    id        INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    firstname TEXT NOT NULL,
    lastname  TEXT NOT NULL
);

CREATE TABLE account
(
    id         INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_person  INT  NOT NULL,
    username   TEXT NOT NULL,
    mail       TEXT NOT NULL,
    password   TEXT NOT NULL,

    FOREIGN KEY (id_person) REFERENCES person (id) ON DELETE CASCADE
);

CREATE TABLE token
(
    hash       VARCHAR(255),
    account_id INT NOT NULL PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE
);

CREATE TYPE mfa_type AS ENUM ('phone', 'mail');
CREATE TABLE mfa
(
    id         INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    account_id INT          NOT NULL,
    type       mfa_type NOT NULL,
    value    TEXT         NOT NULL,

    FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE

);