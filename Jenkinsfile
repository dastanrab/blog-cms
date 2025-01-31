pipeline {
    agent any

    environment {
        PROJECT_DIR = "/home/jenkins/workspace/my_project"
    }

    stages {
        stage('Clone Repository') {
            steps {
                script {
                    if (fileExists(PROJECT_DIR)) {
                        echo "Project exists. Pulling latest changes..."
                        sh "cd ${PROJECT_DIR} && git pull origin main"
                    } else {
                        echo "Cloning repository..."
                        sh "git clone https://your-repo-url.git ${PROJECT_DIR}"
                    }
                }
            }
        }

        stage('Update Dependencies') {
            steps {
                script {
                    sh "cd ${PROJECT_DIR} && npm install"
                    sh "cd ${PROJECT_DIR} && composer install"
                }
            }
        }

        stage('Build Project') {
            steps {
                script {
                    sh "cd ${PROJECT_DIR} && npm run build"
                }
            }
        }

        stage('Restart Services') {
            steps {
                script {
                    sh "cd ${PROJECT_DIR} && docker compose up -d --build"
                }
            }
        }
    }
}
