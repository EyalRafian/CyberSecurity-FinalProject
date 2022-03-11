# Comunitcation LTD project installation instructions.

1. Download WAMP in the following website: https://www.wampserver.com/en/

2. After you finish installation, open "local host"
    - select "Add a Virtual Host" under the Tools category
    - Name your virtual host with your preferred name
    - Select path for the project on which you'll be working on, there you'll copy the files you've downloaded into.
    - Click "Start the creation of virtual host" at the bottom right button.
    - Left click WAMP local mini icon at the bottom right, and select "Restart all devices"
3. Copy the folder you've download from this GitHub to your selecter VirtualHost folder.

3. Go to local host again (can be selected from the WAMP menu at the bottom right), and select "PhpMyAdmin 4.9.7" under Your Aliases.
    - Create a new database called "project-db"
    - Select "Import" at the topbar memnu, and import a file called "project-db.sql"
    - Change the database connection creds if needed in the file include/dbConfig.php.

4. Now you should be able to access the website in your virtual host, which can be opened from the localhost menu. L'chaim!
