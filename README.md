The backend of this application is built using Symfony Framework and
PostgreSQL. In order to build the APIs, we first connect our project
with the pgAdmin using a database URL in the .env file then create the
database then build our Customer table by creating the Customer Entity
and giving it some properties. After that, we create our
CustomerApiController to build the functions, this controller extends an
AbstractApiController that extends the AbstractFOSRestController which
we can find after installing the rest bundle that helps us return JSON
responses. Basically, the CustomerApiController has 4 main functions,
that are:

-   indexAction which lists all the customers found using GET method.

-   createAction which adds new customers using POST method.

-   updateAction which updates the info of customers by Id using PUT
    method.

-   deleteAction which deletes a customer by Id using DELETE method.

Note that all routes are identified in the routes.yaml file where we
give each function a name, path and method, and to test these APIs we
use the Postman app or the thunder extension on vscode.

The front end of this application is built using HTML, CSS, and PHP.
Since our CustomerApiController only returns JSON we had to build
another CustomerController that renders our code, in this controller we
also have 4 functions (index, create, update and delete) these functions
are connected to the Customer template that we use to make the design of
this app. Basically, after running a table of customers will be found
and above the table, there's an Add button that will direct you to a
form this form asks you about the customer's name, address, and phone
number (the design of this form is built using bootstrap and is found in
the index.html.twig file). The phone number is a button that takes you
to another page to validate your number, this page is built using a
third-party API which is the NumVerify API where you enter the phone
number and country code, and its returns whether this number is valid or
not, the local and international format, the country name, the carrier,
and line type. After adding the customer's info you'll be directed back
to the list of customers table where this table is divided into 5
sections: Id, Name, Address, Phone Number, and Action. In the Action
section, you'll find 2 buttons (update and delete), the update button
will take to the form to update any info about the customer and the
delete button will delete the customer (the design of the delete button
is built using bootstrap and its code is in the base.html.twig file).
