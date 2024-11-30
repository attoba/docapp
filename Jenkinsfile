pipeline {
    agent any

    tools {
        SonarQube 'sonar-scanner' // Replace with the name of your configured scanner in Jenkins
    }

    stages {
        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('SonarQube') { // Replace 'SonarQube' with your SonarQube server name
                    sh 'sonar-scanner'
                }
            }
        }
    }
}
