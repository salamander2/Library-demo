# Organization of Data files (SQL tables)

_All will have a creation timestamp_

##  ➡️ Actual [SQL Table config](SQL_Tables.md)

## user table (for login)
* username 
* password (hashed & salted)
* full name
* admin level (admin / staff / "patron")
* "createDate"(time stamp when record is created)

## Patron
* id / key
* first name
* last name
* address
* city
* province
* phone
* email (optional)
* birthdate
* (link to list of library cards)
* "createDate"(time stamp when record is created)

## LibraryCard
* key is barcode:  2xxxxyyyyy : x will be library code (0748) y is sequential number (99,999 cards only)
* patron id (required, liked to Patron file, using foreign key, on delete cascade)
* status (try enum: valid, lost, expired)    
 (out of circulation: if a patron loses his/hers, we can never assign the same barcode to someone else)
* expiry date (this will be set for a year from present or from their last birthday)
* "createDate"(time stamp when record is created)

All of these fields are required.

## Bib (Bibliographic entry)
* id/key (autogenerated)
* title 
* author
* pub date
* ISBN
* call number (Dewey Decimal System) [optional]
* subjects [optional]  <-- the subjects are all empty for the data that we loaded into Bib.
* createDate (time stamp when record is created)

## Holdings (representing actual physical media)
* barcode = primary key. This will be the same format as the Library Card barcode, but it will begin with a 3 (ie. 30749yyyyy).  
* BIB id# (link) <-- this is a foreign key. It cannot be null.
* Patron id# (if checked out) <-- this is a foreign key (linked to Patron ID obviously). It CAN be null. It is not required. Default is null.
* cost  <-- Stored in cents. Cannot be null. Required.
The above 4 things will be "unsigned int"
* status (link to status list: in, out, lost, discard, repairs, ...) <-- This is a foreign key. It cannot be null. Default is IN
* ckoDate (date). Date that the book was last checked out. 
* dueDate (date). Date that book is due (if status = out or lost or CR).
* prevPatron (link). This is the previous patron who had the book out.
* media (link to meia list: book, DVD, audiobook, ..) (?) _ X No, we do not want this field. We can add it later._
* language _X No we do not want this field. _
* "createDate"(time stamp when record is created)

## Status (status of books)
* code (primary key) varchar(10)    Could this be an enum?
* description (40 chars, varchar)

"code" will be IN, OUT, LOST, DAMAGED, DISCARD, REPAIRS, CR, ...     
"description" provides a description of the code. eg. CR = "Claims Returned"    
There will only be about 5-10 statuses.    
