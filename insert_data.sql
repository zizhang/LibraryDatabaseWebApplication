insert into Book values ('QA76.12 J34 2000','1686409514865','Blue Bridge','Molly W. Blouin','Pearson',2000);
insert into Book values ('KD15.55 C14 2004','8527393662883','The Black Wind','Peter L. Turner','Reuters',2004);
insert into Book values ('AL41.66 A61 1999','7558664196933','Person of Wife','Dominic A. Flynn','McGraw-Hill Education',1999);
insert into Book values ('QL25.77 F38 1987','6083927584686','The Girlfriends Dragon','Dawn J. Dulac','Reuters',1987);
insert into Book values ('FC09.88 R38 2002','7997121866887','The Dying of the Wings','Brian B. Girard','Scholastic',2002);
insert into Book values ('QP12.99 H38 2012','8079918003864','Danger in the Worlds','Joseph S. Jacobson','Oxford University Press',2012);
insert into Book values ('BF47.00 R38 1997','8560931758201','Laughing Predator','Juanita P. Porter','Reuters',1997);
insert into Book values ('RM83.12 Q38 1994','3233701617188','The Bold Birch','Hugh N. Brown','Harlequin',1994);
insert into Book values ('ER21.13 F38 1977','5649418113465','Storms of Wizard','Richard B. Williams','Wiley',1977);
insert into Book values ('WX30.73 L14 2001','7482546906698','The Spirits of the Visions','Dorothy L. Dunlap','McGraw-Hill Education',2001);
insert into Book values ('DH65.12 R44 2005','9780525952961','Just One Evil Act: A Lynley Novel','Elizabeth George','Dutton Adult',2005);


insert into Borrower values ('2345','password','Michael','2205 Lower Mall','383-283-2832','jfksd@google.ca','14237119','2013-05-12','Student');
insert into Borrower values ('11111','1234','John','5959 Student Union Boulevard','778-123-4567','john@google.ca','1234567','2011-06-04','Student');
insert into Borrower values ('5673','ringo','Ringo','234 Main Mall','604-654-4561','ringo@google.ca','234634','2010-05-18','Faculty');
insert into Borrower values ('64789','chemistry','Paul','654 University Boulevard','604-987-1235','paul@google.ca','3568643','2018-09-12','Faculty');
insert into Borrower values ('4578','Jagger','Mick','124 Granville St.','604-517-9564','mick@google.ca','8976541','2005-11-12','Staff');
insert into Borrower values ('5489','word','Smith','124 Granville St.','604-517-9564','smith@google.ca','89727571','2012-11-12','Public');
insert into Borrower values ('7680456','code','George','3463 16th Ave.','604-333-5555','george@google.ca','4896321','2014-10-22','Public');
insert into Borrower values ('34567','codeword','Mary','3463 16th Ave.','604-333-5555','george@google.ca','95413657','2014-10-22','Public');


insert into HasAuthor values ('QA76.12 J34 2000','Molly W. Blouin');
insert into HasAuthor values ('KD15.55 C14 2004','Peter L. Turner');
insert into HasAuthor values ('AL41.66 A61 1999','Dominic A. Flynn');
insert into HasAuthor values ('QL25.77 F38 1987','Dawn J. Dulac');
insert into HasAuthor values ('FC09.88 R38 2002','Brian B. Girard');
insert into HasAuthor values ('QP12.99 H38 2012','Joseph S. Jacobson');
insert into HasAuthor values ('BF47.00 R38 1997','Juanita P. Porter');
insert into HasAuthor values ('RM83.12 Q38 1994','Hugh N. Brown');
insert into HasAuthor values ('ER21.13 F38 1977','Richard B. Williams');
insert into HasAuthor values ('WX30.73 L14 2001','Dorothy L. Dunlap');
insert into HasAuthor values ('DH65.12 R44 2005','Elizabeth George');

insert into HasSubject values ('QA76.12 J34 2000','Mystery');
insert into HasSubject values ('KD15.55 C14 2004','Science Fiction');
insert into HasSubject values ('AL41.66 A61 1999','Non-fiction');
insert into HasSubject values ('AL41.66 A61 1999','Psychology');
insert into HasSubject values ('QL25.77 F38 1987','Poetry');
insert into HasSubject values ('FC09.88 R38 2002','Thriller');
insert into HasSubject values ('QP12.99 H38 2012','History');
insert into HasSubject values ('BF47.00 R38 1997','Comedy');
insert into HasSubject values ('RM83.12 Q38 1994','Romance');
insert into HasSubject values ('ER21.13 F38 1977','Fantasy');
insert into HasSubject values ('WX30.73 L14 2001','Non-fiction');
insert into HasSubject values ('WX30.73 L14 2001','Lifestyle');
insert into HasSubject values ('DH65.12 R44 2005','Mystery');

insert into BookCopy values ('QA76.12 J34 2000',1,'out');
insert into BookCopy values ('KD15.55 C14 2004',1,'in');
insert into BookCopy values ('AL41.66 A61 1999',1,'in');
insert into BookCopy values ('QL25.77 F38 1987',1,'on-hold');
insert into BookCopy values ('FC09.88 R38 2002',1,'in');
insert into BookCopy values ('QP12.99 H38 2012',1,'on-hold');
insert into BookCopy values ('QP12.99 H38 2012',2,'out');
insert into BookCopy values ('BF47.00 R38 1997',1,'in');
insert into BookCopy values ('BF47.00 R38 1997',2,'out');
insert into BookCopy values ('RM83.12 Q38 1994',1,'in');
insert into BookCopy values ('ER21.13 F38 1977',1,'out');
insert into BookCopy values ('WX30.73 L14 2001',1,'on-hold');
insert into BookCopy values ('WX30.73 L14 2001',2,'in');
insert into BookCopy values ('WX30.73 L14 2001',3,'out');
insert into BookCopy values ('DH65.12 R44 2005',1,'in');

insert into HoldRequest values ('1234','2345','WX30.73 L14 2001','2013-05-03');
insert into HoldRequest values ('7890','2345','QA76.12 J34 2000','2013-05-12');
insert into HoldRequest values ('8745','5673','QL25.77 F38 1987','2013-05-12');
insert into HoldRequest values ('7346','64789','QP12.99 H38 2012','2013-05-12');
insert into HoldRequest values ('8333','4578','QA76.12 J34 2000','2013-05-22');

insert into Borrowing values ('93092','2345','WX30.73 L14 2001',3,'2014-03-02',null,'2014-03-16');
insert into Borrowing values ('45865','2345','BF47.00 R38 1997',2,'2014-03-02',null,'2014-03-16');
insert into Borrowing values ('65412','2345','QP12.99 H38 2012',2,'2014-03-02',null,'2014-03-16');
insert into Borrowing values ('98415','64789','QA76.12 J34 2000',1,'2014-04-03','2014-04-04','2014-07-03');
insert into Borrowing values ('45682','7680456','ER21.13 F38 1977',1,'2013-04-04','2013-04-25','2013-04-18');
insert into Borrowing values ('45984','11111','DH65.12 R44 2005',1,'2014-03-25','2014-04-05','2014-04-08');
insert into Borrowing values ('25647','7680456','DH65.12 R44 2005',1,'2014-01-14','2014-01-27','2014-01-28');
insert into Borrowing values ('89735','4578','QP12.99 H38 2012',1,'2012-10-14','2012-10-30','2012-10-28');


insert into Fine values ('Fine 1', 1.20,'2014-03-16',null,'93092');
insert into Fine values ('Fine 2', 0.50,'2014-03-13','2014-03-14','45865');
insert into Fine values ('Fine 3', 5.50,'2013-04-18','2013-04-25','45682');
insert into Fine values ('Fine 4', 2.50,'2012-10-28','2012-10-30','89735');

