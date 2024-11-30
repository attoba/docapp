pipeline {
    agent any

    stages {
        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('SonarQube') { // Replace 'SonarQube' with the name of your configured SonarQube server
					sh 'sonar-scanner'
                }
            }
        }

       
    }

}
