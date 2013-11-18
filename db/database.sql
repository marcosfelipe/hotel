--DROP DATABASE IF EXISTS hotel;

--CREATE DATABASE hotel;

--\c hotel;

CREATE TABLE enterprises(
	id serial NOT NULL primary key,
	name varchar(50),
	trading_name varchar(50),
	phone char(12),
	phone2 char(12),
	cnpj char(15),
	address varchar(100),
	zip char(8),
	state_registration varchar(30),
	email varchar(50),
	created_at timestamp
);

CREATE TABLE clients (
    id serial NOT NULL primary key,
    name character varying(100),
    cpf character varying(12),
    rg character varying(10),
    enterprise_id integer references enterprises(id) ON DELETE SET NULL,
    birth date,
    created_at timestamp,
    active bool default true
);


CREATE TABLE reasons (
    id serial NOT NULL primary key,
    description text,
    created_at timestamp
);


CREATE TABLE room_types (
    id serial NOT NULL primary key,
    title varchar(40),
    characteristics text,
    price double precision,
    created_at timestamp
);

CREATE TABLE rooms (
    id serial NOT NULL primary key,
    room_type_id integer references room_types(id) ON DELETE SET NULL,
    number smallint,
    floor smallint,
    price double precision,
    description character varying(60),
    created_at timestamp,
    active bool default true
);


CREATE TABLE employees (
    id serial NOT NULL primary key,
    name character varying(100),
    login character varying(100),
    password character varying(50),
    created_at timestamp,
    access int default 0,
    level integer,
    active bool default true
);


CREATE TABLE reservations (
    id serial NOT NULL primary key,
    reason_id integer references reasons(id) ON DELETE SET NULL,
    client_id integer NOT NULL references clients(id) ON DELETE SET NULL,
    room_id integer NOT NULL references rooms(id) ON DELETE SET NULL,
    employee_id integer NOT NULL references employees(id) ON DELETE SET NULL,
    date_reserve timestamp,
    date_prevision timestamp,
    active bool default true,
    created_at timestamp
);

CREATE TABLE accommodations (
    id serial NOT NULL primary key,
    reservation_id integer NOT NULL references reservations(id),
    check_in timestamp,
    check_out timestamp,
    created_at timestamp
);

CREATE TABLE product_types (
    id serial NOT NULL primary key,
    description character varying,
    created_at timestamp
);


CREATE TABLE products (
    id serial NOT NULL primary key,
    product_type_id integer references product_types(id),
    description character varying(100),
    price double precision,
    created_at timestamp
);

CREATE TABLE product_consumptions (
    id serial NOT NULL primary key,
    product_id integer NOT NULL references products(id),
    accommodation_id integer NOT NULL references accommodations(id),
    note text,
    price double precision,
    amount integer,
    created_at timestamp
);

CREATE TABLE contacts (
    id serial NOT NULL primary key,
    name character varying(50),
    email character varying(50),
    content text,
    created_at timestamp
);


CREATE TABLE payment_types (
    id serial NOT NULL primary key,
    description text,
    note text,
    created_at timestamp
);

CREATE TABLE payments (
    id serial NOT NULL primary key,
    payment_type_id integer NOT NULL references payment_types(id),
    accommodation_id integer NOT NULL references accommodations(id),
    created_at timestamp,
    data timestamp,
    price double precision,
    note text
);

CREATE TABLE service_types (
    id serial NOT NULL primary key,
    description text,
    created_at timestamp
);

CREATE TABLE services (
    id serial NOT NULL primary key,
    accommodation_id integer NOT NULL references accommodations(id),
    service_type_id integer references service_types(id),
    note text,
    created_at timestamp
);

CREATE TABLE room_photos (
  id SERIAL NOT NULL PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  type VARCHAR(50) NOT NULL,
  size VARCHAR(50) NOT NULL,
  room_id INTEGER REFERENCES rooms(id) ON DELETE RESTRICT,
  created_at TIMESTAMP
);


