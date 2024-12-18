USE consultas;

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    idade INT NOT NULL,
    genero VARCHAR(10) NOT NULL,
    data_consulta DATE NOT NULL,
    descricao TEXT NOT NULL
);