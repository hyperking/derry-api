# derry-api

![image](https://user-images.githubusercontent.com/1525894/41775382-af7cd110-75f1-11e8-8eef-d9a2ea2c411e.png)

Develop a plugin that utilizes the WordPress REST API to pull a list of most recently published posts from 3 to 5 other WordPress sites and display that list as a Dashboard widget in the WordPress admin. 

The list shall contain all posts/pages/custom post types and display 10 items by default; the user shall be able to change the number of items displayed. 

The user shall also have the ability to filter the list by website, the default list shall display all sites. A link/button to manually approve each post shall accompany each post in the list. 

When a user approves a post, the approval, username and a time stamp shall be passed to the site containing that page and each shall be stored in custom meta fields. Also, once approved, the post shall no longer appear in the list of recently published posts.
