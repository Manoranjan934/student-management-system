pipeline {
    agent any
    
    stages {
        stage('Checkout') {
            steps {
                echo 'Getting code from GitHub...'
                checkout scm
            }
        }
        
        stage('Database Migration') {
            steps {
                echo 'Running Flyway migrations...'
                bat '''
                    cd C:\\flyway-projects\\sms-migrations
                    "C:\\Program Files\\Red Gate\\Flyway Desktop\\flyway.cmd" -configFiles=conf\\flyway.conf migrate
                '''
            }
        }
        
        stage('Deploy') {
            steps {
                echo 'Deploying to XAMPP...'
                bat '''
                    xcopy "%WORKSPACE%\\*" "C:\\xampp\\htdocs\\SMS" /E /I /Y
                '''
            }
        }
        
        stage('Test') {
            steps {
                echo 'Testing deployment...'
                bat '''
                    curl -I http://localhost/SMS/main.php
                '''
            }
        }
    }
    
    post {
        success {
            echo '✅ Deployment Successful!'
        }
        failure {
            echo '❌ Deployment Failed!'
        }
    }
}