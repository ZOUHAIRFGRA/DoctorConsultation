# Project Overview

This project is a web application for patient-doctor consultations, with an admin panel to manage the consultations, view statistics, and generate bills. The application is built using PHP and uses MySQL as the database management system.

## Installation

To run this application, you'll need to follow these steps:

1. Download or clone the repository to your local machine.
2. Create a MySQL database named `doctor`.
3. Import the SQL schema located in `tables.sql` into the `doctor` database.
4. Edit the database connection details in `config.php` to match your database credentials.
5. Start a local PHP server in the project directory using the command `php -S localhost:8000`.
6. Open a web browser and navigate to `http://localhost:8000` to access the application.

## Admin Panel

The admin panel can be accessed by logging in with the admin credentials. The admin can:

- View all consultations
- Add new consultations
- Edit existing consultations
- Delete consultations
- View statistics on consultations
- Generate bills for patients

The statistics page displays the following charts:

- Consultations by day/night
- Consultations by male/female patients
- Consultations by medical specialty

## Technical Details

The application is built using PHP, HTML, CSS, and JavaScript. The database management system used is MySQL, and the SQL schema is defined in `tables.sql`. The application uses the Bootstrap framework for styling and the Chart.js library for displaying charts. 

## Credits

This project was created by Zouhair Fouiguira as a University project.
