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

### Screenshots:
## User Registration Interface

![Screenshot (288)](https://github.com/user-attachments/assets/429bf3d6-1ab9-4519-a808-41f1860c411b)

## User Login Interface 

![Screenshot (289)](https://github.com/user-attachments/assets/817a3c4e-8deb-415e-a03d-cde93cdf1cce)

## Vendor Dashboard

![Screenshot (290)](https://github.com/user-attachments/assets/9bd13760-9531-464a-819b-bdabc95657e1)

## Customer Dashboard

![Screenshot (302)](https://github.com/user-attachments/assets/d892e369-f20f-4960-b5ea-117de5bba671)

## Product Catalog

![Screenshot (304)](https://github.com/user-attachments/assets/69becbfd-5ad5-4556-a087-a9898d7c2ca0)
![Screenshot (306)](https://github.com/user-attachments/assets/f0b1c326-b0b1-4965-8daf-a29992ff33c1)

## Database Schema Overview

![Screenshot (328)](https://github.com/user-attachments/assets/af30dc1e-7519-4a05-9a05-764845914474)

