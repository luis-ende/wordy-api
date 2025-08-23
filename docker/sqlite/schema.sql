PRAGMA foreign_keys = ON;

CREATE TABLE expressions (
    id INTEGER PRIMARY KEY,
    learning_unit_id INTEGER,
    sentence TEXT NOT NULL,
    translation TEXT NOT NULL,
    grammar_type SMALLINT,
    is_learning BOOLEAN NOT NULL,
    learning_updated DATE NOT NULL,
    FOREIGN KEY (learning_unit_id) REFERENCES learning_units(id)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
);

CREATE TABLE learning_units (
    id INTEGER PRIMARY KEY,
    name TEXT NOT NULL
)