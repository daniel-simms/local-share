# local-share | Final Major Project

This is my final major project. I created a social network prototype that would show users posts within a certain mile radius of your current position. It extends and MVC PHP framework: MINI (https://github.com/panique/mini). Unfortunately, due to submitting the wrong Database file, I was only awarded a 2:2, this was an unforgiving mistake and which cost me a higher grade.

## The app

Local Share focuses on news, events and happenings within a community. Users are given a UI where they can post information about anything happening in the community. The application uses an algorithm that takes the users location and then finds information that other people have posted within a certain mile radius of the location. This radius can be changed to between 1 and twenty-five miles and defaults to 2 as the user registers. You do not need to send a friend request to other users, the information you share about the community will accessible to anyone within a 25-mile radius. When a user shares information about the community and creates a post, they are presented with 6 categories, called tags, these are: Crime, Lost & Found, Events, Offers, Traffic, Other. The user must choose one of these tags to help categorise the post. The post can also contain a featured image which can be uploaded onto the post for everyone to see.

![FEED](/public/img/screenshots/feed.png)

## Database

The database is an SQL relational database. It designed with the full application in mind giving room for expansion in the future and was also designed in third normalisation (3NF) form. Not all tables were included in the prototype.

![DB](/public/img/screenshots/db.png)

## The Brain

This was the hardest part of the project. For the algorithm to work properly, when a user shares a post about their community, their current latitude and longitude coordinates are stored along with the post in the database. To then retrieve results from the database within a certain radius, or bounding box, of the current user’s location, the algorithm needs to know the latitude and longitude values from the said user's current location. It also needs to be told what the radius of the bounding box will be in miles, this is set to two by default when a user registers with LocalShare. Later they do have the option to change it in the settings located within the application. However, before it makes its final calculation, it also needs to know the radius of the earth, which is set as a control variable in the PHP code that the user cannot change.

For Latitude:   φ= φ ± d/R
For Longitude:  λ = λ ± (d/R) / cosφ

φ = latitude, λ = longitude (in radians), R = radius of earth, d = distance between the points (in same units as R)

This formula is used to work out the maximum and minimum latitude and longitude values, and any post with a latitude and longitude that the algorithm is able to find within these values will then be displayed for the user to see and interact with as they please. The application uses SQL queries to retrieve all of the posts from the database, thus this formula needs to be converted into SQL.

![SQL](/public/img/screenshots/sql.png)

The latitude and longitude values are passed into the function using parameters coming from the main page MVC controller. ‘$rad’ is the radius of the bounding box and ‘$this->getPref();’ is a function that gets the radius from the user's settings.

![BOX](/public/img/screenshots/box.png)

Once the algorithm has found all of the posts within the bounding box, it will then send it back to the feed controller in a variable ‘$feedItems’, the controller will then use a PHP for each loop to loop through the variable and display the posts using HTML.

![PHP](/public/img/screenshots/php.png)




