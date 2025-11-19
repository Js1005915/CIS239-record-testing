1. The require_login() function checks if the session user_id is set, if it is not, then it exits, which makes none of the code following after work. It is placed in every switch that we require a login for, it requires you to have a login.

2. In the login process, you put your username and password, inside the submit button in the form, it changes action to login, which is inside the index.php file, it checks the action variable in a switch case. 
The login case checks the username and password and finds the user by the username, if the password is correct, it works and changes the session user id to the same user_id and changes the user full name to its corresponding full name. 
Lastly it changes the view variable to list.

3. Whats stored into the $_SESSION['cart'] is the record_id corresponding to whatever record you clicked add to cart with. The action is when you click the add to cart button, it changes the action variable to add_to_cart. It stores the record_id.

4. The record_in_cart variable is set inside the index.php file when the view is set to 'cart'. We use the records_by_ids function so that we can get all the info that comes with the record corresponding to that record id, instead of just only the record id. 

5. When you click complete purchase, it switches the action to checkout, it then does a loop through everything inside your cart, and for each item it creates a purchase in the purchases table using the create_purchase function, and adds your user id to it. 

