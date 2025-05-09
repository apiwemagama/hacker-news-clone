# Hacker News Clone (Laravel)

## Setup

1. Clone repo
   ```bash
   git clone https://github.com/your-username/hacker-news-clone.git
   cd hacker-news-clone
   ```

2. Install dependencies
   ```bash
   composer install
   npm install
   ```

3. Configure environment
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Database setup
   - Create MySQL database
   - Update `.env`:
     ```ini
     DB_DATABASE=hacker_news
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. Run migrations
   ```bash
   php artisan migrate
   ```

6. Start servers
   ```bash
   php artisan serve
   npm run dev
   ```