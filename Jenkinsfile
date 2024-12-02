pipeline {
    agent any
    environment {
        SCANNER_HOME = tool 'sonar-scanner' // Ensure 'sonar-scanner' matches the tool configuration name

    }

    stages {
        //stage('SonarQube Analysis') {
        //    steps {
        //        withSonarQubeEnv('SonarQube') { // Replace 'SonarQube' with your SonarQube server name
                    // Use double quotes around the path to handle spaces
        //            sh "\"$SCANNER_HOME/bin/sonar-scanner.bat\""
        //        }
        //    }
        //}

       stage('Dependency Scanning (Snyk)') {
            steps {
                withCredentials([string(credentialsId: 'snyk-token', variable: 'SNYK_TOKEN')]) {
                    sh '''
                    snyk auth $SNYK_TOKEN
                    snyk test
                    '''
                }
            }
        }
    }
}
