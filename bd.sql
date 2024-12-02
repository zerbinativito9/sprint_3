/*
Dev: João Pedro de Oliveira - JP
Data: 02/12/2024
Coloquei algumas observações aqui no banco de dados, se der algo errado corre pro fim desse arquivo
*/

-- Expressçao SQL para criar banco de dados
CREATE DATABASE espacopets;

-- Expressão SQL para informar à IDE que este é o banco que estará em uso.
USE espacopets;

-- Expressão SQL para criar a tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Criando a tabela do Dono do Animal (Clientes)
create table Clientes(
	CodCliente int not null primary key auto_increment,
	Cliente varchar(100),
    Telefone varchar(100),
    QtdAnimal int);

create unique index IDX_Cliente
	on Clientes(Cliente);

-- Criando a tabela do animal
create table Animais(
	CodAnimal int not null primary key auto_increment,
    CodCliente int not null,
    Animal varchar(100),
    Raça varchar(100),
    RGA varchar(7),
    Observação text);

-- Havia problemas de repetição. Ajustado
create unique index IDX_Animais
	on Animais(RGA);

-- Adicionando Chave Estrangeira (Relacionamento entre as duas tabelas)    
alter table Animais add constraint FK_Clientes_Animais
	foreign key(CodCliente)references Clientes(CodCliente);

create table Veterinarios(
    CodVeterinario int not null primary key auto_increment,
    Nome varchar(100),
    CRMV varchar(50),
    Telefone varchar(100)
);

create unique index IDX_Veterinario
    on Veterinarios(CRMV);

create table Consulta(
    CodConsulta int not null primary key auto_increment,
    CodAnimal int not null,
    CodVeterinario int not null,
    Exame BIT, 
    DataeHora DATETIME,
    Valor decimal(8, 2),
    Relatorio varchar (500)
);

--Relacionando Consulta aos Veterinarios;
ALTER TABLE Consulta ADD
	CONSTRAINT FK_Veterinarios_Consulta FOREIGN KEY(CodVeterinario)
	REFERENCES Veterinarios(CodConsulta);

--Relacionando Consulta aos animais;
ALTER TABLE Consulta ADD
	CONSTRAINT FK_Animais_Consulta FOREIGN KEY(CodAnimal)
	REFERENCES Animais(CodAnimal);


-- Expressão SQL para cadastrar um usuário
INSERT INTO usuarios (usuario, senha) VALUES ('admin', MD5('admin123'));

-- Obs: Devido a problemas com o bdd foi necessária a mudança para o plural nos tópicos "cliente" e "animal"