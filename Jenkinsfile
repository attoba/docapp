pipeline {
    agent any
	environment{
		SCANNER_HOME = tool 'sonar-scanner'
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
