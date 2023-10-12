CREATE TABLE IF NOT EXISTS compensapay.companies (
    id INT(11) NOT NULL AUTO_INCREMENT,
    legal_name VARCHAR(100) NOT NULL,
    short_name VARCHAR(100) NOT NULL,
    id_type INT(11) NOT NULL,
    rfc VARCHAR(13) NOT NULL,
    id_fiscal INT(11) NOT NULL,
    id_postal_code INT(11) NOT NULL,
    id_country INT(11) NOT NULL,
    address VARCHAR(255) NOT NULL,
    telephone VARCHAR(10) NOT NULL,
    account_clabe VARCHAR(18) NOT NULL,
    id_broadcast_bank INT(11) NOT NULL,
    unique_key VARCHAR(100) NOT NULL,
    created_at INT DEFAULT UNIX_TIMESTAMP() NOT NULL,
    updated_at INT DEFAULT UNIX_TIMESTAMP() NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (rfc),
    CONSTRAINT CHK_telephone CHECK (telephone REGEXP '^[0-9]{10}$'),
    CONSTRAINT CHK_rfc CHECK (rfc REGEXP '^[A-Z0-9]{13}$'),
    CONSTRAINT CHK_accountClabe CHECK (account_clabe REGEXP '^[0-9]{18}$')
) ENGINE = InnoDB;
CREATE TRIGGER before_update_companies
BEFORE UPDATE ON compensapay.companies
FOR EACH ROW
SET NEW.updated_at = UNIX_TIMESTAMP();

CREATE TABLE IF NOT EXISTS compensapay.users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255),
    id_profile INT(11) NOT NULL,
    name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(10) NOT NULL, -- Se espera que contenga exactamente 10 números
    id_question INT(11) NOT NULL,
    answer VARCHAR(255) NOT NULL, -- Puedes ajustar el tamaño según tus necesidades
    id_companie INT(11) NOT NULL,
    manager TINYINT NOT NULL, -- 1 indica que es un manager, 0 indica que no lo es
    unique_key VARCHAR(100) NOT NULL,
    created_at INT DEFAULT UNIX_TIMESTAMP() NOT NULL,
    updated_at INT DEFAULT UNIX_TIMESTAMP() NOT NULL,
    -- Validaciones
    CONSTRAINT CHK_user CHECK (user REGEXP '^[a-zA-Z0-9_]{1,50}$'),  -- Valida que 'user' contenga solo letras, números y guiones bajos, y tenga una longitud máxima de 50 caracteres
    CONSTRAINT CHK_name CHECK (name REGEXP '^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$'), -- Valida que 'name' contenga solo letras, espacios y caracteres especiales
    CONSTRAINT CHK_last_name  CHECK (last_name REGEXP '^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$'), -- Valida que 'last_name' contenga solo letras, espacios y caracteres especiales
    CONSTRAINT CHK_email CHECK (email REGEXP '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'), -- Valida que 'email' sea una dirección de correo electrónico válida
    CONSTRAINT CHK_telephone CHECK (telephone REGEXP '^[0-9]{10}$'), -- Valida que 'telephone' contenga exactamente 10 números
    CONSTRAINT CHK_answer CHECK (answer IS NOT NULL AND LENGTH(answer) <= 255), -- Valida que 'answer' no sea nulo y tenga una longitud máxima de 255 caracteres
    CONSTRAINT CHK_manager CHECK (manager IN (0, 1)) -- Valida que 'manager' sea 0 o 1

);
CREATE TRIGGER before_update_users
BEFORE UPDATE ON compensapay.users
FOR EACH ROW
SET NEW.updated_at = UNIX_TIMESTAMP();
ALTER TABLE users ADD CONSTRAINT `id_companie_values` FOREIGN KEY (`id_companie`) REFERENCES `companies`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;