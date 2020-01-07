CREATE TABLE USERS(
    usr TEXT PRIMARY KEY,
    psw TEXT,
    eml TEXT
);

CREATE TABLE COMMENTS(
    comment TEXT,
    aid TEXT,
    author TEXT
);