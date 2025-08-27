PRAGMA foreign_keys = ON;

CREATE TABLE languages () {
    id INTEGER PRIMARY KEY,
    language TEXT NOT NULL,
}

CREATE TABLE expressions (
    id INTEGER PRIMARY KEY,
    source_language_id INTEGER NOT NULL,
    target_language_id INTEGER NOT NULL,
    learning_unit_id INTEGER,
    sentence TEXT NOT NULL,
    translation TEXT NOT NULL,
    grammar_type SMALLINT,
    is_learning BOOLEAN NOT NULL,
    learning_updated DATE NOT NULL,
    FOREIGN KEY (learning_unit_id) REFERENCES learning_units(id)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
    FOREIGN KEY (source_language_id) REFERENCES languages(id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (target_language_id) REFERENCES languages(id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE learning_units (
    id INTEGER PRIMARY KEY,
    name TEXT NOT NULL
)

INSERT INTO languages VALUES(1, 'English'),
VALUES(2, 'Spanish'),
VALUES(3, 'German'),
VALUES(4, 'French');