## PATRONS

```
CREATE TABLE `patrons` (
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
describe patrons;
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
