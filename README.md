# Expense Tracker

## Description
The Expense Tracker is a simple web application that allows users to track their personal expenses and income. Users can:
- Add transactions (description, amount, date, and type).
- Filter transactions based on type, amount, and date range.
- View a summary of their financial activity.

## Features
- Add income or expense transactions.
- Filter transactions by type (income/expense).
- Filter by amount range and date range.
- Responsive design for mobile and desktop views.

## Technologies Used
- **HTML**: For the structure of the web pages.
- **CSS**: For styling and layout of the pages.
- **JavaScript**: For front-end functionality (e.g., form validation, event handling).
- **PHP**: For server-side processing and database interaction.
- **MySQL**: For storing transaction data.
- **Session Management**: To keep track of the logged-in user.

## Methods Used
### Method 1: Frontend (index.html + script.js)
1. **index.html**: Contains the basic structure of the web page and forms for adding transactions and filtering them.
2. **script.js**: Handles client-side functionality, such as validating form inputs and managing user interactions.
   - The user can add new transactions and apply filters using forms.
   - This method works with basic HTML and JavaScript for a more interactive user experience.

### Method 2: Backend (transaction.php)
1. **transaction.php**: Handles server-side operations.
   - The PHP script interacts with the MySQL database to fetch transaction data.
   - It also processes filters like type, amount, and date range.
   - This method handles the actual data retrieval and manipulation based on the user's input and returns the results dynamically.
2. **PHP Session**: Keeps track of the logged-in user and their transactions.
   - Only authenticated users can access and manipulate their transactions.
   - The PHP script verifies if the user is logged in before performing actions.

## Setup Instructions

### Prerequisites:
- Ensure that you have PHP and MySQL installed on your local machine or server.
- You will also need a web server (e.g., Apache) to serve the PHP files.

### Installation:
1. Clone this repository to your local machine.
   ```bash
   git clone https://github.com/hananeltassa/expenseTracker.git
