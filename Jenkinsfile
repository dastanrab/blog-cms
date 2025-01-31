pipeline {
    agent any

    environment {
        // Set up environment variables for Laravel
        DB_HOST = 'localhost'
        DB_DATABASE = 'your_database'
        DB_USERNAME = 'your_username'
        DB_PASSWORD = 'your_password'
        APP_ENV = 'production'
    }

    stages {
        stage('Clone Repository') {
            steps {
                // Clone the Laravel repository
                git 'https://github.com/dastanrab/blog-cms.git'
            }
        }

        stage('Install PHP Dependencies') {
            steps {
                script {
                    // Install PHP dependencies via Composer
                    sh 'composer install --no-interaction --prefer-dist'
                }
            }
        }

        stage('Set Up Environment') {
            steps {
                script {
                    // Set up .env file (you might want to customize this process)
                    sh 'cp .env.example .env'
                    
                    // Generate the Laravel application key
                    sh 'php artisan key:generate'
                    
                    // Run database migrations (important for production)
                    sh 'php artisan migrate --force'

                    // You can also seed the database if needed (uncomment the next line)
                    // sh 'php artisan db:seed --force'
                }
            }
        }

        stage('Run Tests') {
            steps {
                script {
                    // Run Laravel tests
                    sh 'php artisan test'
                }
            }
        }

        stage('Build Assets') {
            steps {
                script {
                    // If you're using Laravel Mix for frontend assets
                    sh 'npm install'
                    sh 'npm run prod'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    // Add your deployment commands here
                    // For example, you can deploy to a server via SSH, or deploy to a cloud service
                    // Example: rsync to a remote server
                    // sh 'rsync -avz ./ user@server:/path/to/your/project'
                    
                    // If you're deploying to a cloud platform like Heroku, AWS, or DigitalOcean, add steps here
                }
            }
        }
    }

    post {
        always {
            // Clean up after the build
            cleanWs()
        }

        success {
            // Notify or log success
            echo "Build and tests succeeded!"
        }

        failure {
            // Notify or log failure
            echo "Build or tests failed."
        }
    }
}
