Setting up and using the WebUI application - James Hall

Contact me - JHALL202@caledonian.ac.uk



How to run the application:

1. Download any form of localhost web server application (Xampp, EasyPHP).

2. Ensure the Apache and MySQL servers are running.

3. Move the contents of the folder "webui" from the SSD_CourseWork.zip folder provided into the htdocs folder 
	(Default route = C:\xampp\htdocs)

4. Import the databases provided in the SQL folder into the MySQL servers.
	4.1 From PHPMyAdmin, create the database "securesoftware"
	4.2 import the "securesoftware.sql" file into the database to import the tables.
	4.3 Once the tables have been imported, select "SQL" at the top in PHPMyAdmin and import the SQL statements from the
	text file "SQLstatements" by copy and pasting them in. This will populate the databases. 

	^^^****THIS MUST BE COMPLETED TO USE THE WEBUI AS DESTINATIONS ARE REQUIRED****^^^

5. In the web browser, input "Localhost/index.php" to begin the application provided your localhost is working.



Using the application

1. The program should begin at the login page (localhost/index.php)

2. Click the "Register" link to create your own profile.
	2.1 Input your own unique username.
	2.2 Input your own unique valid email adress.
	2.3 Input a valid password twice. Must have over 6 characters, one capital letter and one numerical value.
	2.4 Click the register button. All fields must be filled.

3. Input the username/email your provided along with the password to successfully login
	3.1 failing to login 4 times will result in you being locked out for a minute. 

*once logged in, if you're idle for 1 minute your session will end and you will be logged out*

4. To create a job, simply select "Create Job" and input a description of the job. Cannot use the characters '<' or '>' 
	4.1 Select one of the destinations to send the job once it is complete. 
	4.2 Select "create" once the job info is fine. 

*Use the Navigation bar at the top by clicking your username. This will allow you to return to the homepage*


5. To upload a file, input a title (no special characters permitted).
	5.1 Input a description. Cannot use the characters '<' or '>'.
	5.2 Select a file you wish to upload. Can only accept files of a specific type (doc, docx, pdf and text).
	5.3 Select the job from the dropdown which you want to attach the file to.
	5.3 Select upload to upload your file.

6. to view Jobs stored in the database, return home and select "View Jobs".

7. to view files stored in the database, return home and select "View Documents".
	7.1 From this page. all uploaded documents will be visible.
	7.2 Files will also be stored in the folder "uploads" from the .zip file.

8. using the dropdown on the nav bar, you can sign out of the system. 




