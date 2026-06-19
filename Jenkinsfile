pipeline {
    agent any
    
    stages {
        stage('Checkout') {
            steps {
                echo 'STEP 1: Getting code from GitHub...'
                checkout scm
            }
        }
        
        stage('Environment Check') {
            steps {
                echo 'STEP 2: Checking environment...'
                bat 'git --version'
                bat 'php -v'
            }
        }
        
        stage('Database Backup') {
            steps {
                echo 'STEP 3: Creating database backup...'
                bat '''
                    if not exist "C:\\backup" mkdir "C:\\backup"
                    "C:\\xampp\\mysql\\bin\\mysqldump.exe" -u root sms > "C:\\backup\\sms_backup_%BUILD_NUMBER%.sql"
                '''
            }
        }
        
        stage('Run Tests') {
            steps {
                echo 'STEP 4: Running PHP syntax tests...'
                bat 'php -l "%WORKSPACE%\\main.php"'
            }
        }
        
        stage('Database Migration') {
            steps {
                echo 'STEP 5: Running database migrations...'
                bat '''
                    cd C:\\flyway-projects\\sms-migrations
                    flyway.cmd -configFiles=conf\\flyway.conf migrate
                '''
            }
        }
        
        stage('Verify Database') {
            steps {
                echo 'STEP 6: Verifying database...'
                bat '''
                    cd C:\\flyway-projects\\sms-migrations
                    flyway.cmd -configFiles=conf\\flyway.conf info
                '''
            }
        }
        
        stage('Deploy Application') {
            steps {
                echo 'STEP 7: Deploying application...'
                bat 'xcopy "%WORKSPACE%\\*" "C:\\xampp\\htdocs\\SMS" /E /I /Y'
            }
        }
        
        stage('Smoke Test') {
            steps {
                echo 'STEP 8: Testing application...'
                bat 'curl -I http://localhost/SMS/main.php'
            }
        }
        
        stage('Health Check') {
            steps {
                echo 'STEP 9: Running health check...'
                bat '"C:\\xampp\\mysql\\bin\\mysql.exe" -u root -e "USE sms; SHOW TABLES;"'
            }
        }
    }
    
    post {
        success {
            echo '✅ DEPLOYMENT SUCCESSFUL!'
        }
        failure {
            echo '❌ DEPLOYMENT FAILED!'
        }
    }
}