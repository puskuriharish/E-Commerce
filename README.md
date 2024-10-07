Here's a complete and structured project description for your **E-commerce ** project that includes the features for both **Vendor** and **Customer** pages:

---

## **E-commerce System (Web Development)**

This is a **Web Application** designed for managing an e-commerce platform, where vendors can manage their products and customers can browse, order, and make payments. The project is built using **HTML**, **CSS**, **JavaScript**, **PHP**, and **MySQL**.

### **Key Features:**

#### **Vendor Page:**
1. **Add Products**: Vendors can add new products by providing details like product name, price, description, and images.
2. **View Products**: Vendors can view a list of all products they have added, with the ability to sort or search products.
3. **Edit Products**: Vendors can update product details such as price, description, or images.
4. **Delete Products**: Vendors can remove products from the list if they are no longer available.

#### **Customer Page:**
1. **View Products**: Customers can browse products, view their details (including name, price, and images), and compare products.
2. **Add to Cart**: Customers can add products to their shopping cart for review before purchasing.
3. **Place Orders**: Customers can place orders for the products in their cart and proceed to payment.
4. **Make Payments**: Customers can choose between multiple payment options, including UPI and Cash on Delivery (COD).
5. **Order History**: Customers can view their past orders and track the status of current orders.

---

### **About the Project:**
This web application was developed using **PHP** for back-end logic and **MySQL** for database management, while the front end was designed using **HTML**, **CSS**, and **JavaScript** for a responsive user interface. It allows vendors to manage product listings and customers to browse, order, and pay for products seamlessly.

### **Database (MySQL):**
The MySQL database for this project contains the following tables:
- **Users Table**: Stores login credentials for both vendors and customers.
- **Products Table**: Contains product information such as product ID, name, price, description, and images.
- **Orders Table**: Stores details about customer orders, including products ordered, order total, and order status.
- **Payments Table**: Stores payment information for orders, including payment method and status.

### **Technologies Used:**
- **Front-End**: HTML, CSS, JavaScript
- **Back-End**: PHP
- **Database**: MySQL
- **Server**: XAMPP (for local development)

---

### **Project Structure:**
1. **Vendor Pages**:
   - `add_product.php`: Vendors can add new products.
   - `edit_product.php`: Vendors can update existing product details.
   - `delete_product.php`: Allows vendors to remove products from the list.
   - `view_products.php`: Displays the list of products added by the vendor.

2. **Customer Pages**:
   - `view_products.php`: Customers can browse available products.
   - `order.php`: Customers can place orders for products in their cart.
   - `payment.php`: Customers can select payment methods (UPI or COD).
   - `order_history.php`: Displays the customer's past orders.

### **How to Run:**
1. Install **XAMPP** on your local machine.
2. Clone the repository to the **htdocs** folder.
3. Start **Apache** and **MySQL** from the XAMPP Control Panel.
4. Create the required **MySQL database** and tables (`users`, `products`, `orders`, `payments`).
5. Access the project through `http://localhost/ecommerce-system/`.

---

This structured description can be used in your GitHub repository to clearly explain the project and its features. Let me know if you need more assistance!
