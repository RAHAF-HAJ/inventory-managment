# Inventory management system:

This app is MVC oop pure php based.
The main structure of the app is as follow:
1- Config folder: contains the database credentials and jwt configurations.
2- Core: contains the basic classes that manage the MVC pattern:
1- Database.php: is responsible for connecting database and generic query/prepare
queries
2- Config: singleton pattern that returns the configurations by key.
3- Upload: Class to control simple file uploading
4- Entity: This main class uses ​__get method which enables us from getting any property
without declaration, we inject this class into PDO using Fetch_class feature to convert the
results into wrapped entity class.
5- Model: contains the essential operations on model such as create, delete ...
6-Controller: contains the rendering management and model binding.
7-Html form: contains a dynamic way to create simple bootstrap form
8- RestHandler: a simple helper to work with rest api.
3-lib: contains the vendor libraries
4- public: contains the public resources with the starting point to launch the app(index.php)
5-App: The main app folder, each entity in this folder has: entity class, model, controller,
view pages.
They all working together using model/action technique to determine the response.
**Security:**
To achieve the security there will be

- login system for users
- jwt auth form rest api users
- url will be defined in htaccess
- one entry point that determine next action depending on the valid url
- using htmlentities and prepare function to deal with users insertions and updating.
**Notes:**

## due to ​commitments with my company:

- I have achieved the sales/purchase section only.
- In rest api I achieved only 4 web method with jwt auth.


