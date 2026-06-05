Tests
=====

Database setup
--------------

### MySQL, MariaDB

Locally:

```mysql
CREATE USER 'test'@'localhost' IDENTIFIED BY 'test';
GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost' WITH GRANT OPTION;
```

In Docker image:

```mysql
CREATE USER 'test'@'%' IDENTIFIED BY 'test';
GRANT ALL PRIVILEGES ON *.* TO 'test'@'%' WITH GRANT OPTION;
```

### PostgreSQL

In a database `adminneo_test`:

```postgresql
CREATE USER test WITH password 'test';
GRANT ALL ON SCHEMA public TO test;
```

### MS SQL

In a database `adminneo_test`:

```genericsql
CREATE LOGIN test
WITH PASSWORD = '340$Uuxwp7Mcxo7Khy';

CREATE USER test
FOR LOGIN test;

GRANT CONTROL TO test;
```

### Elasticsearch

Tests require access without a password.

### MongoDB

Login with `mongosh` as admin and run:

```json lines
use admin

db.createUser({
  user: "test",
  pwd: "test",
  roles: [{role: "root", db: "admin"}]
})
```
