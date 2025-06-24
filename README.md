# Gestion Loyer Project

## Overview
The Gestion Loyer project is a web application designed to manage rental properties and related services. It provides users with information about the organization, its services, and the ability to register and log in.

## Directory Structure
- **assets/**: Contains CSS, images, and JavaScript files for styling and functionality.
  - **css/**: Stylesheets for the application.
  - **img/**: Images used in the application.
  - **js/**: JavaScript files for client-side functionality.
  
- **assetts/**: Contains additional resources.
  - **css/**: Additional stylesheets.
  - **img/**: Additional images.
  - **js/**: Additional JavaScript files.
  - **vendor/**: Third-party libraries or frameworks.

- **connexion/**: Contains the database connection file.
  - **connexion.php**: Handles the database connection.

- **controllers/**: Contains controller files for handling requests.
  - **HomeController.php**: Manages requests related to the home page.

- **models/**: Contains model files for data handling.
  - **select/**: Contains selection-related files.
    - **select-Home.php**: Functions for selecting data related to the home page.

- **routes/**: Contains routing files for the application.
  - **web.php**: Defines the routing for the application.

- **views/**: Contains view files for rendering HTML content.
  - **home.php**: Home page content.
  - **about.php**: About page content.
  - **services.php**: Services page content.
  - **article.php**: Article page content.
  - **team.php**: Team page content.
  - **inscription.php**: Registration page content.
  - **login.php**: Login page content.
  - **layout/**: Contains layout files.
    - **header.php**: Header layout.
    - **footer.php**: Footer layout.

- **index.php**: Entry point for the application, includes database connection and models.

## Features
- User registration and login functionality.
- Information about the organization and its services.
- Dynamic content loading based on user interactions.

## Installation
1. Clone the repository to your local machine.
2. Set up a web server (e.g., XAMPP) and place the project in the server's root directory.
3. Configure the database connection in `connexion/connexion.php`.
4. Access the application via your web browser.

## Usage
- Navigate to the home page to view the main content.
- Use the navigation menu to access different sections of the application, including About, Services, Articles, Team, Registration, and Login.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License.