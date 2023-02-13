# Organization of Data files (SQL tables)

_All will have a creation timestamp_

## user table (for login)
* username 
* password (hashed & salted)
* full name
* admin level (admin / staff / "patron")

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

## Library Card
* key is barcode
* patron id
* status (out of circulation: if a patron loses his/hers, we can never assign the same barcode to someone else)
* expiry date

## Bib (Bibliographic entry)
* id/key
* title
* author
* pub date
* call number (Dewey Decimal System)
* genre ?
* subjects ?
* ?

## Holdings (representing actual physical media)
* barcode = key
* BIB id# (link)
* Patron id# (if checed out)
* status (link to status list: in, out, lost, discard, repairs, ...)
* media (link to meia list: book, DVD, audiobook, ..) (?)
* language ?
* cost
* ISBN
* ?
