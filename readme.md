# Upload big csv with background parsing

## Getting Started

Follow these steps to set up and run the application on your local machine.

### Clone the Repository

Clone this Git repository to your desired directory:

```bash
git clone https://github.com/leksgit/bigloader.git
```

Navigate to the project directory:

```bash
cd bigloader
```

### Edit .env for docker-compose
Duplicate the .env.example file and rename it to .env and change config:
```bash
cp .env.example .env
```


### Start Docker Container
Start the Docker containers defined in the docker-compose.yml file:

```bash
docker-compose up -d
```

### Connect to Console in Container
To connect to the console within the php-fpm container, use the following command:

```bash
docker-compose exec php-fpm bash
```

### Copy .env.example File
Duplicate the .env.example file and rename it to .env:
```bash
cp .env.example .env
```

### Configure Environment Variables
Edit the .env file and configure the necessary environment variables, such as database connection details.

```bash
APP_URL=http://bigloader.loc

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=your_laravel_user_password
```
### Generate Application Key
Generate the application key by running the following command:

```bash
php artisan key:generate
```

### Install Dependencies and Build Frontend
Inside the container's console, run the following commands to install the required dependencies and build the frontend assets:

```bash
composer install
npm install
npm run build
```

### Run Database Migrations
While still in the container's console, run the following command to apply the database migrations:

```bash
php artisan migrate
```


### Update Hosts File
Add the following line to your hosts file (/etc/hosts on Linux or C:\Windows\System32\drivers\etc\hosts on Windows) to map the hostname short.loc to your local machine:

```bash
127.0.0.1 bigloader.loc
```

### Access the Application
Open your web browser and navigate to the following link to access the Bigloader application:

http://bigloader.loc