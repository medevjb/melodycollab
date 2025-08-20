# Melody Collab - Music Producer Collaboration Platform

<p align="center">
  <img src="public/frontend/images/MelodyCollabFinal-favicon.png" alt="Melody Collab Logo" width="200">
</p>

## About Melody Collab

Melody Collab is a revolutionary platform designed to connect music producers worldwide, enabling seamless collaboration through melody sharing. The platform allows producers to upload, download, and collaborate on melodies with clear licensing terms and revenue sharing agreements.

## Key Features

### For Producers
- **Upload Melodies**: Share your original melodies with producers around the world
- **Download Melodies**: Access a vast library of melodies from top producers
- **Collaboration System**: Clear percentage splits and licensing terms for all collaborations
- **Producer Profiles**: Showcase your work and connect with other producers
- **Pack Creation**: Group related melodies into themed packs

### Platform Features
- **Advanced Search**: Find melodies by genre, instrument, artist type, BPM, and key
- **Licensing System**: Automated licensing agreements for all downloaded melodies
- **Subscription Plans**: Free and premium tiers with different upload limits
- **Payment Integration**: Secure payment processing with Stripe and PayPal

## Technology Stack

- **Framework**: Laravel 10.x
- **Frontend**: HTML, CSS, JavaScript
- **Database**: MySQL
- **Media Processing**: FFmpeg for audio processing
- **Payment Gateways**: Stripe, PayPal
- **PDF Generation**: DomPDF for license agreements
- **Authentication**: Laravel UI with custom extensions

## Installation

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL
- FFmpeg
- Node.js & NPM

### Setup Instructions

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/melody-collab.git
   cd melody-collab
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install JavaScript dependencies
   ```bash
   npm install
   ```

4. Create environment file
   ```bash
   cp .env.example .env
   ```

5. Generate application key
   ```bash
   php artisan key:generate
   ```

6. Configure your database in the `.env` file
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=melody_collab
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Run database migrations and seeders
   ```bash
   php artisan migrate --seed
   ```

8. Create symbolic link for storage
   ```bash
   php artisan storage:link
   ```

9. Compile assets
   ```bash
   npm run dev
   ```

10. Start the development server
    ```bash
    php artisan serve
    ```

## Configuration

### Payment Gateways

Configure Stripe and PayPal credentials in your `.env` file:

```
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret

PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_SECRET=your_paypal_secret
PAYPAL_MODE=sandbox
```

### FFmpeg

Ensure FFmpeg is installed on your server and properly configured in the `.env` file:

```
FFMPEG_BINARIES=/path/to/ffmpeg
FFPROBE_BINARIES=/path/to/ffprobe
```

## Project Structure

- `app/` - Contains the core code of the application
  - `Http/Controllers/` - Controllers for handling requests
  - `Models/` - Eloquent models representing database tables
  - `Helpers/` - Helper functions used throughout the application
- `resources/` - Contains views, raw assets, and language files
  - `views/` - Blade templates for the frontend and backend
  - `js/` - JavaScript files
  - `css/` - CSS files
- `public/` - Publicly accessible files
  - `frontend/` - Frontend assets (CSS, JS, images)
  - `backend/` - Backend assets (CSS, JS, images)
  - `uploads/` - User uploaded files

## User Roles

- **Admin**: Full access to manage the platform, users, and content
- **Producer**: Can upload melodies, create packs, and download other producers' melodies

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgements

- [Laravel](https://laravel.com) - The web framework used
- [Stripe](https://stripe.com) - Payment processing
- [PayPal](https://paypal.com) - Payment processing
- [FFmpeg](https://ffmpeg.org) - Audio processing