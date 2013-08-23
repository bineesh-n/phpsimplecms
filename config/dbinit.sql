
CREATE TABLE ARTICLE (
                        ID INT PRIMARY KEY AUTO_INCREMENT,
                        ACTIVITY INT NOT NULL,
                        TITLE VARCHAR(80) NOT NULL,
                        AUTHOR VARCHAR(50),
                        PHOTOURL TEXT NOT NULL,
                        CONTENT TEXT NOT NULL
                     );

CREATE TABLE ACTIVITY (
                        ID INT PRIMARY KEY AUTO_INCREMENT,
                        NAME VARCHAR(35) NOT NULL,
                        DESCRIPTION VARCHAR(60) NOT NULL
                      );

CREATE TABLE CONTACT (
                        ID INT PRIMARY KEY AUTO_INCREMENT,
                        NAME VARCHAR(50) NOT NULL,
                        DEPARTMENT VARCHAR(80),
                        NO BIGINT NOT NULL
                     );

CREATE TABLE GALLERY (
                        ID INT PRIMARY KEY AUTO_INCREMENT,
                        ITEM VARCHAR(35) NOT NULL,
                        DESCRIPTION VARCHAR(60)
                     );

CREATE TABLE GPICS (
                    ID INT PRIMARY KEY AUTO_INCREMENT,
                    GID INT NOT NULL,
                    URL TEXT NOT NULL,
                    TITLE VARCHAR(40) NOT NULL,
                    DESCRIPTION VARCHAR(255)
                  );

CREATE TABLE ADMIN (
                    UNAME VARCHAR(20) NOT NULL PRIMARY KEY,
                    PASSWORD VARCHAR(32) NOT NULL,
                    EMAIL VARCHAR(255) NOT NULL
                    );

INSERT INTO ADMIN (UNAME, PASSWORD, EMAIL)
            VALUES('admin','e7f072dee282c53df52a284131201e16','bineesh37@gmail.com');

