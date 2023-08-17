/* === Insercion Datos CSV */

    /* Doc Typ Table */
        LOAD DATA LOCAL INFILE "C:/xampp/htdocs/API_FarmPrice/database/CSV/doc_types.csv" INTO TABLE doc_types FIELDS TERMINATED BY ';' LINES TERMINATED BY '\r\n';
    --

    /* Genders Table */
        LOAD DATA LOCAL INFILE 'C:/xampp/htdocs/API_FarmPrice/database/CSV/genders.csv' INTO TABLE genders FIELDS TERMINATED BY ';' LINES TERMINATED BY '\r\n';
    --

    /* Roles Table */
        LOAD DATA LOCAL INFILE 'C:/xampp/htdocs/API_FarmPrice/database/CSV/roles.csv' INTO TABLE roles FIELDS TERMINATED BY ';' LINES TERMINATED BY '\r\n';
    --

    /* Days Table */
        LOAD DATA LOCAL INFILE 'C:/xampp/htdocs/API_FarmPrice/database/CSV/days.csv' INTO TABLE days FIElDS TERMINATED BY ';' LINES TERMINATED BY '\r\n';
    --

    /* Report Types Table */
        LOAD DATA LOCAL INFILE 'C:/xampp/htdocs/API_FarmPrice/database/CSV/report_types.csv' INTO TABLE report_types FIELDS TERMINATED BY ';' LINES TERMINATED BY '\r\n';
    --    
--