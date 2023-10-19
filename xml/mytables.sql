

CREATE TABLE debit_notes (

    id INT NOT NULL AUTO_INCREMENT,
    id_invoice INT(11) NOT NULL,
    note_number VARCHAR(50) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    xml_document TEXT,

    PRIMARY KEY (id),
    FOREIGN KEY (id_invoice) REFERENCES invoices(id)

);

CREATE TABLE operations (

    id INT NOT NULL AUTO_INCREMENT,
    id_invoice INT NOT NULL,
    id_debit_note INT NOT NULL,
    id_uploaded_by INT NOT NULL,
    id_client INT NOT NULL,
    id_provider INT NOT NULL,
    operation_number VARCHAR(50) NOT NULL,
    creation_date DATE,
    payment_date DATE,
    entry_money DECIMAL(10, 2),
    exit_money DECIMAL(10, 2),
    status VARCHAR(255),

    PRIMARY KEY (id),
    FOREIGN KEY (id_invoice) REFERENCES invoices(id),
    FOREIGN KEY (id_debit_note) REFERENCES debit_notes(id)

);
