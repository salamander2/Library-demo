## PATRON

```
CREATE TABLE `patron` (
 `id` int unsigned AUTO_INCREMENT NOT NULL,
 `firstname` varchar(30) NOT NULL,
 `lastname` varchar(30) NOT NULL,
 `address` varchar(255) NOT NULL,
 `city` varchar(100) NOT NULL,
 `prov` varchar(2) NOT NULL,
 `phone` varchar(20) DEFAULT NULL,
 `email` varchar(50) DEFAULT NULL,
 `birthdate` date NOT NULL,
 `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`) 
) ENGINE=InnoDB;
```

```
describe patron;
+------------+--------------+------+-----+-------------------+-------------------+
| Field      | Type         | Null | Key | Default           | Extra             |
+------------+--------------+------+-----+-------------------+-------------------+
| id         | int unsigned | NO   | PRI | NULL              | auto_increment    |
| firstname  | varchar(30)  | NO   |     | NULL              |                   |
| lastname   | varchar(30)  | NO   |     | NULL              |                   |
| address    | varchar(255) | NO   |     | NULL              |                   |
| city       | varchar(100) | NO   |     | NULL              |                   |
| prov       | varchar(2)   | NO   |     | NULL              |                   |
| phone      | varchar(20)  | YES  |     | NULL              |                   |
| email      | varchar(50)  | YES  |     | NULL              |                   |
| birthdate  | date         | NO   |     | NULL              |                   |
| createDate | timestamp    | NO   |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED |
+------------+--------------+------+-----+-------------------+-------------------+
10 rows in set (0.02 sec)
```

##BIB

```
CREATE TABLE `bib`(
`id` int unsigned AUTO_INCREMENT NOT NULL,
`title` varchar(50) NOT NULL,
`author` varchar(50) NOT NULL,
`pub_date` int NOT NULL,
`ISBN` int NOT NULL,
`call_number` varchar(15) DEFAULT NULL,
`subjects` varchar(100) DEFAULT NULL,
`time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY(`id`) 
)ENGINE=InnoDB;
```

```describe bib;
+-------------+--------------+------+-----+-------------------+-------------------+
| Field       | Type         | Null | Key | Default           | Extra             |
+-------------+--------------+------+-----+-------------------+-------------------+
| id          | int unsigned | NO   | PRI | NULL              | auto_increment    |
| title       | varchar(150) | NO   |     | NULL              |                   |
| author      | varchar(50)  | NO   |     | NULL              |                   |
| pub_date    | int          | NO   |     | NULL              |                   |
| ISBN        | int          | NO   |     | NULL              |                   |
| call_number | varchar(15)  | YES  |     | NULL              |                   |
| subjects    | varchar(200) | YES  |     | NULL              |                   |
| time_stamp  | timestamp    | NO   |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED |
+-------------+--------------+------+-----+-------------------+-------------------+
8 rows in set (0.00 sec)
```
