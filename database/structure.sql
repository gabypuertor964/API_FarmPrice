/* === CREATE DATABASE ===*/
    CREATE DATABASE api_farmprice;
    USE api_farmprice;
--

/* === CREATE TABLES === */

    /*
        Table Name: doc_types
        Category: Strong Table

        Description (Spanish): Tipos de documento disponibles
    */
        CREATE TABLE doc_types(
            id int primary key auto_increment,
            name varchar(30) unique not null,
            initials varchar(5) unique not null
        );

    /*
        Table Name: genders
        Category: Strong Table

        Description (Spanish): Generos (Binarios) disponibles
    */
        CREATE TABLE genders(
            id int primary key auto_increment,
            name varchar(10) unique not null
        );

    /*
        Table Name: roles
        Category: Strong Table

        Description (Spanish): Roles registrados en el sistema
    */
        CREATE TABLE roles(
            id int primary key auto_increment,
            name varchar(50) unique not null
        );

    /*
        Table Name: users
        Category: Weak Table

        Description (Spanish): Usuarios registrados en el sistema
    */
        CREATE TABLE users(
            id int primary key auto_increment,
            id_role int not null,
            name varchar(50) unique not null,
            id_gender int not null,
            date_birth date not null,
            id_doc_typ int not null,
            doc_num varchar(20) unique not null,
            email varchar(255) unique not null,
            password_hash varchar(255) unique not null,
            token varchar(255) unique not null
        );

    /*
        Table Name: companies
        Category: Strong Table

        Description (Spanish): Empresas registradas en el sistema
    */
        CREATE TABLE companies(
            id int primary key auto_increment,
            id_user int not null,
            name varchar(50) unique not null,
            nit varchar(9) unique not null
        );

    /*
        Table Name: points_sale
        Category: Weak Table

        Description (Spanish): Puntos de venta asociados a las empresas
    */
        CREATE TABLE points_sale(
            id int primary key auto_increment,
            id_company int not null,
            address text unique not null
        );

    /*
        Table Name: days
        Category: Strong Table

        Description (Spanish): Dias de calendario
    */
        CREATE TABLE days(
            id int primary key auto_increment,
            name varchar(10) unique not null
        );

    /*
        Table Name: schedules
        Category: Weak Table

        Description (Spanish): Horarios x dia de los puntos de venta
    */
        CREATE TABLE schedules(
            id int primary key auto_increment,
            id_point int not null,
            id_day int not null,
            opening_time time not null,
            closing_time time not null
        );

    /*
        Table Name: categories
        Category: Strong Table

        Description (Spanish): Categorias registradas en el aplicativo
    */
        CREATE TABLE categories(
            id int primary key auto_increment,
            name varchar(60) unique not null
        );

    /*
        Table Name: meters
        Category: Strong Table

        Description (Spanish): Metricas registradas en el sistema
    */
        CREATE TABLE meters(
            id int primary key auto_increment,
            name varchar(60) unique not null,
            symbol varchar(4) unique not null
        );

    /*
        Table Name: products
        Category: Weak Table

        Description (Spanish): Productos registrados en el sistema
    */
        CREATE TABLE products(
            id int primary key auto_increment,
            id_company int not null,
            id_category int not null,
            name varchar(100) unique not null,
            id_meter int not null
        );

    /*
        Table Name: product_point
        Category: Weak Table

        Description (Spanish): Productos asociados al punto de venta
    */
        CREATE TABLE product_point(
            id int primary key auto_increment,
            id_product int not null,
            id_point int not null,
            cost_meter int not null
        );

    /*
        Table Name: reviews
        Category: Weak Table

        Description (Spanish): Reviews o reseñas de un producto en un punto especifico
    */
        CREATE TABLE reviews(
            id int primary key auto_increment,
            id_product int not null,
            id_user int not null,
            review varchar(255) not null
        );

    /*
        Table Name: report_types
        Category: Strong Table

        Description (Spanish): Tipos de reporte registrados en el sistema
    */
        CREATE TABLE report_types(
            id int primary key auto_increment,
            name varchar(255) unique not null
        );

    /*
        Table Name: reports
        Category: Weak Table

        Description (Spanish): Reportes de un producto asociado a un punto de venta
    */
        CREATE TABLE reports(
            id int primary key auto_increment,
            id_type int not null,
            id_product int not null,
            id_user int not null,
            report varchar(255) not null
        );
--

/* === CREATE FOREIGN KEYS === */

    /* Users Table */
        ALTER TABLE users ADD FOREIGN KEY(id_role) REFERENCES roles(id) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE users ADD FOREIGN KEY(id_gender) REFERENCES genders(id) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE users ADD FOREIGN KEY(id_doc_typ) REFERENCES doc_types(id) ON DELETE CASCADE ON UPDATE CASCADE;
    --

    /* Companies Table */
        ALTER TABLE companies ADD FOREIGN KEY(id_user) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;
    --

    /* Points Sale Table */
        ALTER TABLE points_sale ADD FOREIGN KEY(id_company) REFERENCES companies(id) ON DELETE CASCADE ON UPDATE CASCADE;
    --

    /* Schedules Table */
        ALTER TABLE schedules ADD FOREIGN KEY(id_point) REFERENCES points_sale(id) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE schedules ADD FOREIGN KEY(id_day) REFERENCES days(id) ON DELETE CASCADE ON UPDATE CASCADE;
    --

    /* Products Table */
        ALTER TABLE products ADD FOREIGN KEY(id_company) REFERENCES companies(id) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE products ADD FOREIGN KEY(id_category) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE products ADD FOREIGN KEY(id_meter) REFERENCES meters(id) ON DELETE CASCADE ON UPDATE CASCADE;
    --

    /* Product Point Table */
        ALTER TABLE product_point ADD FOREIGN KEY(id_product) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE product_point ADD FOREIGN KEY(id_point) REFERENCES points_sale(id) ON DELETE CASCADE ON UPDATE CASCADE;
    --

    /* Reviews Table */
        ALTER TABLE reviews ADD FOREIGN KEY(id_product) REFERENCES product_point(id) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE reviews ADD FOREIGN KEY(id_user) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;
    --

    /* Report Table */
        ALTER TABLE reports ADD FOREIGN KEY(id_type) REFERENCES report_types(id) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE reports ADD FOREIGN KEY(id_product) REFERENCES product_point(id) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE reports ADD FOREIGN KEY(id_user) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;
    --
--