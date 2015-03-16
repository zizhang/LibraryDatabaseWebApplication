CREATE TABLE BorrowerType
(
type VARCHAR(255) NOT NULL,
bookTimeLimit NUMBER NOT NULL,
PRIMARY KEY (type)
);

CREATE TABLE Borrower
(
bid VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
name VARCHAR(255),
address VARCHAR(255),
phone VARCHAR(255),
emailAddress VARCHAR(255),
sinOrStNo VARCHAR(255) UNIQUE,
expiryDate DATE,
type VARCHAR(255) NOT NULL,
PRIMARY KEY (bid),
FOREIGN KEY (type) REFERENCES BorrowerType
);

CREATE TABLE Book
(
callNumber VARCHAR(255) NOT NULL,
isbn VARCHAR(255),
title VARCHAR(255),
mainAuthor VARCHAR(255),
publisher VARCHAR(255),
year NUMBER,
PRIMARY KEY (callNumber)
);

CREATE TABLE HasAuthor
(
callNumber VARCHAR(255) NOT NULL,
name VARCHAR(255) NOT NULL,
PRIMARY KEY (callNumber, name),
FOREIGN KEY (callNumber) REFERENCES Book
);

CREATE TABLE HasSubject
(
callNumber VARCHAR(255) NOT NULL,
subject VARCHAR(255) NOT NULL,
PRIMARY KEY (callNumber, subject),
FOREIGN KEY (callNumber) REFERENCES Book
);

CREATE TABLE BookCopy
(
callNumber VARCHAR(255) NOT NULL,
copyNo NUMBER NOT NULL,
status VARCHAR(7),
PRIMARY KEY (callNumber, copyNo),
FOREIGN KEY (callNumber) REFERENCES Book,
CONSTRAINT check_status CHECK(status='in' OR status='out' OR status='on-hold')
);

CREATE TABLE HoldRequest
(
hid VARCHAR(255) NOT NULL,
bid VARCHAR(255) NOT NULL,
callNumber VARCHAR(255) NOT NULL,
issuedDate DATE,
PRIMARY KEY (hid),
FOREIGN KEY (bid) REFERENCES Borrower (bid),
FOREIGN KEY (callNumber) REFERENCES Book
);

CREATE TABLE Borrowing
(
borid VARCHAR(255) NOT NULL,
bid VARCHAR(255) NOT NULL,
callNumber VARCHAR(255) NOT NULL,
copyNo NUMBER NOT NULL,
outDate DATE,
inDate DATE,
dueDate DATE,
PRIMARY KEY (borid),
FOREIGN KEY (bid) REFERENCES Borrower,
FOREIGN KEY (callNumber, copyNo) REFERENCES BookCopy
);

CREATE TABLE Fine
(
fid VARCHAR(255) NOT NULL,
amount FLOAT,
issuedDate DATE,
paidDate DATE,
borid VARCHAR(255) NOT NULL,
PRIMARY KEY (fid),
FOREIGN KEY (borid) REFERENCES Borrowing
);

INSERT INTO BorrowerType VALUES('Student', 2);
INSERT INTO BorrowerType VALUES('Faculty', 12);
INSERT INTO BorrowerType VALUES('Staff', 6);
INSERT INTO BorrowerType VALUES('Public', 2);
 