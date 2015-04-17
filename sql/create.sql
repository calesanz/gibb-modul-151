CREATE DATABASE Guestbook;

CREATE TABLE User (
	Id INT not null primary key auto_increment	
	, Password VARCHAR(64)
	, PasswordSalt VARCHAR(64)
	, Email VARCHAR(50)
	, FullName VARCHAR(100)
	
);


CREATE TABLE GuestBookEntry(
	Id INT not null primary key auto_increment
	, Text TEXT
	, CreatedAt DATETIME
	, UserId INT
	, CONSTRAINT FK_GuestBookEntry_User FOREIGN KEY (UserId) REFERENCES User(Id)
);


CREATE TABLE Attachment (
	Id INT not null primary key auto_increment
	, FileUri VARCHAR(255)
	, GuestBookEntryId INT
	, CONSTRAINT FK_Attachment_GuestBookEntry FOREIGN KEY (GuestBookEntryId) REFERENCES GuestBookEntry(Id)
);



--CREATE PROCEDURE usp_CheckLogin(
--	 username VARCHAR(50)
--	, password VARCHAR(100)
--) BEGIN
--		SELECT COUNT(*) FROM User WHERE username = username AND password = password;	
--		
--END;
--
--CREATE PROCEDURE usp_AddUser(
--	username VARCHAR(50)
--	, password VARCHAR(100)
--	, name NVARCHAR(100)
--	, email VARCHAR(50)
--) BEGIN
--		
--		INSERT INTO User (username,name,email,password,passowrd_salt)
--		VALUES(username,name,email,)
--END;
--
--CALL usp_CheckLogin('username','password');
--
