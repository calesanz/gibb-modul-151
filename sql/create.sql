CREATE DATABASE Guestbook;

CREATE TABLE User (
	Id INT not null primary key auto_increment	
	, Username NVARCHAR(100)
	, Password VARCHAR(64)
	, PasswordSalt VARCHAR(64)
	, Email VARCHAR(50)
	
);


CREATE TABLE GuestBookEntry(
	Id INT not null primary key auto_increment
	, Text TEXT
	, CreatedAt DATETIME
	, UserId INT
	
);

CREATE TABLE GuestBookAttachment (
	Id INT not null primary key auto_increment
	, FileUri VARCHAR(255)
	, GuestBookEntryId INT
);



CREATE PROCEDURE usp_CheckLogin(
	 username VARCHAR(50)
	, password VARCHAR(100)
) BEGIN
		SELECT COUNT(*) FROM User WHERE username = username AND password = password;	
		
END;

CREATE PROCEDURE usp_AddUser(
	username VARCHAR(50)
	, password VARCHAR(100)
	, name NVARCHAR(100)
	, email VARCHAR(50)
) BEGIN
		
		INSERT INTO User (username,name,email,password,passowrd_salt)
		VALUES(username,name,email,)
END;

CALL usp_CheckLogin('username','password');

